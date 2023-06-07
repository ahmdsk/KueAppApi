<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cake extends Model
{
    use HasFactory;

    protected $fillable = ['cake_name', 'cake_image', 'cake_price', 'description', 'cake_width', 'cake_height', 'cake_id'];
}
