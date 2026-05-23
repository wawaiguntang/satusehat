<?php

namespace Wawaiguntang\Satusehat\Enums\CarePlan;

/**
 * FHIR R4 - CarePlan.status
 * Standard: http://hl7.org/fhir/request-status
 */
enum CarePlanStatusEnum: string
{
    /** Draft */
    case Draft          = 'draft';
    /** Aktif */
    case Active         = 'active';
    /** Ditunda */
    case OnHold         = 'on-hold';
    /** Dicabut */
    case Revoked        = 'revoked';
    /** Selesai */
    case Completed      = 'completed';
    /** Input dengan error */
    case EnteredInError = 'entered-in-error';
    /** Status tidak diketahui */
    case Unknown        = 'unknown';
}
