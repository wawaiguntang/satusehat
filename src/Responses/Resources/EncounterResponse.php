<?php

namespace Wawaiguntang\Satusehat\Responses\Resources;

use Wawaiguntang\Satusehat\Responses\AbstractFhirResponse;
use Wawaiguntang\Satusehat\Shared\Responses\CodingResponse;
use Wawaiguntang\Satusehat\Shared\Responses\IdentifierResponse;
use Wawaiguntang\Satusehat\Shared\Responses\PeriodResponse;
use Wawaiguntang\Satusehat\Shared\Responses\ReferenceResponse;

class EncounterResponse extends AbstractFhirResponse
{
    public ?string            $status                   = null;
    public ?CodingResponse    $class                    = null;
    public ?ReferenceResponse $subject                  = null;
    public ?PeriodResponse    $period                   = null;
    public ?ReferenceResponse $serviceProvider          = null;
    /** @var IdentifierResponse[] */
    public array              $identifiers              = [];
    /** @var array[] */
    public array              $participant              = [];
    /** @var array[] */
    public array              $location                 = [];

    protected function mapFields(array $data): void
    {
        $this->status = $data['status'] ?? null;

        if (isset($data['class'])) {
            $this->class = CodingResponse::fromArray($data['class']);
        }

        if (isset($data['subject'])) {
            $this->subject = ReferenceResponse::fromArray($data['subject']);
        }

        if (isset($data['period'])) {
            $this->period = PeriodResponse::fromArray($data['period']);
        }

        if (isset($data['serviceProvider'])) {
            $this->serviceProvider = ReferenceResponse::fromArray($data['serviceProvider']);
        }

        foreach ($data['identifier'] ?? [] as $id) {
            $this->identifiers[] = IdentifierResponse::fromArray($id);
        }

        $this->participant = $data['participant'] ?? [];
        $this->location    = $data['location']    ?? [];
    }
}
