<?php

namespace Wawaiguntang\Satusehat\Services;

use Wawaiguntang\Satusehat\DTOs\PaymentReconciliation\PaymentReconciliationDTO;
use Wawaiguntang\Satusehat\Responses\BundleResponse;
use Wawaiguntang\Satusehat\Responses\Resources\PaymentReconciliationResponse;

class PaymentReconciliationService extends AbstractResourceService
{
    public function create(PaymentReconciliationDTO $dto): PaymentReconciliationResponse
    {
        /** @var PaymentReconciliationResponse */
        return $this->doPost('/PaymentReconciliation', $dto->toArray(), fn(array $d) => PaymentReconciliationResponse::fromArray($d));
    }

    public function getById(string $id): PaymentReconciliationResponse
    {
        /** @var PaymentReconciliationResponse */
        return $this->doGet("/PaymentReconciliation/{$id}", [], fn(array $d) => PaymentReconciliationResponse::fromArray($d));
    }

    public function searchByClaimId(string $claimId): BundleResponse
    {
        return $this->doGetBundle(
            '/PaymentReconciliation',
            ['detail-request' => $claimId],
            fn(array $d) => PaymentReconciliationResponse::fromArray($d),
        );
    }
}
