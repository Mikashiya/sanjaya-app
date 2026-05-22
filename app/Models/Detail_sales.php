<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detail_sales extends Model
{
    protected $fillable = [
        'sales_id',
        'product_id',
        'sub_qty',
        'sub_price',
    ];

    public function product() {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function sale() {
        return $this->belongsTo(Sales::class, 'sales_id');
    }
}
