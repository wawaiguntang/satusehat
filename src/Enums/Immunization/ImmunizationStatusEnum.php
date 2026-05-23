<?php

namespace Wawaiguntang\Satusehat\Enums\Immunization;

/**
 * FHIR R4 - Immunization.status
 * Standard: http://terminology.hl7.org/CodeSystem/immunization-status
 */
enum ImmunizationStatusEnum: string
{
    /** Imunisasi selesai diberikan */
    case Completed      = 'completed';
    /** Input dengan error */
    case EnteredInError = 'entered-in-error';
    /** Imunisasi tidak diberikan */
    case NotDone        = 'not-done';
}
