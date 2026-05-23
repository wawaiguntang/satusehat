<?php

namespace Wawaiguntang\Satusehat\Responses\Resources;

use Wawaiguntang\Satusehat\Responses\AbstractFhirResponse;
use Wawaiguntang\Satusehat\Shared\Responses\ReferenceResponse;

class ClinicalImpressionResponse extends AbstractFhirResponse
{
    public ?string            $status      = null;
    public ?string            $description = null;
    public ?ReferenceResponse $subject     = null;
    public ?ReferenceResponse $encounter   = null;
    public ?string            $effectiveDateTime = null;
    public ?string            $date        = null;
    /** @var array[] */
    public array              $finding     = [];

    protected function mapFields(array $data): void
    {
        $this->status            = $data['status']            ?? null;
        $this->description       = $data['description']       ?? null;
        $this->effectiveDateTime = $data['effectiveDateTime'] ?? null;
        $this->date              = $data['date']              ?? null;

        if (isset($data['subject'])) {
            $this->subject = ReferenceResponse::fromArray($data['subject']);
        }

        if (isset($data['encounter'])) {
            $this->encounter = ReferenceResponse::fromArray($data['encounter']);
        }

        $this->finding = $data['finding'] ?? [];
    }
}
