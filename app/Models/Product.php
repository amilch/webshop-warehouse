<?php

namespace App\Models;

use Domain\Entities\Product\AvailableQuantityGetter;
use Domain\Entities\Product\ProductEntity;
use Domain\Entities\Product\QuantityReservedSetter;
use Domain\Entities\Product\ReserveCountCall;
use Domain\ValueObjects\MoneyValueObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    private AvailableQuantityGetter $availableQuantityGetter;
    private QuantityReservedSetter $quantityReservedSetter;
    private ReserveCountCall $reserveCountCall;

    public function __construct(
        array $attributes = []
    ) {
        parent::__construct($attributes);
        $this->availableQuantityGetter = app()->makeWith(AvailableQuantityGetter::class, ['product' => $this]);
        $this->quantityReservedSetter = app()->makeWith(QuantityReservedSetter::class, ['product' => $this]);
        $this->reserveCountCall = app()->makeWith(ReserveCountCall::class, ['product' => $this]);
    }

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

    public function getAvailableQuantity(): int
    {
        return $this->availableQuantityGetter->get();
    }

    public function reserve(int $count): void
    {
        $this->reserved = $this->reserveCountCall->set($count);
        $this->save();
    }

    public function setQuantityReserved(int $quantity, int $reserved): void
    {
        $res = $this->quantityReservedSetter->set($quantity, $reserved);
        $this->quantity = $res[0];
        $this->reserved = $res[1];
        $this->save();
    }
}
