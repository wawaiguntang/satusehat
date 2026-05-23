<?php

namespace Wawaiguntang\Satusehat\Responses\Resources;

use Wawaiguntang\Satusehat\Responses\AbstractFhirResponse;
use Wawaiguntang\Satusehat\Shared\Responses\ReferenceResponse;

class MedicationRequestResponse extends AbstractFhirResponse
{
    public ?string            $status              = null;
    public ?string            $intent              = null;
    public ?string            $authoredOn          = null;
    public ?ReferenceResponse $subject             = null;
    public ?ReferenceResponse $encounter           = null;
    public ?ReferenceResponse $requester           = null;
    public ?ReferenceResponse $medicationReference = null;
    /** @var array[] */
    public array              $dosageInstruction   = [];

    protected function mapFields(array $data): void
    {
        $this->status     = $data['status']     ?? null;
        $this->intent     = $data['intent']     ?? null;
        $this->authoredOn = $data['authoredOn'] ?? null;

        if (isset($data['subject'])) {
            $this->subject = ReferenceResponse::fromArray($data['subject']);
        }

        if (isset($data['encounter'])) {
            $this->encounter = ReferenceResponse::fromArray($data['encounter']);
        }

        if (isset($data['requester'])) {
            $this->requester = ReferenceResponse::fromArray($data['requester']);
        }

        if (isset($data['medicationReference'])) {
            $this->medicationReference = ReferenceResponse::fromArray($data['medicationReference']);
        }

        $this->dosageInstruction = $data['dosageInstruction'] ?? [];
    }
}
