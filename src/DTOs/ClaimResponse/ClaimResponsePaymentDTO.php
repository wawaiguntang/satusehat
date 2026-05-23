<?php

namespace Wawaiguntang\Satusehat\DTOs\ClaimResponse;

/**
 * FHIR R4 - ClaimResponse.payment
 * @see https://www.hl7.org/fhir/claimresponse-definitions.html#ClaimResponse.payment
 *
 * Informasi pembayaran dari respon klaim.
 * Kode tipe menggunakan: http://terminology.hl7.org/CodeSystem/ex-paymenttype
 * Mata uang: IDR
 */
class ClaimResponsePaymentDTO
{
    public function __construct(
        /** @var string Kode tipe pembayaran (contoh: "complete", "partial") */
        public readonly string $typeCode,

        /** @var string Display tipe pembayaran */
        public readonly string $typeDisplay,

        /** @var string Tanggal pembayaran (YYYY-MM-DD) */
        public readonly string $date,

        /** @var float Jumlah pembayaran (IDR) */
        public readonly float $amount,
    ) {}

    public function toArray(): array
    {
        return [
            'type'   => [
                'coding' => [
                    [
                        'system'  => 'http://terminology.hl7.org/CodeSystem/ex-paymenttype',
                        'code'    => $this->typeCode,
                        'display' => $this->typeDisplay,
                    ],
                ],
            ],
            'date'   => $this->date,
            'amount' => [
                'value'    => $this->amount,
                'currency' => 'IDR',
            ],
        ];
    }
}
