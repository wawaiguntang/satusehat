<?php

namespace Wawaiguntang\Satusehat\DTOs\CarePlan;

use Wawaiguntang\Satusehat\Enums\CarePlan\CarePlanIntentEnum;
use Wawaiguntang\Satusehat\Enums\CarePlan\CarePlanStatusEnum;

/**
 * FHIR R4 - CarePlan Resource
 * StructureDefinition: https://fhir.kemkes.go.id/r4/StructureDefinition/CarePlan
 *
 * Merepresentasikan rencana perawatan pasien, termasuk rujukan.
 *
 * Operasi yang didukung:
 *  - POST  /CarePlan             → create
 *  - GET   /CarePlan/:id         → by ID
 *  - GET   /CarePlan?subject=    → search by patient ID
 *  - GET   /CarePlan?encounter=  → search by encounter ID
 */
class CarePlanDTO
{
    public readonly string $resourceType;

    public function __construct(
        /** @var CarePlanStatusEnum Status rencana perawatan */
        public readonly CarePlanStatusEnum $status,

        /** @var CarePlanIntentEnum Intent rencana perawatan */
        public readonly CarePlanIntentEnum $intent,

        /** @var string Deskripsi rencana perawatan */
        public readonly string $description,

        /** @var string Referensi Patient */
        public readonly string $subjectReference,

        /** @var string Referensi Encounter */
        public readonly string $encounterReference,

        /** @var string Tanggal dibuat (YYYY-MM-DD) */
        public readonly string $created,

        /** @var string Referensi Practitioner penulis */
        public readonly string $authorReference,

        /** @var string|null ID unik CarePlan di SATUSEHAT */
        public readonly ?string $id = null,

        /** @var string|null Nama tampilan pasien */
        public readonly ?string $subjectDisplay = null,
    ) {
        $this->resourceType = 'CarePlan';
    }

    public function toArray(): array
    {
        $subject = ['reference' => $this->subjectReference];
        if ($this->subjectDisplay !== null) {
            $subject['display'] = $this->subjectDisplay;
        }

        $data = [
            'resourceType' => $this->resourceType,
            'status'       => $this->status->value,
            'intent'       => $this->intent->value,
            'description'  => $this->description,
            'subject'      => $subject,
            'encounter'    => ['reference' => $this->encounterReference],
            'created'      => $this->created,
            'author'       => ['reference' => $this->authorReference],
        ];

        if ($this->id !== null) {
            $data['id'] = $this->id;
        }

        return $data;
    }
}
