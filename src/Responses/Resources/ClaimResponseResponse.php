<?php

namespace Wawaiguntang\Satusehat\Responses\Resources;

use Wawaiguntang\Satusehat\Responses\AbstractFhirResponse;
use Wawaiguntang\Satusehat\Shared\Responses\MoneyResponse;
use Wawaiguntang\Satusehat\Shared\Responses\ReferenceResponse;

class ClaimResponseResponse extends AbstractFhirResponse
{
    public ?string            $status    = null;
    public ?string            $use       = null;
    public ?string            $outcome   = null;
    public ?string            $created   = null;
    public ?ReferenceResponse $patient   = null;
    public ?ReferenceResponse $insurer   = null;
    public ?ReferenceResponse $requestor = null;
    public ?ReferenceResponse $request   = null;
    /** @var array[] */
    public array              $adjudication = [];
    /** @var array[] */
    public array              $total        = [];
    public ?array             $payment      = null;

    protected function mapFields(array $data): void
    {
        $this->status  = $data['status']  ?? null;
        $this->use     = $data['use']     ?? null;
        $this->outcome = $data['outcome'] ?? null;
        $this->created = $data['created'] ?? null;

        if (isset($data['patient'])) {
            $this->patient = ReferenceResponse::fromArray($data['patient']);
        }

        if (isset($data['insurer'])) {
            $this->insurer = ReferenceResponse::fromArray($data['insurer']);
        }

        if (isset($data['requestor'])) {
            $this->requestor = ReferenceResponse::fromArray($data['requestor']);
        }

        if (isset($data['request'])) {
            $this->request = ReferenceResponse::fromArray($data['request']);
        }

        $this->adjudication = $data['adjudication'] ?? [];
        $this->total        = $data['total']        ?? [];
        $this->payment      = $data['payment']      ?? null;
    }
}
