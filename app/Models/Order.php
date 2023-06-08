<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['status', 'quantity', 'price', 'user_id', 'cake_id', 'store_id', 'voucher_id', 'payment_id'];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function cake(): BelongsTo {
        return $this->belongsTo(Cake::class);
    }

    public function store(): BelongsTo {
        return $this->belongsTo(Store::class);
    }

    public function voucher(): BelongsTo {
        return $this->belongsTo(Voucher::class);
    }

    public function payment(): BelongsTo {
        return $this->belongsTo(Payment::class);
    }
}
