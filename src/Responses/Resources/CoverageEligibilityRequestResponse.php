<?php

namespace Wawaiguntang\Satusehat\Responses\Resources;

use Wawaiguntang\Satusehat\Responses\AbstractFhirResponse;
use Wawaiguntang\Satusehat\Shared\Responses\IdentifierResponse;
use Wawaiguntang\Satusehat\Shared\Responses\ReferenceResponse;

class CoverageEligibilityRequestResponse extends AbstractFhirResponse
{
    public ?string            $status    = null;
    public ?string            $created   = null;
    public ?ReferenceResponse $patient   = null;
    public ?ReferenceResponse $insurer   = null;
    public ?ReferenceResponse $provider  = null;
    /** @var IdentifierResponse[] */
    public array              $identifiers = [];

    protected function mapFields(array $data): void
    {
        $this->status  = $data['status']  ?? null;
        $this->created = $data['created'] ?? null;

        if (isset($data['patient'])) {
            $this->patient = ReferenceResponse::fromArray($data['patient']);
        }

        if (isset($data['insurer'])) {
            $this->insurer = ReferenceResponse::fromArray($data['insurer']);
        }

        if (isset($data['provider'])) {
            $this->provider = ReferenceResponse::fromArray($data['provider']);
        }

        foreach ($data['identifier'] ?? [] as $id) {
            $this->identifiers[] = IdentifierResponse::fromArray($id);
        }
    }
}
