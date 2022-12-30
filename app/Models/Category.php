<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'disabled' => 'boolean'
    ];

    public const ENABLED = 0;
    public const DISABLED = 1;

    public function parent() {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children() {
        return $this->hasMany(Category::class, 'parent_id', 'id') ;
    }

    public function childrenRecursive() {
        return $this->children()->with('childrenRecursive');
    }

    public function products() {
        return $this->belongsToMany(Product::class, 'product_category', 'category_id', 'product_id');
    }
}
