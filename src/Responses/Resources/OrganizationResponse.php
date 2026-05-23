<?php

namespace Wawaiguntang\Satusehat\Responses\Resources;

use Wawaiguntang\Satusehat\Responses\AbstractFhirResponse;
use Wawaiguntang\Satusehat\Shared\Responses\IdentifierResponse;

class OrganizationResponse extends AbstractFhirResponse
{
    public bool    $active      = true;
    public ?string $name        = null;
    public ?string $typeCode    = null;
    public ?string $typeDisplay = null;
    /** @var IdentifierResponse[] */
    public array   $identifiers = [];

    protected function mapFields(array $data): void
    {
        $this->active = $data['active'] ?? true;
        $this->name   = $data['name']   ?? null;

        $type = $data['type'][0]['coding'][0] ?? [];
        $this->typeCode    = $type['code']    ?? null;
        $this->typeDisplay = $type['display'] ?? null;

        foreach ($data['identifier'] ?? [] as $id) {
            $this->identifiers[] = IdentifierResponse::fromArray($id);
        }
    }
}
