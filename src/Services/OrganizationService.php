<?php

namespace Wawaiguntang\Satusehat\Services;

use Wawaiguntang\Satusehat\DTOs\Organization\OrganizationDTO;
use Wawaiguntang\Satusehat\Responses\BundleResponse;
use Wawaiguntang\Satusehat\Responses\Resources\OrganizationResponse;

class OrganizationService extends AbstractResourceService
{
    public function getById(string $id): OrganizationResponse
    {
        /** @var OrganizationResponse */
        return $this->doGet("/Organization/{$id}", [], fn(array $d) => OrganizationResponse::fromArray($d));
    }

    public function search(string $name): BundleResponse
    {
        return $this->doGetBundle(
            '/Organization',
            ['name' => $name],
            fn(array $d) => OrganizationResponse::fromArray($d),
        );
    }

    public function create(OrganizationDTO $dto): OrganizationResponse
    {
        /** @var OrganizationResponse */
        return $this->doPost('/Organization', $dto->toArray(), fn(array $d) => OrganizationResponse::fromArray($d));
    }

    public function update(string $id, OrganizationDTO $dto): OrganizationResponse
    {
        /** @var OrganizationResponse */
        return $this->doPut("/Organization/{$id}", $dto->toArray(), fn(array $d) => OrganizationResponse::fromArray($d));
    }
}
