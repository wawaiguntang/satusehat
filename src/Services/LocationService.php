<?php

namespace Wawaiguntang\Satusehat\Services;

use Wawaiguntang\Satusehat\DTOs\Location\LocationDTO;
use Wawaiguntang\Satusehat\Responses\BundleResponse;
use Wawaiguntang\Satusehat\Responses\Resources\LocationResponse;

class LocationService extends AbstractResourceService
{
    public function getById(string $id): LocationResponse
    {
        /** @var LocationResponse */
        return $this->doGet("/Location/{$id}", [], fn(array $d) => LocationResponse::fromArray($d));
    }

    public function searchByOrganization(string $organizationId): BundleResponse
    {
        return $this->doGetBundle(
            '/Location',
            ['organization' => $organizationId],
            fn(array $d) => LocationResponse::fromArray($d),
        );
    }

    public function create(LocationDTO $dto): LocationResponse
    {
        /** @var LocationResponse */
        return $this->doPost('/Location', $dto->toArray(), fn(array $d) => LocationResponse::fromArray($d));
    }

    public function update(string $id, LocationDTO $dto): LocationResponse
    {
        /** @var LocationResponse */
        return $this->doPut("/Location/{$id}", $dto->toArray(), fn(array $d) => LocationResponse::fromArray($d));
    }

    public function patch(string $id, array $operations): LocationResponse
    {
        /** @var LocationResponse */
        return $this->doPatch("/Location/{$id}", $operations, fn(array $d) => LocationResponse::fromArray($d));
    }
}
