<?php

namespace Wawaiguntang\Satusehat\Responses\Resources;

use Wawaiguntang\Satusehat\Responses\AbstractFhirResponse;
use Wawaiguntang\Satusehat\Shared\Responses\ReferenceResponse;

class ImagingStudyResponse extends AbstractFhirResponse
{
    public ?string            $status    = null;
    public ?ReferenceResponse $subject   = null;
    public ?ReferenceResponse $encounter = null;
    public ?string            $started   = null;
    public int                $numberOfSeries    = 0;
    public int                $numberOfInstances = 0;
    /** @var array[] */
    public array              $series    = [];

    protected function mapFields(array $data): void
    {
        $this->status             = $data['status']             ?? null;
        $this->started            = $data['started']            ?? null;
        $this->numberOfSeries     = $data['numberOfSeries']     ?? 0;
        $this->numberOfInstances  = $data['numberOfInstances']  ?? 0;

        if (isset($data['subject'])) {
            $this->subject = ReferenceResponse::fromArray($data['subject']);
        }

        if (isset($data['encounter'])) {
            $this->encounter = ReferenceResponse::fromArray($data['encounter']);
        }

        $this->series = $data['series'] ?? [];
    }
}
