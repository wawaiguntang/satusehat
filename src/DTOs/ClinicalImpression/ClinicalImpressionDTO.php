<?php

namespace Wawaiguntang\Satusehat\DTOs\ClinicalImpression;

use Wawaiguntang\Satusehat\Enums\ClinicalImpression\ClinicalImpressionStatusEnum;

/**
 * FHIR R4 - ClinicalImpression Resource
 * StructureDefinition: https://fhir.kemkes.go.id/r4/StructureDefinition/ClinicalImpression
 *
 * Merepresentasikan penilaian/kesan klinis dokter terhadap kondisi pasien,
 * termasuk prognosis dan temuan klinis.
 *
 * Operasi yang didukung:
 *  - POST  /ClinicalImpression             → create
 *  - GET   /ClinicalImpression/:id         → by ID
 *  - GET   /ClinicalImpression?subject=    → search by patient ID
 *  - GET   /ClinicalImpression?encounter=  → search by encounter ID
 *
 * Field identifier.system: "http://sys-ids.kemkes.go.id/clinicalimpression/{Org_id}"
 * Kode finding menggunakan ICD-10: http://hl7.org/fhir/sid/icd-10
 * Kode prognosis menggunakan SNOMED CT: http://snomed.info/sct
 */
class ClinicalImpressionDTO
{
    public readonly string $resourceType;

    public function __construct(
        /** @var ClinicalImpressionStatusEnum Status penilaian */
        public readonly ClinicalImpressionStatusEnum $status,

        /** @var string Narasi/deskripsi klinis */
        public readonly string $description,

        /** @var string Referensi Patient */
        public readonly string $subjectReference,

        /** @var string Referensi Encounter */
        public readonly string $encounterReference,

        /** @var string Datetime efektif penilaian (ISO 8601 + timezone) */
        public readonly string $effectiveDateTime,

        /** @var string Datetime penilaian dibuat (ISO 8601 + timezone) */
        public readonly string $date,

        /** @var string Referensi Practitioner asesor */
        public readonly string $assessorReference,

        /**
         * @var array Identifier
         * Struktur: [['system' => string, 'use' => string, 'value' => string], ...]
         */
        public readonly array $identifier,

        /** @var string|null ID unik ClinicalImpression di SATUSEHAT */
        public readonly ?string $id = null,

        /** @var string|null Nama tampilan pasien */
        public readonly ?string $subjectDisplay = null,

        /** @var string|null Deskripsi encounter */
        public readonly ?string $encounterDisplay = null,

        /** @var string[]|null Referensi Condition sebagai masalah */
        public readonly ?array $problemReferences = null,

        /** @var ClinicalImpressionInvestigationDTO[]|null Kelompok investigasi */
        public readonly ?array $investigation = null,

        /** @var string|null Ringkasan penilaian klinis */
        public readonly ?string $summary = null,

        /**
         * @var array[]|null Temuan klinis (ICD-10)
         * Struktur: [['code' => string, 'display' => string, 'basis' => string|null], ...]
         */
        public readonly ?array $finding = null,

        /**
         * @var array[]|null Prognosis (SNOMED CT)
         * Struktur: [['code' => string, 'display' => string], ...]
         */
        public readonly ?array $prognosisCodeableConcept = null,
    ) {
        $this->resourceType = 'ClinicalImpression';
    }

    public function toArray(): array
    {
        $subject = ['reference' => $this->subjectReference];
        if ($this->subjectDisplay !== null) {
            $subject['display'] = $this->subjectDisplay;
        }

        $encounter = ['reference' => $this->encounterReference];
        if ($this->encounterDisplay !== null) {
            $encounter['display'] = $this->encounterDisplay;
        }

        $data = [
            'resourceType'    => $this->resourceType,
            'identifier'      => $this->identifier,
            'status'          => $this->status->value,
            'description'     => $this->description,
            'subject'         => $subject,
            'encounter'       => $encounter,
            'effectiveDateTime' => $this->effectiveDateTime,
            'date'            => $this->date,
            'assessor'        => ['reference' => $this->assessorReference],
        ];

        if ($this->id !== null) {
            $data['id'] = $this->id;
        }

        if ($this->problemReferences !== null) {
            $data['problem'] = array_map(fn($r) => ['reference' => $r], $this->problemReferences);
        }

        if ($this->investigation !== null) {
            $data['investigation'] = array_map(fn($i) => $i->toArray(), $this->investigation);
        }

        if ($this->summary !== null) {
            $data['summary'] = $this->summary;
        }

        if ($this->finding !== null) {
            $data['finding'] = array_map(function ($f) {
                $item = [
                    'itemCodeableConcept' => [
                        'coding' => [
                            [
                                'system'  => 'http://hl7.org/fhir/sid/icd-10',
                                'code'    => $f['code'],
                                'display' => $f['display'],
                            ],
                        ],
                    ],
                ];
                if (!empty($f['basis'])) {
                    $item['basis'] = $f['basis'];
                }
                return $item;
            }, $this->finding);
        }

        if ($this->prognosisCodeableConcept !== null) {
            $data['prognosisCodeableConcept'] = array_map(fn($p) => [
                'coding' => [
                    [
                        'system'  => 'http://snomed.info/sct',
                        'code'    => $p['code'],
                        'display' => $p['display'],
                    ],
                ],
            ], $this->prognosisCodeableConcept);
        }

        return $data;
    }
}
