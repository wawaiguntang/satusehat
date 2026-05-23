<?php

namespace Wawaiguntang\Satusehat\DTOs\ClaimResponse;

/**
 * FHIR R4 - ClaimResponse.adjudication
 * @see https://www.hl7.org/fhir/claimresponse-definitions.html#ClaimResponse.adjudication
 *
 * Hasil penilaian klaim oleh asuransi.
 * Kategori menggunakan SNOMED CT: http://snomed.info/sct
 * Alasan menggunakan SATUSEHAT: http://terminology.kemkes.go.id/CodeSystem/claimresponse-adjudication
 * Contoh kode: CRA000001 (Layak), CRA000002 (Tidak Layak)
 * Mata uang: IDR
 */
class ClaimResponseAdjudicationDTO
{
    public function __construct(
        /** @var string Kode SNOMED CT kategori adjudikasi */
        public readonly string $categoryCode,

        /** @var string Display kategori */
        public readonly string $categoryDisplay,

        /** @var string|null Kode alasan adjudikasi (SATUSEHAT) */
        public readonly ?string $reasonCode = null,

        /** @var string|null Display alasan */
        public readonly ?string $reasonDisplay = null,

        /** @var string|null Teks alasan */
        public readonly ?string $reasonText = null,

        /** @var float|null Jumlah yang disetujui (IDR) */
        public readonly ?float $amount = null,
    ) {}

    public function toArray(): array
    {
        $data = [
            'category' => [
                'coding' => [
                    [
                        'system'  => 'http://snomed.info/sct',
                        'code'    => $this->categoryCode,
                        'display' => $this->categoryDisplay,
                    ],
                ],
            ],
        ];

        if ($this->reasonCode !== null) {
            $reason = [
                'coding' => [
                    [
                        'system'  => 'http://terminology.kemkes.go.id/CodeSystem/claimresponse-adjudication',
                        'code'    => $this->reasonCode,
                        'display' => $this->reasonDisplay ?? $this->reasonCode,
                    ],
                ],
            ];
            if ($this->reasonText !== null) {
                $reason['text'] = $this->reasonText;
            }
            $data['reason'] = $reason;
        }

        if ($this->amount !== null) {
            $data['amount'] = ['value' => $this->amount, 'currency' => 'IDR'];
        }

        return $data;
    }
}
