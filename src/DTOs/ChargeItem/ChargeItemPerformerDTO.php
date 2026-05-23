<?php

namespace Wawaiguntang\Satusehat\DTOs\ChargeItem;

/**
 * FHIR R4 - ChargeItem.performer
 * @see https://www.hl7.org/fhir/chargeitem-definitions.html#ChargeItem.performer
 *
 * Pelaksana tindakan yang dikenakan biaya.
 * Kode fungsi menggunakan SNOMED CT: http://snomed.info/sct
 * Contoh kode: 39677007 (Internal medicine specialist), 1290289004 (Fellow physician)
 */
class ChargeItemPerformerDTO
{
    public function __construct(
        /** @var string Referensi Practitioner pelaksana */
        public readonly string $actorReference,

        /** @var string|null Kode SNOMED CT fungsi pelaksana */
        public readonly ?string $functionCode = null,

        /** @var string|null Display fungsi pelaksana */
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
                        'system'  => 'http://snomed.info/sct',
                        'code'    => $this->functionCode,
                        'display' => $this->functionDisplay ?? $this->functionCode,
                    ],
                ],
            ];
        }

        return $data;
    }
}
