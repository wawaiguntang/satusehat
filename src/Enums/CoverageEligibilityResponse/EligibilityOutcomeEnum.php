<?php

namespace Wawaiguntang\Satusehat\Enums\CoverageEligibilityResponse;

/**
 * FHIR R4 - CoverageEligibilityResponse.outcome
 * Standard: http://hl7.org/fhir/remittance-outcome
 */
enum EligibilityOutcomeEnum: string
{
    /** Dalam antrian */
    case Queued   = 'queued';
    /** Selesai diproses */
    case Complete = 'complete';
    /** Terjadi error */
    case Error    = 'error';
    /** Sebagian selesai */
    case Partial  = 'partial';
}
