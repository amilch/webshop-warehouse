<?php

namespace App\Models;

use Domain\Interfaces\ProductEntity;
use Domain\ValueObjects\MoneyValueObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;

class Product extends Model implements ProductEntity
{
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

    public function setReserved(int $new): void
    {
        $this->attributes['reserved']  = $new;
        $this->save();
    }
}
