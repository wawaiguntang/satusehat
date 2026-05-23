<?php

namespace Wawaiguntang\Satusehat\Responses\Resources;

use Wawaiguntang\Satusehat\Responses\AbstractFhirResponse;
use Wawaiguntang\Satusehat\Shared\Responses\ReferenceResponse;

class SpecimenResponse extends AbstractFhirResponse
{
    public ?string            $typeCode       = null;
    public ?string            $typeDisplay    = null;
    public ?ReferenceResponse $subject        = null;
    public ?string            $receivedTime   = null;
    public ?array             $collection     = null;

    protected function mapFields(array $data): void
    {
        $type = $data['type']['coding'][0] ?? [];
        $this->typeCode    = $type['code']    ?? null;
        $this->typeDisplay = $type['display'] ?? null;

        if (isset($data['subject'])) {
            $this->subject = ReferenceResponse::fromArray($data['subject']);
        }

        $this->receivedTime = $data['receivedTime'] ?? null;
        $this->collection   = $data['collection']   ?? null;
    }
}
