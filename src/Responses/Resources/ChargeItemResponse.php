<?php

namespace Wawaiguntang\Satusehat\Responses\Resources;

use Wawaiguntang\Satusehat\Responses\AbstractFhirResponse;
use Wawaiguntang\Satusehat\Shared\Responses\PeriodResponse;
use Wawaiguntang\Satusehat\Shared\Responses\ReferenceResponse;

class ChargeItemResponse extends AbstractFhirResponse
{
    public ?string            $status              = null;
    public ?string            $codeCode            = null;
    public ?string            $codeDisplay         = null;
    public ?ReferenceResponse $subject             = null;
    public ?ReferenceResponse $context             = null;
    public ?PeriodResponse    $occurrencePeriod    = null;
    public ?array             $quantity            = null;
    /** @var array[] */
    public array              $performer           = [];
    /** @var array[] */
    public array              $account             = [];

    protected function mapFields(array $data): void
    {
        $this->status = $data['status'] ?? null;

        $code = $data['code']['coding'][0] ?? [];
        $this->codeCode    = $code['code']    ?? null;
        $this->codeDisplay = $code['display'] ?? null;

        if (isset($data['subject'])) {
            $this->subject = ReferenceResponse::fromArray($data['subject']);
        }

        if (isset($data['context'])) {
            $this->context = ReferenceResponse::fromArray($data['context']);
        }

        if (isset($data['occurrencePeriod'])) {
            $this->occurrencePeriod = PeriodResponse::fromArray($data['occurrencePeriod']);
        }

        $this->quantity  = $data['quantity']  ?? null;
        $this->performer = $data['performer'] ?? [];
        $this->account   = $data['account']   ?? [];
    }
}
