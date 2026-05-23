<?php

namespace Wawaiguntang\Satusehat\Responses\Resources;

use Wawaiguntang\Satusehat\Responses\AbstractFhirResponse;
use Wawaiguntang\Satusehat\Shared\Responses\IdentifierResponse;
use Wawaiguntang\Satusehat\Shared\Responses\ReferenceResponse;

class RelatedPersonResponse extends AbstractFhirResponse
{
    public bool               $active       = true;
    public ?ReferenceResponse $patient      = null;
    public ?string            $relationshipCode    = null;
    public ?string            $relationshipDisplay = null;
    public ?string            $name         = null;
    public ?string            $gender       = null;
    public ?string            $birthDate    = null;
    /** @var IdentifierResponse[] */
    public array              $identifiers  = [];

    protected function mapFields(array $data): void
    {
        $this->active    = $data['active']    ?? true;
        $this->gender    = $data['gender']    ?? null;
        $this->birthDate = $data['birthDate'] ?? null;

        if (isset($data['patient'])) {
            $this->patient = ReferenceResponse::fromArray($data['patient']);
        }

        $rel = $data['relationship'][0]['coding'][0] ?? [];
        $this->relationshipCode    = $rel['code']    ?? null;
        $this->relationshipDisplay = $rel['display'] ?? null;

        foreach ($data['name'] ?? [] as $name) {
            if (($name['use'] ?? '') === 'official') {
                $this->name = $name['text'] ?? null;
                break;
            }
        }

        foreach ($data['identifier'] ?? [] as $id) {
            $this->identifiers[] = IdentifierResponse::fromArray($id);
        }
    }
}
