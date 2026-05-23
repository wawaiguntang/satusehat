<?php

namespace Wawaiguntang\Satusehat\DTOs\Encounter;

use Wawaiguntang\Satusehat\Enums\Encounter\EncounterStatusEnum;

/**
 * FHIR R4 - Encounter.statusHistory
 * @see https://www.hl7.org/fhir/encounter-definitions.html#Encounter.statusHistory
 *
 * Mencatat riwayat perubahan status dalam satu kunjungan.
 * Format datetime: ISO 8601 dengan timezone (contoh: "2022-06-14T07:00:00+07:00")
 */
class EncounterStatusHistoryDTO
{
    public function __construct(
        /** @var EncounterStatusEnum Status pada periode ini */
        public readonly EncounterStatusEnum $status,

        /** @var string Waktu mulai periode status (ISO 8601 + timezone) */
        public readonly string $periodStart,

        /** @var string|null Waktu selesai periode status (ISO 8601 + timezone) */
        public readonly ?string $periodEnd = null,
    ) {}

    public function toArray(): array
    {
        $period = ['start' => $this->periodStart];
        if ($this->periodEnd !== null) {
            $period['end'] = $this->periodEnd;
        }

        return [
            'status' => $this->status->value,
            'period' => $period,
        ];
    }
}
