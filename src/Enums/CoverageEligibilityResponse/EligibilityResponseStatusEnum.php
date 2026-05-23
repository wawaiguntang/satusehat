<?php

namespace Wawaiguntang\Satusehat\Enums\CoverageEligibilityResponse;

/**
 * FHIR R4 - CoverageEligibilityResponse.status
 * Standard: http://hl7.org/fhir/fm-status
 */
enum EligibilityResponseStatusEnum: string
{
    /** Aktif */
    case Active         = 'active';
    /** Dibatalkan */
    case Cancelled      = 'cancelled';
    /** Draft */
    case Draft          = 'draft';
    /** Input dengan error */
    case EnteredInError = 'entered-in-error';
}
