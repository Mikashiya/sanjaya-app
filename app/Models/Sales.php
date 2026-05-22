<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    protected $fillable = [
        'date_sales',
        'customer_id',
        'total_qty',
        'total_price',
        'user_id',
    ];

    public function customer() {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function user_sales() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function detail_sales() {
        return $this->hasMany(Detail_sales::class);
    }
}
