<?php

namespace Wawaiguntang\Satusehat\Responses\Resources;

use Wawaiguntang\Satusehat\Responses\AbstractFhirResponse;
use Wawaiguntang\Satusehat\Shared\Responses\IdentifierResponse;

class PractitionerResponse extends AbstractFhirResponse
{
    public bool    $active      = true;
    public ?string $name        = null;
    public ?string $gender      = null;
    public ?string $birthDate   = null;
    /** @var IdentifierResponse[] */
    public array   $identifiers = [];

    protected function mapFields(array $data): void
    {
        $this->active    = $data['active']    ?? true;
        $this->gender    = $data['gender']    ?? null;
        $this->birthDate = $data['birthDate'] ?? null;

        foreach ($data['name'] ?? [] as $name) {
            if (($name['use'] ?? '') === 'official') {
                $this->name = $name['text'] ?? (($name['family'] ?? '') . ' ' . implode(' ', $name['given'] ?? []));
                break;
            }
        }

        foreach ($data['identifier'] ?? [] as $id) {
            $this->identifiers[] = IdentifierResponse::fromArray($id);
        }
    }
}
