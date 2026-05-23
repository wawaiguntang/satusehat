<?php

namespace Wawaiguntang\Satusehat\Responses\Resources;

use Wawaiguntang\Satusehat\Responses\AbstractFhirResponse;
use Wawaiguntang\Satusehat\Shared\Responses\ReferenceResponse;

class CoverageEligibilityResponseResponse extends AbstractFhirResponse
{
    public ?string            $status      = null;
    public ?string            $outcome     = null;
    public ?string            $disposition = null;
    public ?string            $created     = null;
    public ?ReferenceResponse $patient     = null;
    public ?ReferenceResponse $insurer     = null;
    public ?ReferenceResponse $request     = null;
    /** @var array[] */
    public array              $insurance   = [];

    protected function mapFields(array $data): void
    {
        $this->status      = $data['status']      ?? null;
        $this->outcome     = $data['outcome']      ?? null;
        $this->disposition = $data['disposition']  ?? null;
        $this->created     = $data['created']      ?? null;

        if (isset($data['patient'])) {
            $this->patient = ReferenceResponse::fromArray($data['patient']);
        }

        if (isset($data['insurer'])) {
            $this->insurer = ReferenceResponse::fromArray($data['insurer']);
        }

        if (isset($data['request'])) {
            $this->request = ReferenceResponse::fromArray($data['request']);
        }

        $this->insurance = $data['insurance'] ?? [];
    }
}
