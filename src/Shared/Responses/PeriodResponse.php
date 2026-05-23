<?php

namespace Wawaiguntang\Satusehat\Shared\Responses;

class PeriodResponse
{
    public function __construct(
        public readonly string  $start,
        public readonly ?string $end = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            start: $data['start'] ?? '',
            end:   $data['end']   ?? null,
        );
    }
}
