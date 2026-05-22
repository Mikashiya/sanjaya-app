<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'brand',
        'category_id',
        'qty_instock',
        'price',
        'photo',
    ];

    public function detail_sales() {
        return $this->hasMany(Detail_sales::class);
    }

    public function category_product() {
        return $this->belongsTo(Category_product::class, 'category_id');
    }
}
