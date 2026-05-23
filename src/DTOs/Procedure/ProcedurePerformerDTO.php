<?php

namespace Wawaiguntang\Satusehat\DTOs\Procedure;

/**
 * FHIR R4 - Procedure.performer
 * @see https://www.hl7.org/fhir/procedure-definitions.html#Procedure.performer
 */
class ProcedurePerformerDTO
{
    public function __construct(
        /** @var string Referensi Practitioner pelaksana (contoh: "Practitioner/N10000001") */
        public readonly string $actorReference,

        /** @var string|null Nama tampilan pelaksana */
        public readonly ?string $actorDisplay = null,
    ) {}

    public function toArray(): array
    {
        $actor = ['reference' => $this->actorReference];
        if ($this->actorDisplay !== null) {
            $actor['display'] = $this->actorDisplay;
        }

        return [
            'actor' => $actor,
        ];
    }
}
