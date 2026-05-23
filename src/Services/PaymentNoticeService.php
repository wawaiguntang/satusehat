<?php

namespace Wawaiguntang\Satusehat\Services;

use Wawaiguntang\Satusehat\DTOs\PaymentNotice\PaymentNoticeDTO;
use Wawaiguntang\Satusehat\Responses\BundleResponse;
use Wawaiguntang\Satusehat\Responses\Resources\PaymentNoticeResponse;

class PaymentNoticeService extends AbstractResourceService
{
    public function create(PaymentNoticeDTO $dto): PaymentNoticeResponse
    {
        /** @var PaymentNoticeResponse */
        return $this->doPost('/PaymentNotice', $dto->toArray(), fn(array $d) => PaymentNoticeResponse::fromArray($d));
    }

    public function getById(string $id): PaymentNoticeResponse
    {
        /** @var PaymentNoticeResponse */
        return $this->doGet("/PaymentNotice/{$id}", [], fn(array $d) => PaymentNoticeResponse::fromArray($d));
    }

    public function searchByClaimId(string $claimId): BundleResponse
    {
        return $this->doGetBundle(
            '/PaymentNotice',
            ['request' => $claimId],
            fn(array $d) => PaymentNoticeResponse::fromArray($d),
        );
    }
}
