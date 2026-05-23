<?php

namespace Wawaiguntang\Satusehat\Responses\Resources;

use Wawaiguntang\Satusehat\Responses\AbstractFhirResponse;
use Wawaiguntang\Satusehat\Shared\Responses\ReferenceResponse;

class AllergyIntoleranceResponse extends AbstractFhirResponse
{
    public ?string            $clinicalStatusCode = null;
    public ?string            $type               = null;
    public ?string            $category           = null;
    public ?string            $criticality        = null;
    public ?string            $codeDisplay        = null;
    public ?ReferenceResponse $patient            = null;
    public ?ReferenceResponse $encounter          = null;
    public ?string            $recordedDate       = null;
    /** @var array[] */
    public array              $reaction           = [];

    protected function mapFields(array $data): void
    {
        $this->clinicalStatusCode = $data['clinicalStatus']['coding'][0]['code'] ?? null;
        $this->type               = $data['type']        ?? null;
        $this->category           = $data['category'][0] ?? null;
        $this->criticality        = $data['criticality'] ?? null;
        $this->codeDisplay        = $data['code']['coding'][0]['display'] ?? null;
        $this->recordedDate       = $data['recordedDate'] ?? null;

        if (isset($data['patient'])) {
            $this->patient = ReferenceResponse::fromArray($data['patient']);
        }

        if (isset($data['encounter'])) {
            $this->encounter = ReferenceResponse::fromArray($data['encounter']);
        }

        $this->reaction = $data['reaction'] ?? [];
    }
}
