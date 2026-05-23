<?php

namespace Wawaiguntang\Satusehat\Responses\Resources;

use Wawaiguntang\Satusehat\Responses\AbstractFhirResponse;
use Wawaiguntang\Satusehat\Shared\Responses\ReferenceResponse;

class DiagnosticReportResponse extends AbstractFhirResponse
{
    public ?string            $status           = null;
    public ?string            $categoryCode     = null;
    public ?string            $code             = null;
    public ?string            $codeDisplay      = null;
    public ?ReferenceResponse $subject          = null;
    public ?ReferenceResponse $encounter        = null;
    public ?string            $effectiveDateTime = null;
    public ?string            $issued           = null;
    /** @var array[] */
    public array              $result           = [];
    /** @var array[] */
    public array              $media            = [];

    protected function mapFields(array $data): void
    {
        $this->status            = $data['status']            ?? null;
        $this->effectiveDateTime = $data['effectiveDateTime'] ?? null;
        $this->issued            = $data['issued']            ?? null;

        $this->categoryCode = $data['category'][0]['coding'][0]['code'] ?? null;

        $code = $data['code']['coding'][0] ?? [];
        $this->code        = $code['code']    ?? null;
        $this->codeDisplay = $code['display'] ?? null;

        if (isset($data['subject'])) {
            $this->subject = ReferenceResponse::fromArray($data['subject']);
        }

        if (isset($data['encounter'])) {
            $this->encounter = ReferenceResponse::fromArray($data['encounter']);
        }

        $this->result = $data['result'] ?? [];
        $this->media  = $data['media']  ?? [];
    }
}
