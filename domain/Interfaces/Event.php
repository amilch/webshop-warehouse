<?php

namespace Domain\Interfaces;

interface Event
{
    public static function fromArray(array $data): self;

    public function toArray(): array;
}
