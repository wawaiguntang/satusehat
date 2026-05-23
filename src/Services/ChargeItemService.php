<?php

namespace Wawaiguntang\Satusehat\Services;

use Wawaiguntang\Satusehat\DTOs\ChargeItem\ChargeItemDTO;
use Wawaiguntang\Satusehat\Responses\BundleResponse;
use Wawaiguntang\Satusehat\Responses\Resources\ChargeItemResponse;

class ChargeItemService extends AbstractResourceService
{
    public function create(ChargeItemDTO $dto): ChargeItemResponse
    {
        /** @var ChargeItemResponse */
        return $this->doPost('/ChargeItem', $dto->toArray(), fn(array $d) => ChargeItemResponse::fromArray($d));
    }

    public function getById(string $id): ChargeItemResponse
    {
        /** @var ChargeItemResponse */
        return $this->doGet("/ChargeItem/{$id}", [], fn(array $d) => ChargeItemResponse::fromArray($d));
    }

    public function searchByAccount(string $accountId, ?string $patientId = null): BundleResponse
    {
        $params = ['account' => $accountId];
        if ($patientId !== null) {
            $params['subject'] = $patientId;
        }

        return $this->doGetBundle('/ChargeItem', $params, fn(array $d) => ChargeItemResponse::fromArray($d));
    }
}
