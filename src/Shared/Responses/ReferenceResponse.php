<?php

namespace Wawaiguntang\Satusehat\Shared\Responses;

class ReferenceResponse
{
    public function __construct(
        public readonly string  $reference,
        public readonly ?string $display = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            reference: $data['reference'] ?? '',
            display:   $data['display']   ?? null,
        );
    }
}
