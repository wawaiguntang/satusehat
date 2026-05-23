<?php

namespace Wawaiguntang\Satusehat\Responses\Resources;

use Wawaiguntang\Satusehat\Responses\AbstractFhirResponse;
use Wawaiguntang\Satusehat\Shared\Responses\CodingResponse;
use Wawaiguntang\Satusehat\Shared\Responses\ReferenceResponse;

class ConditionResponse extends AbstractFhirResponse
{
    public ?CodingResponse    $clinicalStatus      = null;
    public ?CodingResponse    $verificationStatus  = null;
    public ?string            $icd10Code           = null;
    public ?string            $icd10Display        = null;
    public ?ReferenceResponse $subject             = null;
    public ?ReferenceResponse $encounter           = null;
    public ?string            $onsetDateTime       = null;
    public ?string            $recordedDate        = null;

    protected function mapFields(array $data): void
    {
        $cs = $data['clinicalStatus']['coding'][0] ?? [];
        if ($cs) {
            $this->clinicalStatus = CodingResponse::fromArray($cs);
        }

        $vs = $data['verificationStatus']['coding'][0] ?? [];
        if ($vs) {
            $this->verificationStatus = CodingResponse::fromArray($vs);
        }

        $coding = $data['code']['coding'][0] ?? [];
        $this->icd10Code    = $coding['code']    ?? null;
        $this->icd10Display = $coding['display'] ?? null;

        if (isset($data['subject'])) {
            $this->subject = ReferenceResponse::fromArray($data['subject']);
        }

        if (isset($data['encounter'])) {
            $this->encounter = ReferenceResponse::fromArray($data['encounter']);
        }

        $this->onsetDateTime = $data['onsetDateTime'] ?? null;
        $this->recordedDate  = $data['recordedDate']  ?? null;
    }
}
