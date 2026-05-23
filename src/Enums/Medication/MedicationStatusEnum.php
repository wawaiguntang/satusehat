<?php

namespace Wawaiguntang\Satusehat\Enums\Medication;

/**
 * FHIR R4 - Medication.status
 * Standard: http://hl7.org/fhir/CodeSystem/medication-status
 */
enum MedicationStatusEnum: string
{
    /** Obat aktif dan bisa digunakan */
    case Active         = 'active';
    /** Obat tidak aktif */
    case Inactive       = 'inactive';
    /** Input dengan error */
    case EnteredInError = 'entered-in-error';
}
