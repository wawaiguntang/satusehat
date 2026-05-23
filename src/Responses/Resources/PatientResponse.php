<?php

namespace Wawaiguntang\Satusehat\Responses\Resources;

use Wawaiguntang\Satusehat\Responses\AbstractFhirResponse;
use Wawaiguntang\Satusehat\Shared\Responses\IdentifierResponse;

class PatientResponse extends AbstractFhirResponse
{
    public ?string $nik           = null;
    public ?string $name          = null;
    public ?string $gender        = null;
    public ?string $birthDate     = null;
    public bool    $active        = true;
    /** @var IdentifierResponse[] */
    public array   $identifiers   = [];

    protected function mapFields(array $data): void
    {
        $this->gender    = $data['gender']    ?? null;
        $this->birthDate = $data['birthDate'] ?? null;
        $this->active    = $data['active']    ?? true;

        foreach ($data['name'] ?? [] as $name) {
            if (($name['use'] ?? '') === 'official') {
                $this->name = $name['text'] ?? (($name['family'] ?? '') . ' ' . implode(' ', $name['given'] ?? []));
                break;
            }
        }

        foreach ($data['identifier'] ?? [] as $id) {
            $this->identifiers[] = IdentifierResponse::fromArray($id);
            if (str_contains($id['system'] ?? '', '/nik')) {
                $this->nik = $id['value'] ?? null;
            }
        }
    }
}
