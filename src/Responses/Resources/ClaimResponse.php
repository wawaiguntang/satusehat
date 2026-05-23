<?php

namespace Wawaiguntang\Satusehat\Responses\Resources;

use Wawaiguntang\Satusehat\Responses\AbstractFhirResponse;
use Wawaiguntang\Satusehat\Shared\Responses\IdentifierResponse;
use Wawaiguntang\Satusehat\Shared\Responses\PeriodResponse;
use Wawaiguntang\Satusehat\Shared\Responses\ReferenceResponse;

class ClaimResponse extends AbstractFhirResponse
{
    public ?string            $status          = null;
    public ?string            $use             = null;
    public ?string            $created         = null;
    public ?ReferenceResponse $patient         = null;
    public ?ReferenceResponse $insurer         = null;
    public ?ReferenceResponse $provider        = null;
    public ?ReferenceResponse $facility        = null;
    public ?PeriodResponse    $billablePeriod  = null;
    /** @var IdentifierResponse[] */
    public array              $identifiers     = [];
    /** @var array[] */
    public array              $diagnosis       = [];
    /** @var array[] */
    public array              $item            = [];

    protected function mapFields(array $data): void
    {
        $this->status  = $data['status']  ?? null;
        $this->use     = $data['use']     ?? null;
        $this->created = $data['created'] ?? null;

        if (isset($data['patient'])) {
            $this->patient = ReferenceResponse::fromArray($data['patient']);
        }

        if (isset($data['insurer'])) {
            $this->insurer = ReferenceResponse::fromArray($data['insurer']);
        }

        if (isset($data['provider'])) {
            $this->provider = ReferenceResponse::fromArray($data['provider']);
        }

        if (isset($data['facility'])) {
            $this->facility = ReferenceResponse::fromArray($data['facility']);
        }

        if (isset($data['billablePeriod'])) {
            $this->billablePeriod = PeriodResponse::fromArray($data['billablePeriod']);
        }

        foreach ($data['identifier'] ?? [] as $id) {
            $this->identifiers[] = IdentifierResponse::fromArray($id);
        }

        $this->diagnosis = $data['diagnosis'] ?? [];
        $this->item      = $data['item']      ?? [];
    }
}
