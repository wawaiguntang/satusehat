<?php

namespace Wawaiguntang\Satusehat\Services;

use Wawaiguntang\Satusehat\DTOs\Account\AccountDTO;
use Wawaiguntang\Satusehat\Responses\BundleResponse;
use Wawaiguntang\Satusehat\Responses\Resources\AccountResponse;

class AccountService extends AbstractResourceService
{
    public function create(AccountDTO $dto): AccountResponse
    {
        /** @var AccountResponse */
        return $this->doPost('/Account', $dto->toArray(), fn(array $d) => AccountResponse::fromArray($d));
    }

    public function getById(string $id): AccountResponse
    {
        /** @var AccountResponse */
        return $this->doGet("/Account/{$id}", [], fn(array $d) => AccountResponse::fromArray($d));
    }

    public function searchByPatient(string $patientId): BundleResponse
    {
        return $this->doGetBundle('/Account', ['subject' => $patientId], fn(array $d) => AccountResponse::fromArray($d));
    }

    public function patch(string $id, array $operations): AccountResponse
    {
        /** @var AccountResponse */
        return $this->doPatch("/Account/{$id}", $operations, fn(array $d) => AccountResponse::fromArray($d));
    }
}
