<?php

namespace Wawaiguntang\Satusehat\DTOs\ImagingStudy;

/**
 * Query parameter untuk GET /ImagingStudy
 * @see https://api-satusehat-stg.dto.kemkes.go.id/fhir-r4/v1/ImagingStudy
 */
class ImagingStudySearchQueryDTO
{
    public function __construct(
        /** @var string|null ID pasien */
        public readonly ?string $subject = null,
    ) {}

    public function toQueryParams(): array
    {
        $params = [];

        if ($this->subject !== null) {
            $params['subject'] = $this->subject;
        }

        return $params;
    }
}
