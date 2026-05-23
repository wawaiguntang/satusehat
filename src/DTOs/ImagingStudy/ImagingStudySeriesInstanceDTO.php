<?php

namespace Wawaiguntang\Satusehat\DTOs\ImagingStudy;

/**
 * FHIR R4 - ImagingStudy.series.instance
 * @see https://www.hl7.org/fhir/imagingstudy-definitions.html#ImagingStudy.series.instance
 *
 * Satu instance/gambar dalam sebuah seri DICOM.
 * sopClass menggunakan urn:ietf:rfc:3986 dengan nilai urn:oid:{SOP Class UID}.
 */
class ImagingStudySeriesInstanceDTO
{
    public function __construct(
        /** @var string DICOM SOP Instance UID */
        public readonly string $uid,

        /** @var string DICOM SOP Class UID (format: urn:oid:xxx) */
        public readonly string $sopClassCode,

        /** @var int Nomor instance dalam seri */
        public readonly int $number,

        /** @var string|null Judul/keterangan instance */
        public readonly ?string $title = null,
    ) {}

    public function toArray(): array
    {
        $data = [
            'uid'      => $this->uid,
            'sopClass' => [
                'system' => 'urn:ietf:rfc:3986',
                'code'   => $this->sopClassCode,
            ],
            'number'   => $this->number,
        ];

        if ($this->title !== null) {
            $data['title'] = $this->title;
        }

        return $data;
    }
}
