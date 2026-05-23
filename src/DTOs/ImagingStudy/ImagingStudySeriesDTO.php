<?php

namespace Wawaiguntang\Satusehat\DTOs\ImagingStudy;

/**
 * FHIR R4 - ImagingStudy.series
 * @see https://www.hl7.org/fhir/imagingstudy-definitions.html#ImagingStudy.series
 *
 * Satu seri dalam studi pencitraan DICOM.
 * Kode modalitas menggunakan DICOM DCM: http://dicom.nema.org/resources/ontology/DCM
 */
class ImagingStudySeriesDTO
{
    public function __construct(
        /** @var string DICOM Series Instance UID */
        public readonly string $uid,

        /** @var int Nomor seri */
        public readonly int $number,

        /** @var string Kode modalitas DICOM (contoh: "OP", "CT", "MR") */
        public readonly string $modalityCode,

        /** @var ImagingStudySeriesInstanceDTO[] Daftar instance dalam seri */
        public readonly array $instance,

        /** @var string|null Waktu mulai seri (ISO 8601) */
        public readonly ?string $started = null,
    ) {}

    public function toArray(): array
    {
        $data = [
            'uid'               => $this->uid,
            'number'            => $this->number,
            'modality'          => [
                'system' => 'http://dicom.nema.org/resources/ontology/DCM',
                'code'   => $this->modalityCode,
            ],
            'numberOfInstances' => count($this->instance),
            'instance'          => array_map(fn($i) => $i->toArray(), $this->instance),
        ];

        if ($this->started !== null) {
            $data['started'] = $this->started;
        }

        return $data;
    }
}
