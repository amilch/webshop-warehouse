<?php

namespace App\Models;

use Domain\Interfaces\ProductEntity;
use Domain\ValueObjects\MoneyValueObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia, ProductEntity
{
    use InteractsWithMedia;
    use HasFactory;

    protected $fillable = [
        'sku',
        'quantity',
        'reserved',
    ];

    protected $casts = [
        'id' => 'integer',
    ];

    // ---------------------------------------------------------------------
    // ProductEntity methods

    public function getSku(): string
    {
        return $this->attributes['sku'];
    }

    public function getQuantity(): int
    {
        return $this->attributes['quantity'];
    }

    public function getReserved(): int
    {
        return $this->attributes['reserved'];
    }
}
