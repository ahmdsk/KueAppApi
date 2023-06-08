<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = ['voucher_code', 'voucher_name', 'voucher_image'];

    public function order(): HasMany {
        return $this->hasMany(Order::class);
    }
}
