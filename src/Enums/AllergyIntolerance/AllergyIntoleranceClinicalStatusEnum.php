<?php

namespace Wawaiguntang\Satusehat\Enums\AllergyIntolerance;

/**
 * FHIR R4 - AllergyIntolerance.clinicalStatus.coding.code
 * Standard: http://terminology.hl7.org/CodeSystem/allergyintolerance-clinical
 */
enum AllergyIntoleranceClinicalStatusEnum: string
{
    /** Alergi/intoleransi masih aktif */
    case Active   = 'active';
    /** Alergi/intoleransi tidak aktif */
    case Inactive = 'inactive';
    /** Alergi/intoleransi sudah resolved */
    case Resolved = 'resolved';
}
