<?php

namespace Wawaiguntang\Satusehat\DTOs\Immunization;

/**
 * FHIR R4 - Immunization.performer
 * @see https://www.hl7.org/fhir/immunization-definitions.html#Immunization.performer
 *
 * Kode fungsi (function.coding) menggunakan:
 *  http://terminology.hl7.org/CodeSystem/v2-0443
 *  Contoh: AP = Administering Provider, OP = Ordering Provider
 */
class ImmunizationPerformerDTO
{
    public function __construct(
        /** @var string Referensi Practitioner atau Organization pelaksana */
        public readonly string $actorReference,

        /** @var string|null Kode fungsi (contoh: "AP") */
        public readonly ?string $functionCode = null,

        /** @var string|null Display fungsi (contoh: "Administering Provider") */
        public readonly ?string $functionDisplay = null,
    ) {}

    public function toArray(): array
    {
        $data = [
            'actor' => ['reference' => $this->actorReference],
        ];

        if ($this->functionCode !== null) {
            $data['function'] = [
                'coding' => [
                    [
                        'system'  => 'http://terminology.hl7.org/CodeSystem/v2-0443',
                        'code'    => $this->functionCode,
                        'display' => $this->functionDisplay ?? $this->functionCode,
                    ],
                ],
            ];
        }

        return $data;
    }
}
