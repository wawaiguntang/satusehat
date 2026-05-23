<?php

namespace Wawaiguntang\Satusehat\DTOs\Specimen;

/**
 * FHIR R4 - Specimen.collection
 * @see https://www.hl7.org/fhir/specimen-definitions.html#Specimen.collection
 *
 * Informasi pengambilan spesimen.
 * Extension CollectorOrganization: https://fhir.kemkes.go.id/r4/StructureDefinition/CollectorOrganization
 * Kode metode pengambilan menggunakan SNOMED CT: http://snomed.info/sct
 */
class SpecimenCollectionDTO
{
    public function __construct(
        /** @var string Datetime pengambilan spesimen (ISO 8601 + timezone) */
        public readonly string $collectedDateTime,

        /** @var string|null Referensi Organization pengambil (SATUSEHAT extension) */
        public readonly ?string $collectorOrganizationReference = null,

        /** @var string|null Kode SNOMED CT metode pengambilan */
        public readonly ?string $methodCode = null,

        /** @var string|null Display metode pengambilan */
        public readonly ?string $methodDisplay = null,
    ) {}

    public function toArray(): array
    {
        $data = [
            'collectedDateTime' => $this->collectedDateTime,
        ];

        if ($this->methodCode !== null) {
            $data['method'] = [
                'coding' => [
                    [
                        'system'  => 'http://snomed.info/sct',
                        'code'    => $this->methodCode,
                        'display' => $this->methodDisplay ?? $this->methodCode,
                    ],
                ],
            ];
        }

        if ($this->collectorOrganizationReference !== null) {
            $data['extension'] = [
                [
                    'url'            => 'https://fhir.kemkes.go.id/r4/StructureDefinition/CollectorOrganization',
                    'valueReference' => ['reference' => $this->collectorOrganizationReference],
                ],
            ];
        }

        return $data;
    }
}
