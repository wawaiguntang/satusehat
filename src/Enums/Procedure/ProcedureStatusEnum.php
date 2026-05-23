<?php

namespace Wawaiguntang\Satusehat\Enums\Procedure;

/**
 * FHIR R4 - Procedure.status
 * Standard: http://hl7.org/fhir/event-status
 */
enum ProcedureStatusEnum: string
{
    /** Prosedur sedang dipersiapkan */
    case Preparation    = 'preparation';
    /** Prosedur sedang berlangsung */
    case InProgress     = 'in-progress';
    /** Prosedur tidak jadi dilakukan */
    case NotDone        = 'not-done';
    /** Prosedur ditunda sementara */
    case OnHold         = 'on-hold';
    /** Prosedur dihentikan sebelum selesai */
    case Stopped        = 'stopped';
    /** Prosedur selesai */
    case Completed      = 'completed';
    /** Input dengan error */
    case EnteredInError = 'entered-in-error';
    /** Status tidak diketahui */
    case Unknown        = 'unknown';
}
