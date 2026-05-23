<?php

namespace Wawaiguntang\Satusehat\Responses\Resources;

use Wawaiguntang\Satusehat\Responses\AbstractFhirResponse;
use Wawaiguntang\Satusehat\Shared\Responses\CodingResponse;
use Wawaiguntang\Satusehat\Shared\Responses\ReferenceResponse;

class ObservationResponse extends AbstractFhirResponse
{
    public ?string            $status              = null;
    public ?CodingResponse    $category            = null;
    public ?string            $loincCode           = null;
    public ?string            $loincDisplay        = null;
    public ?ReferenceResponse $subject             = null;
    public ?ReferenceResponse $encounter           = null;
    public ?string            $effectiveDateTime   = null;
    public ?string            $issued              = null;
    public mixed              $valueQuantity       = null;
    public mixed              $valueCodeableConcept = null;
    public mixed              $valueString         = null;
    public ?string            $bodySiteCode        = null;
    /** @var array[] */
    public array              $component           = [];

    protected function mapFields(array $data): void
    {
        $this->status            = $data['status']            ?? null;
        $this->effectiveDateTime = $data['effectiveDateTime'] ?? null;
        $this->issued            = $data['issued']            ?? null;

        $cat = $data['category'][0]['coding'][0] ?? [];
        if ($cat) {
            $this->category = CodingResponse::fromArray($cat);
        }

        $code = $data['code']['coding'][0] ?? [];
        $this->loincCode    = $code['code']    ?? null;
        $this->loincDisplay = $code['display'] ?? null;

        if (isset($data['subject'])) {
            $this->subject = ReferenceResponse::fromArray($data['subject']);
        }

        if (isset($data['encounter'])) {
            $this->encounter = ReferenceResponse::fromArray($data['encounter']);
        }

        $this->valueQuantity        = $data['valueQuantity']        ?? null;
        $this->valueCodeableConcept = $data['valueCodeableConcept'] ?? null;
        $this->valueString          = $data['valueString']          ?? null;
        $this->bodySiteCode         = $data['bodySite']['coding'][0]['code'] ?? null;
        $this->component            = $data['component'] ?? [];
    }
}
