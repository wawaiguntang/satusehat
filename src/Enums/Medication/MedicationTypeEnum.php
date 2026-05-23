<?php

namespace Wawaiguntang\Satusehat\Enums\Medication;

/**
 * Tipe obat sesuai ketentuan SATUSEHAT.
 * Standard: http://terminology.kemkes.go.id/CodeSystem/medication-type
 *
 * Digunakan pada extension MedicationType:
 * https://fhir.kemkes.go.id/r4/StructureDefinition/MedicationType
 */
enum MedicationTypeEnum: string
{
    /** Non-compound — obat jadi/tunggal */
    case NC = 'NC';
    /** Compound — obat racikan */
    case C  = 'C';
    /** Sediaan Darah */
    case SD = 'SD';
    /** Non-compound Extemporaneous */
    case NC_EX = 'NC_EX';
}
