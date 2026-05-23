<?php

namespace Wawaiguntang\Satusehat\Enums\ImagingStudy;

/**
 * FHIR R4 - ImagingStudy.status
 * Standard: http://hl7.org/fhir/imagingstudy-status
 */
enum ImagingStudyStatusEnum: string
{
    /** Terdaftar, belum tersedia */
    case Registered     = 'registered';
    /** Studi tersedia */
    case Available      = 'available';
    /** Dibatalkan */
    case Cancelled      = 'cancelled';
    /** Input dengan error */
    case EnteredInError = 'entered-in-error';
    /** Status tidak diketahui */
    case Unknown        = 'unknown';
}
