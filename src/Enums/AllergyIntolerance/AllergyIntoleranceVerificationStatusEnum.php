<?php

namespace Wawaiguntang\Satusehat\Enums\AllergyIntolerance;

/**
 * FHIR R4 - AllergyIntolerance.verificationStatus.coding.code
 * Standard: http://terminology.hl7.org/CodeSystem/allergyintolerance-verification
 */
enum AllergyIntoleranceVerificationStatusEnum: string
{
    /** Belum terkonfirmasi */
    case Unconfirmed    = 'unconfirmed';
    /** Dugaan/presumed */
    case Presumed       = 'presumed';
    /** Terkonfirmasi */
    case Confirmed      = 'confirmed';
    /** Dibantah */
    case Refuted        = 'refuted';
    /** Input dengan error */
    case EnteredInError = 'entered-in-error';
}
