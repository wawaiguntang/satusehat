<?php

namespace Wawaiguntang\Satusehat\Shared\Enums;

/**
 * FHIR R4 - identifier.system
 * Sistem identifikasi yang digunakan oleh SATUSEHAT (Kemenkes RI)
 * Standard: https://fhir.kemkes.go.id/id/
 */
enum IdentifierSystemEnum: string
{
    /** Nomor Induk Kependudukan (KTP) */
    case NIK = 'https://fhir.kemkes.go.id/id/nik';

    /** NIK Ibu, digunakan untuk bayi baru lahir */
    case NIKIbu = 'https://fhir.kemkes.go.id/id/nik-ibu';

    /** IHS Number — ID unik pasien di ekosistem SATUSEHAT */
    case IHSNumber = 'https://fhir.kemkes.go.id/id/ihs-number';
}
