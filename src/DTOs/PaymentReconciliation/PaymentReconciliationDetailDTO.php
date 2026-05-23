<?php

namespace Wawaiguntang\Satusehat\DTOs\PaymentReconciliation;

/**
 * FHIR R4 - PaymentReconciliation.detail
 * @see https://www.hl7.org/fhir/paymentreconciliation-definitions.html#PaymentReconciliation.detail
 *
 * Detail item yang termasuk dalam rekonsiliasi pembayaran.
 * Kode tipe menggunakan: http://terminology.hl7.org/CodeSystem/payment-type
 * Contoh: payment, adjustment, advance, transfer
 */
class PaymentReconciliationDetailDTO
{
    public function __construct(
        /** @var string Kode tipe pembayaran (contoh: "payment") */
        public readonly string $typeCode,

        /** @var string Display tipe */
        public readonly string $typeDisplay,

        /** @var string|null Referensi Claim (request) */
        public readonly ?string $requestReference = null,

        /** @var string|null Referensi ClaimResponse (response) */
        public readonly ?string $responseReference = null,
    ) {}

    public function toArray(): array
    {
        $data = [
            'type' => [
                'coding' => [
                    [
                        'system'  => 'http://terminology.hl7.org/CodeSystem/payment-type',
                        'code'    => $this->typeCode,
                        'display' => $this->typeDisplay,
                    ],
                ],
            ],
        ];

        if ($this->requestReference !== null) {
            $data['request'] = ['reference' => $this->requestReference];
        }

        if ($this->responseReference !== null) {
            $data['response'] = ['reference' => $this->responseReference];
        }

        return $data;
    }
}
