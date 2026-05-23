<?php

namespace Wawaiguntang\Satusehat\Responses\Resources;

use Wawaiguntang\Satusehat\Responses\AbstractFhirResponse;
use Wawaiguntang\Satusehat\Shared\Responses\PeriodResponse;
use Wawaiguntang\Satusehat\Shared\Responses\ReferenceResponse;

class CarePlanResponse extends AbstractFhirResponse
{
    public ?string            $status    = null;
    public ?string            $intent    = null;
    public ?string            $title     = null;
    public ?string            $description = null;
    public ?ReferenceResponse $subject   = null;
    public ?ReferenceResponse $encounter = null;
    public ?PeriodResponse    $period    = null;
    /** @var array[] */
    public array              $activity  = [];

    protected function mapFields(array $data): void
    {
        $this->status      = $data['status']      ?? null;
        $this->intent      = $data['intent']      ?? null;
        $this->title       = $data['title']       ?? null;
        $this->description = $data['description'] ?? null;

        if (isset($data['subject'])) {
            $this->subject = ReferenceResponse::fromArray($data['subject']);
        }

        if (isset($data['encounter'])) {
            $this->encounter = ReferenceResponse::fromArray($data['encounter']);
        }

        if (isset($data['period'])) {
            $this->period = PeriodResponse::fromArray($data['period']);
        }

        $this->activity = $data['activity'] ?? [];
    }
}
