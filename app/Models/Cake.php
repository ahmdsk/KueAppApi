<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cake extends Model
{
    use HasFactory;

    protected $fillable = ['cake_name', 'cake_image', 'cake_price', 'description', 'cake_width', 'cake_height', 'cake_id'];

    public function order(): HasMany {
        return $this->hasMany(Order::class);
    }
}
