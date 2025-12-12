<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Product extends Model
{

    protected $fillable = ['name','slug','category_id','subcategory_id','description','price','status'];

    public function skus() {
        return $this->hasMany(ProductSku::class);
    }


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }



    }

