<?php

namespace Wawaiguntang\Satusehat\Shared\Enums;

/**
 * FHIR R4 - gender
 * Standard: http://hl7.org/fhir/administrative-gender
 */
enum GenderEnum: string
{
    case Male    = 'male';
    case Female  = 'female';
    case Other   = 'other';
    case Unknown = 'unknown';
}
