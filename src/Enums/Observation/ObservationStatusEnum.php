<?php

namespace Wawaiguntang\Satusehat\Enums\Observation;

/**
 * FHIR R4 - Observation.status
 * Standard: http://hl7.org/fhir/observation-status
 */
enum ObservationStatusEnum: string
{
    /** Terdaftar, hasil belum tersedia */
    case Registered     = 'registered';
    /** Hasil sementara/awal */
    case Preliminary    = 'preliminary';
    /** Hasil final */
    case Final          = 'final';
    /** Hasil diubah setelah final */
    case Amended        = 'amended';
    /** Hasil dikoreksi */
    case Corrected      = 'corrected';
    /** Dibatalkan */
    case Cancelled      = 'cancelled';
    /** Input dengan error */
    case EnteredInError = 'entered-in-error';
    /** Status tidak diketahui */
    case Unknown        = 'unknown';
}
