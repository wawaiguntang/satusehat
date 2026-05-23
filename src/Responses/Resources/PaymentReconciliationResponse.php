<?php

namespace Wawaiguntang\Satusehat\Responses\Resources;

use Wawaiguntang\Satusehat\Responses\AbstractFhirResponse;
use Wawaiguntang\Satusehat\Shared\Responses\MoneyResponse;
use Wawaiguntang\Satusehat\Shared\Responses\PeriodResponse;
use Wawaiguntang\Satusehat\Shared\Responses\ReferenceResponse;

class PaymentReconciliationResponse extends AbstractFhirResponse
{
    public ?string            $status         = null;
    public ?string            $outcome        = null;
    public ?string            $disposition    = null;
    public ?string            $created        = null;
    public ?string            $paymentDate    = null;
    public ?MoneyResponse     $paymentAmount  = null;
    public ?PeriodResponse    $period         = null;
    public ?ReferenceResponse $paymentIssuer  = null;
    public ?ReferenceResponse $requestor      = null;
    /** @var array[] */
    public array              $detail         = [];

    protected function mapFields(array $data): void
    {
        $this->status      = $data['status']      ?? null;
        $this->outcome     = $data['outcome']      ?? null;
        $this->disposition = $data['disposition']  ?? null;
        $this->created     = $data['created']      ?? null;
        $this->paymentDate = $data['paymentDate']  ?? null;

        if (isset($data['paymentAmount'])) {
            $this->paymentAmount = MoneyResponse::fromArray($data['paymentAmount']);
        }

        if (isset($data['period'])) {
            $this->period = PeriodResponse::fromArray($data['period']);
        }

        if (isset($data['paymentIssuer'])) {
            $this->paymentIssuer = ReferenceResponse::fromArray($data['paymentIssuer']);
        }

        if (isset($data['requestor'])) {
            $this->requestor = ReferenceResponse::fromArray($data['requestor']);
        }

        $this->detail = $data['detail'] ?? [];
    }
}
