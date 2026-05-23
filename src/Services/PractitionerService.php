<?php

namespace Wawaiguntang\Satusehat\Services;

use Wawaiguntang\Satusehat\Responses\BundleResponse;
use Wawaiguntang\Satusehat\Responses\Resources\PractitionerResponse;

class PractitionerService extends AbstractResourceService
{
    public function getByNik(string $nik): BundleResponse
    {
        return $this->doGetBundle(
            '/Practitioner',
            ['identifier' => 'https://fhir.kemkes.go.id/id/nik|' . $nik],
            fn(array $d) => PractitionerResponse::fromArray($d),
        );
    }

    public function getById(string $id): PractitionerResponse
    {
        /** @var PractitionerResponse */
        return $this->doGet("/Practitioner/{$id}", [], fn(array $d) => PractitionerResponse::fromArray($d));
    }
}
