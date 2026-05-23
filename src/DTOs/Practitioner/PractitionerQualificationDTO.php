<?php

namespace Wawaiguntang\Satusehat\DTOs\Practitioner;

/**
 * FHIR R4 - Practitioner.qualification
 * @see https://www.hl7.org/fhir/practitioner-definitions.html#Practitioner.qualification
 *
 * Mewakili kualifikasi/kompetensi tenaga kesehatan, misal:
 * - Dokter Spesialis Anak (Sp.A)
 * - Dokter Umum
 * - Perawat, dll.
 */
class PractitionerQualificationDTO
{
    public function __construct(
        /**
         * @var array Kode kualifikasi
         * Struktur: ['system' => string, 'code' => string, 'display' => string]
         * Contoh sistem: http://terminology.hl7.org/CodeSystem/v2-0360|2.7
         */
        public readonly array $coding,

        /** @var string Teks kualifikasi, misal: "Dokter" */
        public readonly string $codeText,

        /** @var string|null Tanggal mulai berlaku format Y-m-d */
        public readonly ?string $periodStart = null,

        /** @var string|null Tanggal berakhir format Y-m-d */
        public readonly ?string $periodEnd = null,

        /** @var string|null Referensi organisasi penerbit (contoh: "Organization/10000004") */
        public readonly ?string $issuerReference = null,

        /** @var string|null Nama organisasi penerbit */
        public readonly ?string $issuerDisplay = null,
    ) {}

    public function toArray(): array
    {
        $data = [
            'code' => [
                'coding' => $this->coding,
                'text'   => $this->codeText,
            ],
        ];

        if ($this->periodStart !== null || $this->periodEnd !== null) {
            $period = [];
            if ($this->periodStart !== null) {
                $period['start'] = $this->periodStart;
            }
            if ($this->periodEnd !== null) {
                $period['end'] = $this->periodEnd;
            }
            $data['period'] = $period;
        }

        if ($this->issuerReference !== null || $this->issuerDisplay !== null) {
            $issuer = [];
            if ($this->issuerReference !== null) {
                $issuer['reference'] = $this->issuerReference;
            }
            if ($this->issuerDisplay !== null) {
                $issuer['display'] = $this->issuerDisplay;
            }
            $data['issuer'] = $issuer;
        }

        return $data;
    }
}
