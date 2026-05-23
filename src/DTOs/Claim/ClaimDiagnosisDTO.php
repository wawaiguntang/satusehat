<?php

namespace Wawaiguntang\Satusehat\DTOs\Claim;

/**
 * FHIR R4 - Claim.diagnosis
 * @see https://www.hl7.org/fhir/claim-definitions.html#Claim.diagnosis
 *
 * Kode diagnosis menggunakan ICD-10: http://hl7.org/fhir/sid/icd-10
 */
class ClaimDiagnosisDTO
{
    public function __construct(
        /** @var int Nomor urut diagnosis */
        public readonly int $sequence,

        /** @var string Kode ICD-10 */
        public readonly string $icd10Code,

        /** @var string|null Display diagnosis */
        public readonly ?string $icd10Display = null,
    ) {}

    public function toArray(): array
    {
        return [
            'sequence'          => $this->sequence,
            'diagnosisCodeableConcept' => [
                'coding' => [
                    [
                        'system'  => 'http://hl7.org/fhir/sid/icd-10',
                        'code'    => $this->icd10Code,
                        'display' => $this->icd10Display ?? $this->icd10Code,
                    ],
                ],
            ],
        ];
    }
}
