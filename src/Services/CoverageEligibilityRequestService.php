<?php

namespace Wawaiguntang\Satusehat\Services;

use Wawaiguntang\Satusehat\DTOs\CoverageEligibilityRequest\CoverageEligibilityRequestDTO;
use Wawaiguntang\Satusehat\Responses\BundleResponse;
use Wawaiguntang\Satusehat\Responses\Resources\CoverageEligibilityRequestResponse;

class CoverageEligibilityRequestService extends AbstractResourceService
{
    public function create(CoverageEligibilityRequestDTO $dto): CoverageEligibilityRequestResponse
    {
        /** @var CoverageEligibilityRequestResponse */
        return $this->doPost('/CoverageEligibilityRequest', $dto->toArray(), fn(array $d) => CoverageEligibilityRequestResponse::fromArray($d));
    }

    public function getById(string $id): CoverageEligibilityRequestResponse
    {
        /** @var CoverageEligibilityRequestResponse */
        return $this->doGet("/CoverageEligibilityRequest/{$id}", [], fn(array $d) => CoverageEligibilityRequestResponse::fromArray($d));
    }

    public function searchByIdentifier(string $identifier): BundleResponse
    {
        return $this->doGetBundle(
            '/CoverageEligibilityRequest',
            ['identifier' => $identifier],
            fn(array $d) => CoverageEligibilityRequestResponse::fromArray($d),
        );
    }

    public function getEverything(string $id): BundleResponse
    {
        return $this->doGetBundle(
            "/CoverageEligibilityRequest/{$id}/\$everything",
            [],
            fn(array $d) => CoverageEligibilityRequestResponse::fromArray($d),
        );
    }
}
