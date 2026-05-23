<?php

namespace Wawaiguntang\Satusehat\Responses\Resources;

use Wawaiguntang\Satusehat\Responses\AbstractFhirResponse;
use Wawaiguntang\Satusehat\Shared\Responses\MoneyResponse;
use Wawaiguntang\Satusehat\Shared\Responses\ReferenceResponse;

class PaymentNoticeResponse extends AbstractFhirResponse
{
    public ?string            $status              = null;
    public ?string            $created             = null;
    public ?string            $paymentDate         = null;
    public ?ReferenceResponse $request             = null;
    public ?ReferenceResponse $response            = null;
    public ?ReferenceResponse $provider            = null;
    public ?ReferenceResponse $payee               = null;
    public ?ReferenceResponse $recipient           = null;
    public ?MoneyResponse     $amount              = null;
    public ?string            $paymentStatusCode   = null;

    protected function mapFields(array $data): void
    {
        $this->status      = $data['status']      ?? null;
        $this->created     = $data['created']     ?? null;
        $this->paymentDate = $data['paymentDate'] ?? null;

        if (isset($data['request'])) {
            $this->request = ReferenceResponse::fromArray($data['request']);
        }

        if (isset($data['response'])) {
            $this->response = ReferenceResponse::fromArray($data['response']);
        }

        if (isset($data['provider'])) {
            $this->provider = ReferenceResponse::fromArray($data['provider']);
        }

        if (isset($data['payee'])) {
            $this->payee = ReferenceResponse::fromArray($data['payee']);
        }

        if (isset($data['recipient'])) {
            $this->recipient = ReferenceResponse::fromArray($data['recipient']);
        }

        if (isset($data['amount'])) {
            $this->amount = MoneyResponse::fromArray($data['amount']);
        }

        $this->paymentStatusCode = $data['paymentStatus']['coding'][0]['code'] ?? null;
    }
}
