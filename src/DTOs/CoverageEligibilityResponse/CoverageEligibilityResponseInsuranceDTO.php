<?php

namespace Wawaiguntang\Satusehat\DTOs\CoverageEligibilityResponse;

/**
 * FHIR R4 - CoverageEligibilityResponse.insurance
 * @see https://www.hl7.org/fhir/coverageeligibilityresponse-definitions.html#CoverageEligibilityResponse.insurance
 *
 * Informasi manfaat asuransi yang berlaku untuk coverage tertentu.
 * Kode kategori manfaat menggunakan: http://terminology.hl7.org/CodeSystem/ex-benefitcategory
 */
class CoverageEligibilityResponseInsuranceDTO
{
    public function __construct(
        /** @var string Referensi Coverage */
        public readonly string $coverageReference,

        /** @var bool Apakah coverage masih berlaku */
        public readonly bool $inforce,

        /**
         * @var array[]|null Item manfaat
         * Struktur: [['categoryCode' => string, 'categoryDisplay' => string], ...]
         */
        public readonly ?array $items = null,
    ) {}

    public function toArray(): array
    {
        $data = [
            'coverage' => ['reference' => $this->coverageReference],
            'inforce'  => $this->inforce,
        ];

        if ($this->items !== null) {
            $data['item'] = array_map(fn($item) => [
                'category' => [
                    'coding' => [
                        [
                            'system'  => 'http://terminology.hl7.org/CodeSystem/ex-benefitcategory',
                            'code'    => $item['categoryCode'],
                            'display' => $item['categoryDisplay'],
                        ],
                    ],
                ],
            ], $this->items);
        }

        return $data;
    }
}
