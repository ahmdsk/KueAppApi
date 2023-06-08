<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['status', 'quantity', 'price', 'user_id', 'cake_id', 'store_id', 'voucher_id', 'payment_id'];
}
