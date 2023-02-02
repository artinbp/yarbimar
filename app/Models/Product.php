<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

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
        'color',
        'size',
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

    public function scopeFilter(Builder $builder, Request $request)
    {
        $request->whenFilled('search', fn() => $builder->whereFullText(['title', 'description'], $request->query('search')));
        $request->whenFilled('price_gte', fn() => $builder->where('price', '>=', $request->query('gte')));
        $request->whenFilled('price_lte', fn() => $builder->where('price', '<=', $request->query('lte')));
        $request->whenFilled('color', fn() => $builder->where('color', '=', $request->query('color')));
        $request->whenFilled('size', fn() => $builder->where('size', '=', $request->query('size')));
        $request->whenFilled('brand', fn() => $builder->where('brand', '=', $request->query('brand')));
        $request->whenFilled('manufacturing_country', fn() => $builder->where('manufacturing_country', '=', $request->query('manufacturing_country')));
        $request->whenFilled('weight', fn() => $builder->where('weight', '=', $request->query('weight')));
        $request->whenFilled('length', fn() => $builder->where('length', '=', $request->query('length')));
        $request->whenFilled('breadth', fn() => $builder->where('breadth', '=', $request->query('breadth')));
        $request->whenFilled('width', fn() => $builder->where('width', '=', $request->query('width')));

        $request->whenFilled('in_stock', function() use($request, $builder) {
            $inStock = $request->query('in_stock');
            if ($inStock === true) {
                $builder->where('stock', '>=', 1);;
            }

            if ($inStock === false) {
                $builder->where('stock', '=', 0);;
            }
        });

        $request->whenFilled('categories', function () use($request, $builder) {
            $categories = $request->query('categories');
            if (!is_array($categories)) {
                return;
            }

            $builder->whereHas('categories', function (Builder $builder) use ($categories) {
                    $builder->whereIn('category_id', $categories);
            },'=', count($categories));
        });

        $request->whenFilled('diseases', function() use($request, $builder) {
            $diseases = $request->query('diseases');
            if (!is_array($diseases)) {
                return;
            }

            $builder->whereHas('diseases', function(Builder $query) use($diseases) {
                    $query->whereIn('disease_id', $diseases);
            }, '=', count($diseases));
        });

        return $builder;
    }

    public function getThumbnailUrlAttribute() {
        return Storage::url($this->thumbnail_path);
    }

    public function cartItems(): HasMany
    {
        return $this->HasMany(CartItem::class);
    }
}
