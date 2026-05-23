<?php

namespace Wawaiguntang\Satusehat\Enums\Specimen;

/**
 * FHIR R4 - Specimen.status
 * Standard: http://hl7.org/fhir/specimen-status
 */
enum SpecimenStatusEnum: string
{
    /** Spesimen tersedia */
    case Available      = 'available';
    /** Spesimen tidak tersedia */
    case Unavailable    = 'unavailable';
    /** Spesimen tidak memuaskan */
    case Unsatisfactory = 'unsatisfactory';
    /** Input dengan error */
    case EnteredInError = 'entered-in-error';
}
