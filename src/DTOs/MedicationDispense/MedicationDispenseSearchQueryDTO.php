<?php

namespace Wawaiguntang\Satusehat\DTOs\MedicationDispense;

/**
 * Query parameter untuk GET /MedicationDispense
 * @see https://api-satusehat-stg.dto.kemkes.go.id/fhir-r4/v1/MedicationDispense
 *
 * Kombinasi parameter yang didukung SATUSEHAT:
 *  - subject → ID pasien
 *  - context → UUID encounter (catatan: MedicationDispense menggunakan "context", bukan "encounter")
 */
class MedicationDispenseSearchQueryDTO
{
    public function __construct(
        /** @var string|null ID pasien */
        public readonly ?string $subject = null,

        /** @var string|null UUID encounter (sebagai context) */
        public readonly ?string $context = null,
    ) {}

    public function toQueryParams(): array
    {
        $params = [];

        if ($this->subject !== null) {
            $params['subject'] = $this->subject;
        }

        if ($this->context !== null) {
            $params['context'] = $this->context;
        }

        return $params;
    }
}
