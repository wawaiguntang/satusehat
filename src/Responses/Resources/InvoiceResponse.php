<?php

namespace Wawaiguntang\Satusehat\Responses\Resources;

use Wawaiguntang\Satusehat\Responses\AbstractFhirResponse;
use Wawaiguntang\Satusehat\Shared\Responses\MoneyResponse;
use Wawaiguntang\Satusehat\Shared\Responses\ReferenceResponse;

class InvoiceResponse extends AbstractFhirResponse
{
    public ?string            $status      = null;
    public ?string            $date        = null;
    public ?ReferenceResponse $subject     = null;
    public ?ReferenceResponse $issuer      = null;
    public ?ReferenceResponse $account     = null;
    public ?MoneyResponse     $totalNet    = null;
    public ?MoneyResponse     $totalGross  = null;
    /** @var array[] */
    public array              $lineItem    = [];

    protected function mapFields(array $data): void
    {
        $this->status = $data['status'] ?? null;
        $this->date   = $data['date']   ?? null;

        if (isset($data['subject'])) {
            $this->subject = ReferenceResponse::fromArray($data['subject']);
        }

        if (isset($data['issuer'])) {
            $this->issuer = ReferenceResponse::fromArray($data['issuer']);
        }

        if (isset($data['account'])) {
            $this->account = ReferenceResponse::fromArray($data['account']);
        }

        if (isset($data['totalNet'])) {
            $this->totalNet = MoneyResponse::fromArray($data['totalNet']);
        }

        if (isset($data['totalGross'])) {
            $this->totalGross = MoneyResponse::fromArray($data['totalGross']);
        }

        $this->lineItem = $data['lineItem'] ?? [];
    }
}
