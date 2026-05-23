<?php

namespace Wawaiguntang\Satusehat\DTOs\PaymentNotice;

use Wawaiguntang\Satusehat\Enums\CoverageEligibilityResponse\EligibilityResponseStatusEnum;

/**
 * FHIR R4 - PaymentNotice Resource
 * StructureDefinition: https://fhir.kemkes.go.id/r4/StructureDefinition/PaymentNotice
 *
 * Merepresentasikan notifikasi pembayaran dari faskes ke asuransi setelah klaim disetujui.
 *
 * Operasi yang didukung:
 *  - POST  /PaymentNotice      → create
 *  - GET   /PaymentNotice/:id  → by ID
 *
 * Kode paymentStatus menggunakan: http://terminology.hl7.org/CodeSystem/payment-status
 * Contoh: paid (sudah dibayar), cleared (sudah dikliringkan)
 * Mata uang: IDR
 */
class PaymentNoticeDTO
{
    public readonly string $resourceType;

    public function __construct(
        /** @var EligibilityResponseStatusEnum Status notifikasi */
        public readonly EligibilityResponseStatusEnum $status,

        /** @var string Referensi Claim */
        public readonly string $requestReference,

        /** @var string Referensi ClaimResponse */
        public readonly string $responseReference,

        /** @var string Datetime dibuat (ISO 8601 + timezone) */
        public readonly string $created,

        /** @var string Tanggal pembayaran (YYYY-MM-DD) */
        public readonly string $paymentDate,

        /** @var string Referensi Organization faskes (provider) */
        public readonly string $providerReference,

        /** @var string Referensi Organization penerima pembayaran (payee) */
        public readonly string $payeeReference,

        /** @var string Referensi Organization penerima notifikasi (recipient) */
        public readonly string $recipientReference,

        /** @var float Jumlah pembayaran (IDR) */
        public readonly float $amount,

        /** @var string Referensi PaymentReconciliation */
        public readonly string $paymentReference,

        /** @var string Kode status pembayaran (contoh: "paid") */
        public readonly string $paymentStatusCode,

        /** @var string Display status pembayaran (contoh: "Paid") */
        public readonly string $paymentStatusDisplay,

        /** @var string|null ID unik PaymentNotice di SATUSEHAT */
        public readonly ?string $id = null,
    ) {
        $this->resourceType = 'PaymentNotice';
    }

    public function toArray(): array
    {
        $data = [
            'resourceType'  => $this->resourceType,
            'status'        => $this->status->value,
            'request'       => ['reference' => $this->requestReference],
            'response'      => ['reference' => $this->responseReference],
            'created'       => $this->created,
            'paymentDate'   => $this->paymentDate,
            'provider'      => ['reference' => $this->providerReference],
            'payee'         => ['reference' => $this->payeeReference],
            'recipient'     => ['reference' => $this->recipientReference],
            'amount'        => ['value' => $this->amount, 'currency' => 'IDR'],
            'payment'       => ['reference' => $this->paymentReference],
            'paymentStatus' => [
                'coding' => [
                    [
                        'system'  => 'http://terminology.hl7.org/CodeSystem/payment-status',
                        'code'    => $this->paymentStatusCode,
                        'display' => $this->paymentStatusDisplay,
                    ],
                ],
            ],
        ];

        if ($this->id !== null) {
            $data['id'] = $this->id;
        }

        return $data;
    }
}
