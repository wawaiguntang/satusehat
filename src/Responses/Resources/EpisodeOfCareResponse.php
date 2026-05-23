<?php

namespace Wawaiguntang\Satusehat\Responses\Resources;

use Wawaiguntang\Satusehat\Responses\AbstractFhirResponse;
use Wawaiguntang\Satusehat\Shared\Responses\PeriodResponse;
use Wawaiguntang\Satusehat\Shared\Responses\ReferenceResponse;

class EpisodeOfCareResponse extends AbstractFhirResponse
{
    public ?string            $status              = null;
    public ?ReferenceResponse $patient             = null;
    public ?ReferenceResponse $managingOrganization = null;
    public ?PeriodResponse    $period              = null;
    /** @var array[] */
    public array              $diagnosis           = [];

    protected function mapFields(array $data): void
    {
        $this->status = $data['status'] ?? null;

        if (isset($data['patient'])) {
            $this->patient = ReferenceResponse::fromArray($data['patient']);
        }

        if (isset($data['managingOrganization'])) {
            $this->managingOrganization = ReferenceResponse::fromArray($data['managingOrganization']);
        }

        if (isset($data['period'])) {
            $this->period = PeriodResponse::fromArray($data['period']);
        }

        $this->diagnosis = $data['diagnosis'] ?? [];
    }
}
