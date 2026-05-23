<?php

namespace Wawaiguntang\Satusehat\DTOs\Composition;

/**
 * FHIR R4 - Composition.section
 * @see https://www.hl7.org/fhir/composition-definitions.html#Composition.section
 *
 * Merepresentasikan satu bagian/seksi dalam dokumen medis.
 * Kode seksi menggunakan LOINC (http://loinc.org).
 *
 * Nilai text.status yang didukung: generated | extensions | additional | empty
 */
class CompositionSectionDTO
{
    public function __construct(
        /** @var string Kode LOINC untuk seksi (contoh: "42344-2" = Discharge diet) */
        public readonly string $code,

        /** @var string Display teks untuk kode (contoh: "Discharge diet (narrative)") */
        public readonly string $codeDisplay,

        /** @var string Konten naratif seksi (HTML atau teks biasa) */
        public readonly string $textDiv,

        /**
         * @var string Status naratif
         * Nilai: 'generated' | 'extensions' | 'additional' | 'empty'
         * Gunakan 'additional' untuk teks yang ditambahkan secara manual
         */
        public readonly string $textStatus = 'additional',
    ) {}

    public function toArray(): array
    {
        return [
            'code' => [
                'coding' => [
                    [
                        'system'  => 'http://loinc.org',
                        'code'    => $this->code,
                        'display' => $this->codeDisplay,
                    ],
                ],
            ],
            'text' => [
                'status' => $this->textStatus,
                'div'    => $this->textDiv,
            ],
        ];
    }
}
