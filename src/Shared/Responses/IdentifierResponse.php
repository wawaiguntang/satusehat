<?php

namespace Wawaiguntang\Satusehat\Shared\Responses;

class IdentifierResponse
{
    public function __construct(
        public readonly ?string $system,
        public readonly ?string $value,
        public readonly ?string $use = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            system: $data['system'] ?? null,
            value:  $data['value']  ?? null,
            use:    $data['use']    ?? null,
        );
    }
}
