<?php

namespace Wawaiguntang\Satusehat\Enums\ClinicalImpression;

/**
 * FHIR R4 - ClinicalImpression.status
 * Standard: http://hl7.org/fhir/clinical-impression-status
 */
enum ClinicalImpressionStatusEnum: string
{
    /** Penilaian klinis sedang berlangsung */
    case InProgress     = 'in-progress';
    /** Penilaian klinis selesai */
    case Completed      = 'completed';
    /** Input dengan error */
    case EnteredInError = 'entered-in-error';
}
