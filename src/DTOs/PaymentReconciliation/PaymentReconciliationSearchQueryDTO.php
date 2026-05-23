<?php

namespace Wawaiguntang\Satusehat\DTOs\PaymentReconciliation;

/**
 * Query parameter untuk GET /PaymentReconciliation
 * @see https://api-satusehat-stg.dto.kemkes.go.id/fhir-r4/v1/PaymentReconciliation
 */
class PaymentReconciliationSearchQueryDTO
{
    public function __construct(
        /** @var string|null ID Organization asuransi (penerbit pembayaran) */
        public readonly ?string $paymentIssuer = null,
    ) {}

    public function toQueryParams(): array
    {
        $params = [];

        if ($this->paymentIssuer !== null) {
            $params['payment-issuer'] = $this->paymentIssuer;
        }

        return $params;
    }
}
