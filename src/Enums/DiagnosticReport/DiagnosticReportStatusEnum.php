<?php

namespace Wawaiguntang\Satusehat\Enums\DiagnosticReport;

/**
 * FHIR R4 - DiagnosticReport.status
 * Standard: http://hl7.org/fhir/diagnostic-report-status
 */
enum DiagnosticReportStatusEnum: string
{
    /** Terdaftar, hasil belum tersedia */
    case Registered     = 'registered';
    /** Sebagian hasil tersedia */
    case Partial        = 'partial';
    /** Hasil sementara */
    case Preliminary    = 'preliminary';
    /** Hasil final */
    case Final          = 'final';
    /** Hasil diubah setelah final */
    case Amended        = 'amended';
    /** Hasil dikoreksi */
    case Corrected      = 'corrected';
    /** Tambahan informasi setelah final */
    case Appended       = 'appended';
    /** Dibatalkan */
    case Cancelled      = 'cancelled';
    /** Input dengan error */
    case EnteredInError = 'entered-in-error';
    /** Status tidak diketahui */
    case Unknown        = 'unknown';
}
