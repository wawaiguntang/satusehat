<?php

namespace Wawaiguntang\Satusehat\Responses\Resources;

use Wawaiguntang\Satusehat\Responses\AbstractFhirResponse;
use Wawaiguntang\Satusehat\Shared\Responses\PeriodResponse;
use Wawaiguntang\Satusehat\Shared\Responses\ReferenceResponse;

class AccountResponse extends AbstractFhirResponse
{
    public ?string            $status        = null;
    public ?string            $name          = null;
    public ?string            $typeCode      = null;
    public ?ReferenceResponse $subject       = null;
    public ?ReferenceResponse $owner         = null;
    public ?PeriodResponse    $servicePeriod = null;
    public ?string            $description   = null;
    /** @var array[] */
    public array              $coverage      = [];

    protected function mapFields(array $data): void
    {
        $this->status      = $data['status']      ?? null;
        $this->name        = $data['name']        ?? null;
        $this->description = $data['description'] ?? null;

        $this->typeCode = $data['type']['coding'][0]['code'] ?? null;

        if (isset($data['subject'][0])) {
            $this->subject = ReferenceResponse::fromArray($data['subject'][0]);
        }

        if (isset($data['owner'])) {
            $this->owner = ReferenceResponse::fromArray($data['owner']);
        }

        if (isset($data['servicePeriod'])) {
            $this->servicePeriod = PeriodResponse::fromArray($data['servicePeriod']);
        }

        $this->coverage = $data['coverage'] ?? [];
    }
}
