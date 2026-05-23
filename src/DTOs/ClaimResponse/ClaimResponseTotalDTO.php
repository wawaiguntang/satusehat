<?php

namespace Wawaiguntang\Satusehat\DTOs\ClaimResponse;

/**
 * FHIR R4 - ClaimResponse.total
 * @see https://www.hl7.org/fhir/claimresponse-definitions.html#ClaimResponse.total
 *
 * Total keseluruhan dari adjudikasi klaim.
 * Mata uang: IDR
 */
class ClaimResponseTotalDTO
{
    public function __construct(
        /** @var string Kode kategori total */
        public readonly string $categoryCode,

        /** @var string Display kategori total */
        public readonly string $categoryDisplay,

        /** @var float Jumlah total (IDR) */
        public readonly float $amount,

        /** @var string Sistem kode kategori */
        public readonly string $categorySystem = 'http://terminology.hl7.org/CodeSystem/adjudication',
    ) {}

    public function toArray(): array
    {
        return [
            'category' => [
                'coding' => [
                    [
                        'system'  => $this->categorySystem,
                        'code'    => $this->categoryCode,
                        'display' => $this->categoryDisplay,
                    ],
                ],
            ],
            'amount' => [
                'value'    => $this->amount,
                'currency' => 'IDR',
            ],
        ];
    }
}
