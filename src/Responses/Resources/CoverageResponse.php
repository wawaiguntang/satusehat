<?php

namespace Wawaiguntang\Satusehat\Responses\Resources;

use Wawaiguntang\Satusehat\Responses\AbstractFhirResponse;
use Wawaiguntang\Satusehat\Shared\Responses\IdentifierResponse;
use Wawaiguntang\Satusehat\Shared\Responses\PeriodResponse;
use Wawaiguntang\Satusehat\Shared\Responses\ReferenceResponse;

class CoverageResponse extends AbstractFhirResponse
{
    public ?string            $status        = null;
    public ?string            $typeCode      = null;
    public ?string            $typeDisplay   = null;
    public ?ReferenceResponse $subscriber    = null;
    public ?string            $subscriberId  = null;
    public ?ReferenceResponse $beneficiary   = null;
    public ?ReferenceResponse $payor         = null;
    public ?PeriodResponse    $period        = null;
    /** @var IdentifierResponse[] */
    public array              $identifiers   = [];

    protected function mapFields(array $data): void
    {
        $this->status = $data['status'] ?? null;

        $type = $data['type']['coding'][0] ?? [];
        $this->typeCode    = $type['code']    ?? null;
        $this->typeDisplay = $type['display'] ?? null;

        if (isset($data['subscriber'])) {
            $this->subscriber = ReferenceResponse::fromArray($data['subscriber']);
        }

        $this->subscriberId = $data['subscriberId'] ?? null;

        if (isset($data['beneficiary'])) {
            $this->beneficiary = ReferenceResponse::fromArray($data['beneficiary']);
        }

        if (isset($data['payor'][0])) {
            $this->payor = ReferenceResponse::fromArray($data['payor'][0]);
        }

        if (isset($data['period'])) {
            $this->period = PeriodResponse::fromArray($data['period']);
        }

        foreach ($data['identifier'] ?? [] as $id) {
            $this->identifiers[] = IdentifierResponse::fromArray($id);
        }
    }
}
