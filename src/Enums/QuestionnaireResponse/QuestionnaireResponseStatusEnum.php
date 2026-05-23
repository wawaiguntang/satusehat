<?php

namespace Wawaiguntang\Satusehat\Enums\QuestionnaireResponse;

/**
 * FHIR R4 - QuestionnaireResponse.status
 * Standard: http://hl7.org/fhir/questionnaire-answers-status
 */
enum QuestionnaireResponseStatusEnum: string
{
    /** Sedang diisi */
    case InProgress     = 'in-progress';
    /** Selesai */
    case Completed      = 'completed';
    /** Diubah setelah selesai */
    case Amended        = 'amended';
    /** Input dengan error */
    case EnteredInError = 'entered-in-error';
    /** Dihentikan */
    case Stopped        = 'stopped';
}
