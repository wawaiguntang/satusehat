<?php

namespace Wawaiguntang\Satusehat\Shared\Responses;

class CodingResponse
{
    public function __construct(
        public readonly ?string $system,
        public readonly ?string $code,
        public readonly ?string $display,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            system:  $data['system']  ?? null,
            code:    $data['code']    ?? null,
            display: $data['display'] ?? null,
        );
    }
}
