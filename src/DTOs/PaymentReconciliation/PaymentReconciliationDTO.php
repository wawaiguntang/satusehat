<?php

namespace Wawaiguntang\Satusehat\DTOs\PaymentReconciliation;

use Wawaiguntang\Satusehat\Enums\CoverageEligibilityResponse\EligibilityOutcomeEnum;
use Wawaiguntang\Satusehat\Enums\CoverageEligibilityResponse\EligibilityResponseStatusEnum;

/**
 * FHIR R4 - PaymentReconciliation Resource
 * StructureDefinition: https://fhir.kemkes.go.id/r4/StructureDefinition/PaymentReconciliation
 *
 * Merepresentasikan rekonsiliasi pembayaran antara faskes dan asuransi.
 *
 * Operasi yang didukung:
 *  - POST  /PaymentReconciliation                     → create
 *  - GET   /PaymentReconciliation/:id                 → by ID
 *  - GET   /PaymentReconciliation?payment-issuer=     → search by organization asuransi
 *
 * Mata uang pembayaran: IDR
 */
class PaymentReconciliationDTO
{
    public readonly string $resourceType;

    public function __construct(
        /** @var EligibilityResponseStatusEnum Status rekonsiliasi */
        public readonly EligibilityResponseStatusEnum $status,

        /** @var string Datetime dibuat (ISO 8601 + timezone) */
        public readonly string $created,

        /** @var string Referensi Organization asuransi (penerbit pembayaran) */
        public readonly string $paymentIssuerReference,

        /** @var string Referensi Organization faskes (pemohon) */
        public readonly string $requestorReference,

        /** @var EligibilityOutcomeEnum Hasil pemrosesan */
        public readonly EligibilityOutcomeEnum $outcome,

        /** @var string Keterangan rekonsiliasi */
        public readonly string $disposition,

        /** @var string Tanggal pembayaran (YYYY-MM-DD) */
        public readonly string $paymentDate,

        /** @var float Jumlah pembayaran (IDR) */
        public readonly float $paymentAmount,

        /** @var PaymentReconciliationDetailDTO[] Detail item rekonsiliasi */
        public readonly array $detail,

        /** @var string|null ID unik PaymentReconciliation di SATUSEHAT */
        public readonly ?string $id = null,

        /** @var string|null Datetime mulai periode (ISO 8601) */
        public readonly ?string $periodStart = null,

        /** @var string|null Datetime akhir periode (ISO 8601) */
        public readonly ?string $periodEnd = null,

        /**
         * @var array[]|null Catatan proses
         * Struktur: [['type' => string, 'text' => string], ...]
         */
        public readonly ?array $processNote = null,
    ) {
        $this->resourceType = 'PaymentReconciliation';
    }

    public function toArray(): array
    {
        $data = [
            'resourceType'   => $this->resourceType,
            'status'         => $this->status->value,
            'created'        => $this->created,
            'paymentIssuer'  => ['reference' => $this->paymentIssuerReference],
            'requestor'      => ['reference' => $this->requestorReference],
            'outcome'        => $this->outcome->value,
            'disposition'    => $this->disposition,
            'paymentDate'    => $this->paymentDate,
            'paymentAmount'  => ['value' => $this->paymentAmount, 'currency' => 'IDR'],
            'detail'         => array_map(fn($d) => $d->toArray(), $this->detail),
        ];

        if ($this->id !== null) {
            $data['id'] = $this->id;
        }

        if ($this->periodStart !== null) {
            $data['period'] = ['start' => $this->periodStart];
            if ($this->periodEnd !== null) {
                $data['period']['end'] = $this->periodEnd;
            }
        }

        if ($this->processNote !== null) {
            $data['processNote'] = $this->processNote;
        }

        return $data;
    }
}
