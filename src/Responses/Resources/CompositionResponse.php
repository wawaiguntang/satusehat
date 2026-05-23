<?php

namespace Wawaiguntang\Satusehat\Responses\Resources;

use Wawaiguntang\Satusehat\Responses\AbstractFhirResponse;
use Wawaiguntang\Satusehat\Shared\Responses\ReferenceResponse;

class CompositionResponse extends AbstractFhirResponse
{
    public ?string            $status    = null;
    public ?string            $typeCode  = null;
    public ?string            $title     = null;
    public ?string            $date      = null;
    public ?ReferenceResponse $subject   = null;
    public ?ReferenceResponse $encounter = null;
    /** @var array[] */
    public array              $section   = [];

    protected function mapFields(array $data): void
    {
        $this->status   = $data['status'] ?? null;
        $this->typeCode = $data['type']['coding'][0]['code'] ?? null;
        $this->title    = $data['title'] ?? null;
        $this->date     = $data['date']  ?? null;

        if (isset($data['subject'])) {
            $this->subject = ReferenceResponse::fromArray($data['subject']);
        }

        if (isset($data['encounter'])) {
            $this->encounter = ReferenceResponse::fromArray($data['encounter']);
        }

        $this->section = $data['section'] ?? [];
    }
}
