<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price',
        'thumbnail_path',
        'stock',
        'colors',
        'sizes',
        'brand',
        'manufacturing_country',
        'weight',
        'length',
        'breadth',
        'width',
    ];

    protected $with = [
        'media',
        'categories',
        'diseases'
    ];

    protected $casts = [
        'sizes' => 'array',
        'colors' => 'array'
    ];

    protected $appends = ['thumbnail_url'];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'product_category', 'product_id', 'category_id');
    }

    public function media(): BelongsToMany
    {
        return $this->belongsToMany(Media::class);
    }

    public function diseases(): BelongsToMany
    {
        return $this->belongsToMany(Disease::class);
    }

    public function scopeFilter(Builder $query, Request $request)
    {
        $request->whenFilled('search', fn() => $query->whereFullText(['title', 'description'], $request->query('search')));
        $request->whenFilled('price_gte', fn() => $query->where('price', '>=', $request->query('price_gte')));
        $request->whenFilled('price_lte', fn() => $query->where('price', '<=', $request->query('price_lte')));
        $request->whenFilled('brand', fn() => $query->where('brand', '=', $request->query('brand')));
        $request->whenFilled('manufacturing_country', fn() => $query->where('manufacturing_country', '=', $request->query('manufacturing_country')));
        $request->whenFilled('weight', fn() => $query->where('weight', '=', $request->query('weight')));
        $request->whenFilled('length', fn() => $query->where('length', '=', $request->query('length')));
        $request->whenFilled('breadth', fn() => $query->where('breadth', '=', $request->query('breadth')));
        $request->whenFilled('width', fn() => $query->where('width', '=', $request->query('width')));

        $request->whenFilled('colors', function() use ($query, $request) {
            $colors = $request->query('colors');
            if (!is_array($colors)) {
                return;
            }

            $query->whereJsonContains('colors', $colors);
        });

        $request->whenFilled('sizes', function() use ($query, $request) {
            $sizes = $request->query('sizes');
            if (!is_array($sizes)) {
                return;
            }

            $query->whereJsonContains('sizes', $sizes);
        });

        $request->whenFilled('in_stock', function() use($request, $query) {
            $inStock = $request->query('in_stock');
            if ($inStock === true) {
                $query->where('stock', '>=', 1);;
            }

            if ($inStock === false) {
                $query->where('stock', '=', 0);;
            }
        });

        $request->whenFilled('categories', function () use($request, $query) {
            $categories = $request->query('categories');
            if (!is_array($categories)) {
                return;
            }

            $query->whereHas('categories', function (Builder $query) use ($categories) {
                $query->whereIn('category_id', $categories);
            },'=', count($categories));
        });

        $request->whenFilled('diseases', function() use($request, $query) {
            $diseases = $request->query('diseases');
            if (!is_array($diseases)) {
                return;
            }

            $query->whereHas('diseases', function(Builder $query) use($diseases) {
                    $query->whereIn('disease_id', $diseases);
            }, '=', count($diseases));
        });

        return $query;
    }

    public function getThumbnailUrlAttribute() {
        return Storage::url($this->thumbnail_path);
    }

    public function cartItems(): HasMany
    {
        return $this->HasMany(CartItem::class);
    }
}
