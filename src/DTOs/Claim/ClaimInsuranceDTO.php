<?php

namespace Wawaiguntang\Satusehat\DTOs\Claim;

/**
 * FHIR R4 - Claim.insurance
 * @see https://www.hl7.org/fhir/claim-definitions.html#Claim.insurance
 */
class ClaimInsuranceDTO
{
    public function __construct(
        /** @var int Nomor urut */
        public readonly int $sequence,

        /** @var bool Apakah ini coverage utama/primer */
        public readonly bool $focal,

        /** @var string Referensi Coverage */
        public readonly string $coverageReference,
    ) {}

    public function toArray(): array
    {
        return [
            'sequence' => $this->sequence,
            'focal'    => $this->focal,
            'coverage' => ['reference' => $this->coverageReference],
        ];
    }
}
