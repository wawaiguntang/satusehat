<?php

namespace Wawaiguntang\Satusehat\Responses\Resources;

use Wawaiguntang\Satusehat\Responses\AbstractFhirResponse;
use Wawaiguntang\Satusehat\Shared\Responses\ReferenceResponse;

class MedicationDispenseResponse extends AbstractFhirResponse
{
    public ?string            $status              = null;
    public ?string            $whenHandedOver      = null;
    public ?ReferenceResponse $subject             = null;
    public ?ReferenceResponse $context             = null;
    public ?ReferenceResponse $medicationReference = null;
    public ?array             $quantity            = null;
    /** @var array[] */
    public array              $dosageInstruction   = [];

    protected function mapFields(array $data): void
    {
        $this->status         = $data['status']         ?? null;
        $this->whenHandedOver = $data['whenHandedOver'] ?? null;

        if (isset($data['subject'])) {
            $this->subject = ReferenceResponse::fromArray($data['subject']);
        }

        if (isset($data['context'])) {
            $this->context = ReferenceResponse::fromArray($data['context']);
        }

        if (isset($data['medicationReference'])) {
            $this->medicationReference = ReferenceResponse::fromArray($data['medicationReference']);
        }

        $this->quantity          = $data['quantity']          ?? null;
        $this->dosageInstruction = $data['dosageInstruction'] ?? [];
    }
}
