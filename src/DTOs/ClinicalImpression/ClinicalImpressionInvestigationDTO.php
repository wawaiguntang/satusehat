<?php

namespace Wawaiguntang\Satusehat\DTOs\ClinicalImpression;

/**
 * FHIR R4 - ClinicalImpression.investigation
 * @see https://www.hl7.org/fhir/clinicalimpression-definitions.html#ClinicalImpression.investigation
 *
 * Kelompok pemeriksaan/investigasi yang dilakukan dalam penilaian klinis.
 */
class ClinicalImpressionInvestigationDTO
{
    public function __construct(
        /** @var string Teks deskriptif jenis investigasi (contoh: "Pemeriksaan Sputum BTA") */
        public readonly string $codeText,

        /**
         * @var string[] Referensi hasil investigasi
         * Dapat berupa DiagnosticReport, Observation, dll.
         * Contoh: ["DiagnosticReport/uuid", "Observation/uuid"]
         */
        public readonly array $itemReferences,
    ) {}

    public function toArray(): array
    {
        return [
            'code' => [
                'text' => $this->codeText,
            ],
            'item' => array_map(fn($ref) => ['reference' => $ref], $this->itemReferences),
        ];
    }
}
