<?php

namespace Wawaiguntang\Satusehat\Responses\Resources;

use Wawaiguntang\Satusehat\Responses\AbstractFhirResponse;
use Wawaiguntang\Satusehat\Shared\Responses\ReferenceResponse;

class LocationResponse extends AbstractFhirResponse
{
    public ?string            $status             = null;
    public ?string            $name               = null;
    public ?string            $description        = null;
    public ?string            $mode               = null;
    public ?ReferenceResponse $managingOrganization = null;

    protected function mapFields(array $data): void
    {
        $this->status      = $data['status']      ?? null;
        $this->name        = $data['name']        ?? null;
        $this->description = $data['description'] ?? null;
        $this->mode        = $data['mode']        ?? null;

        if (isset($data['managingOrganization'])) {
            $this->managingOrganization = ReferenceResponse::fromArray($data['managingOrganization']);
        }
    }
}
