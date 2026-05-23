<?php

namespace Wawaiguntang\Satusehat\Enums\AllergyIntolerance;

/**
 * FHIR R4 - AllergyIntolerance.category[]
 * Standard: http://hl7.org/fhir/allergy-intolerance-category
 */
enum AllergyIntoleranceCategoryEnum: string
{
    /** Alergi makanan */
    case Food        = 'food';
    /** Alergi obat */
    case Medication  = 'medication';
    /** Alergi lingkungan */
    case Environment = 'environment';
    /** Alergi biologis */
    case Biologic    = 'biologic';
}
