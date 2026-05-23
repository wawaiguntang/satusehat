<?php

namespace Wawaiguntang\Satusehat\DTOs\EpisodeOfCare;

use Wawaiguntang\Satusehat\Enums\EpisodeOfCare\EpisodeOfCareStatusEnum;

/**
 * FHIR R4 - EpisodeOfCare.statusHistory
 * @see https://www.hl7.org/fhir/episodeofcare-definitions.html#EpisodeOfCare.statusHistory
 */
class EpisodeOfCareStatusHistoryDTO
{
    public function __construct(
        /** @var EpisodeOfCareStatusEnum Status pada periode ini */
        public readonly EpisodeOfCareStatusEnum $status,

        /** @var string Tanggal mulai periode (YYYY-MM-DD) */
        public readonly string $periodStart,

        /** @var string|null Tanggal akhir periode (YYYY-MM-DD) */
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
