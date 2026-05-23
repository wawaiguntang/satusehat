<?php

namespace Wawaiguntang\Satusehat\Services;

use Wawaiguntang\Satusehat\DTOs\CoverageEligibilityResponse\CoverageEligibilityResponseDTO;
use Wawaiguntang\Satusehat\Responses\BundleResponse;
use Wawaiguntang\Satusehat\Responses\Resources\CoverageEligibilityResponseResponse;

class CoverageEligibilityResponseService extends AbstractResourceService
{
    public function create(CoverageEligibilityResponseDTO $dto): CoverageEligibilityResponseResponse
    {
        /** @var CoverageEligibilityResponseResponse */
        return $this->doPost('/CoverageEligibilityResponse', $dto->toArray(), fn(array $d) => CoverageEligibilityResponseResponse::fromArray($d));
    }

    public function getById(string $id): CoverageEligibilityResponseResponse
    {
        /** @var CoverageEligibilityResponseResponse */
        return $this->doGet("/CoverageEligibilityResponse/{$id}", [], fn(array $d) => CoverageEligibilityResponseResponse::fromArray($d));
    }

    public function searchByRequest(string $requestId): BundleResponse
    {
        return $this->doGetBundle(
            '/CoverageEligibilityResponse',
            ['request' => $requestId],
            fn(array $d) => CoverageEligibilityResponseResponse::fromArray($d),
        );
    }
}
