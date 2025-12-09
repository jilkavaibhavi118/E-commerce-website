<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSku extends Model
{
    protected $fillable = ['product_id','sku','attribute','stock','price'];
    public function product() { return $this->belongsTo(Product::class); }
}
