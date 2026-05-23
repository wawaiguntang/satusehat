<?php

namespace Wawaiguntang\Satusehat\Enums\ServiceRequest;

/**
 * FHIR R4 - ServiceRequest.status
 * Standard: http://hl7.org/fhir/request-status
 */
enum ServiceRequestStatusEnum: string
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
