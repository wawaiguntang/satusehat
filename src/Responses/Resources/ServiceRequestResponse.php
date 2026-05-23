<?php

namespace Wawaiguntang\Satusehat\Responses\Resources;

use Wawaiguntang\Satusehat\Responses\AbstractFhirResponse;
use Wawaiguntang\Satusehat\Shared\Responses\ReferenceResponse;

class ServiceRequestResponse extends AbstractFhirResponse
{
    public ?string            $status              = null;
    public ?string            $intent              = null;
    public ?string            $priority            = null;
    public ?string            $loincCode           = null;
    public ?string            $loincDisplay        = null;
    public ?ReferenceResponse $subject             = null;
    public ?ReferenceResponse $encounter           = null;
    public ?string            $occurrenceDateTime  = null;
    public ?string            $authoredOn          = null;
    public ?ReferenceResponse $requester           = null;

    protected function mapFields(array $data): void
    {
        $this->status   = $data['status']   ?? null;
        $this->intent   = $data['intent']   ?? null;
        $this->priority = $data['priority'] ?? null;

        $code = $data['code']['coding'][0] ?? [];
        $this->loincCode    = $code['code']    ?? null;
        $this->loincDisplay = $code['display'] ?? null;

        if (isset($data['subject'])) {
            $this->subject = ReferenceResponse::fromArray($data['subject']);
        }

        if (isset($data['encounter'])) {
            $this->encounter = ReferenceResponse::fromArray($data['encounter']);
        }

        $this->occurrenceDateTime = $data['occurrenceDateTime'] ?? null;
        $this->authoredOn         = $data['authoredOn']         ?? null;

        if (isset($data['requester'])) {
            $this->requester = ReferenceResponse::fromArray($data['requester']);
        }
    }
}
