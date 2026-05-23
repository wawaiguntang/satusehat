<?php

namespace Wawaiguntang\Satusehat\Enums\Coverage;

/**
 * FHIR R4 - Coverage.status
 * Standard: http://hl7.org/fhir/fm-status
 */
enum CoverageStatusEnum: string
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
