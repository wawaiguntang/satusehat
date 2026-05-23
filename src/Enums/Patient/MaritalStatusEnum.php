<?php

namespace Wawaiguntang\Satusehat\Enums\Patient;

/**
 * FHIR R4 - Patient.maritalStatus.coding.code
 * Standard: http://terminology.hl7.org/CodeSystem/v3-MaritalStatus
 */
enum MaritalStatusEnum: string
{
    /** Annulled */
    case A = 'A';
    /** Divorced */
    case D = 'D';
    /** Interlocutory */
    case I = 'I';
    /** Legally Separated */
    case L = 'L';
    /** Married */
    case M = 'M';
    /** Polygamous */
    case P = 'P';
    /** Never Married */
    case S = 'S';
    /** Domestic Partner */
    case T = 'T';
    /** Unmarried */
    case U = 'U';
    /** Widowed */
    case W = 'W';
}
