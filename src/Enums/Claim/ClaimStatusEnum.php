<?php

namespace Wawaiguntang\Satusehat\Enums\Claim;

/**
 * FHIR R4 - Claim.status / ClaimResponse.status
 * Standard: http://hl7.org/fhir/fm-status
 *
 * Digunakan oleh: Claim.status, ClaimResponse.status
 */
enum ClaimStatusEnum: string
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
