<?php

namespace Wawaiguntang\Satusehat\Responses\Resources;

use Wawaiguntang\Satusehat\Responses\AbstractFhirResponse;
use Wawaiguntang\Satusehat\Shared\Responses\ReferenceResponse;

class ImmunizationResponse extends AbstractFhirResponse
{
    public ?string            $status              = null;
    public ?string            $vaccineCode         = null;
    public ?string            $vaccineDisplay      = null;
    public ?ReferenceResponse $patient             = null;
    public ?ReferenceResponse $encounter           = null;
    public ?string            $occurrenceDateTime  = null;
    public bool               $primarySource       = true;
    public ?string            $lotNumber           = null;
    /** @var array[] */
    public array              $performer           = [];

    protected function mapFields(array $data): void
    {
        $this->status             = $data['status']             ?? null;
        $this->occurrenceDateTime = $data['occurrenceDateTime'] ?? null;
        $this->primarySource      = $data['primarySource']      ?? true;
        $this->lotNumber          = $data['lotNumber']          ?? null;

        $vaccine = $data['vaccineCode']['coding'][0] ?? [];
        $this->vaccineCode    = $vaccine['code']    ?? null;
        $this->vaccineDisplay = $vaccine['display'] ?? null;

        if (isset($data['patient'])) {
            $this->patient = ReferenceResponse::fromArray($data['patient']);
        }

        if (isset($data['encounter'])) {
            $this->encounter = ReferenceResponse::fromArray($data['encounter']);
        }

        $this->performer = $data['performer'] ?? [];
    }
}
