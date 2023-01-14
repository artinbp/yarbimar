<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
    ];

    protected $with = [
        'media',
        'categories',
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

    public function scopeFilter(Builder $builder, Request $request)
    {
        if ($request->has('search')) {
            $builder->whereFullText(['title', 'description'], $request->input('search'));
        }

        if ($request->has('gte')) {
            $builder->where('price', '>=', $request->input('gte'));
        }

        if ($request->has('lte')) {
            $builder->where('price', '<=', $request->input('lte'));
        }

        if ($request->has('in_stock') && $request->input('in_stock') == true) {
            $builder->where('stock', '>=', 1);
        }

        if ($request->has('categories') && is_array($request->input('categories'))) {
            foreach($request->categories as $category) {
                $builder->orWhereRelation('categories', 'category_id', '=', $category);
            }
        }

        return $builder;
    }

    public function getThumbnailUrlAttribute() {
        return Storage::url($this->thumbnail_path);
    }
}
