<?php

namespace Wawaiguntang\Satusehat\Shared\Responses;

class MoneyResponse
{
    public function __construct(
        public readonly float|int $value,
        public readonly string    $currency,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            value:    $data['value']    ?? 0,
            currency: $data['currency'] ?? 'IDR',
        );
    }
}
