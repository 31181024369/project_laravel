<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCat extends Model
{
    use HasFactory;
    protected $fillable = ['name','status', 'parent_id'];
    public function categories()
    {
        return $this->hasMany(ProductCat::class, 'parent_id');
    }
    public function childrenCategories()
    {
        return $this->hasMany(ProductCat::class, 'parent_id')->with('categories');
    }

    public function parentCategories()
    {
        return $this->belongsTo(ProductCat::class, 'parent_id')->with('categories');
    }
}
