<?php

namespace Wawaiguntang\Satusehat\DTOs\QuestionnaireResponse;

use Wawaiguntang\Satusehat\Enums\QuestionnaireResponse\QuestionnaireResponseStatusEnum;

/**
 * FHIR R4 - QuestionnaireResponse Resource
 * StructureDefinition: https://fhir.kemkes.go.id/r4/StructureDefinition/QuestionnaireResponse
 *
 * Merepresentasikan jawaban dari kuesioner standar (contoh: skrining kesejahteraan keluarga).
 *
 * Operasi yang didukung:
 *  - POST  /QuestionnaireResponse             → create
 *  - GET   /QuestionnaireResponse/:id         → by ID
 *  - GET   /QuestionnaireResponse?subject=    → search by patient ID
 *  - GET   /QuestionnaireResponse?encounter=  → search by encounter ID
 *
 * Field `questionnaire` mengacu pada URL canonical Questionnaire SATUSEHAT,
 * contoh: "https://fhir.kemkes.go.id/Questionnaire/Q0002"
 */
class QuestionnaireResponseDTO
{
    public readonly string $resourceType;

    public function __construct(
        /** @var string URL canonical Questionnaire yang dijawab */
        public readonly string $questionnaire,

        /** @var QuestionnaireResponseStatusEnum Status jawaban */
        public readonly QuestionnaireResponseStatusEnum $status,

        /** @var string Referensi Patient */
        public readonly string $subjectReference,

        /** @var string Referensi Encounter */
        public readonly string $encounterReference,

        /** @var string Datetime diisi (ISO 8601 + timezone) */
        public readonly string $authored,

        /** @var string Referensi Practitioner pengisi */
        public readonly string $authorReference,

        /** @var QuestionnaireResponseItemDTO[] Daftar jawaban item */
        public readonly array $item,

        /** @var string|null ID unik QuestionnaireResponse di SATUSEHAT */
        public readonly ?string $id = null,

        /** @var string|null Nama tampilan pasien */
        public readonly ?string $subjectDisplay = null,

        /** @var string|null Referensi Patient sebagai sumber jawaban */
        public readonly ?string $sourceReference = null,
    ) {
        $this->resourceType = 'QuestionnaireResponse';
    }

    public function toArray(): array
    {
        $subject = ['reference' => $this->subjectReference];
        if ($this->subjectDisplay !== null) {
            $subject['display'] = $this->subjectDisplay;
        }

        $data = [
            'resourceType'  => $this->resourceType,
            'questionnaire' => $this->questionnaire,
            'status'        => $this->status->value,
            'subject'       => $subject,
            'encounter'     => ['reference' => $this->encounterReference],
            'authored'      => $this->authored,
            'author'        => ['reference' => $this->authorReference],
            'item'          => array_map(fn($i) => $i->toArray(), $this->item),
        ];

        if ($this->id !== null) {
            $data['id'] = $this->id;
        }

        if ($this->sourceReference !== null) {
            $data['source'] = ['reference' => $this->sourceReference];
        }

        return $data;
    }
}
