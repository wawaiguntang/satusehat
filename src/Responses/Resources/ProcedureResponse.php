<?php

namespace Wawaiguntang\Satusehat\Responses\Resources;

use Wawaiguntang\Satusehat\Responses\AbstractFhirResponse;
use Wawaiguntang\Satusehat\Shared\Responses\ReferenceResponse;

class ProcedureResponse extends AbstractFhirResponse
{
    public ?string            $status              = null;
    public ?string            $procedureCode       = null;
    public ?string            $procedureDisplay    = null;
    public ?ReferenceResponse $subject             = null;
    public ?ReferenceResponse $encounter           = null;
    public ?string            $performedDateTime   = null;
    /** @var array[] */
    public array              $performer           = [];

    protected function mapFields(array $data): void
    {
        $this->status = $data['status'] ?? null;

        $code = $data['code']['coding'][0] ?? [];
        $this->procedureCode    = $code['code']    ?? null;
        $this->procedureDisplay = $code['display'] ?? null;

        if (isset($data['subject'])) {
            $this->subject = ReferenceResponse::fromArray($data['subject']);
        }

        if (isset($data['encounter'])) {
            $this->encounter = ReferenceResponse::fromArray($data['encounter']);
        }

        $this->performedDateTime = $data['performedDateTime']
            ?? $data['performedPeriod']['start']
            ?? null;

        $this->performer = $data['performer'] ?? [];
    }
}
