<?php

namespace Wawaiguntang\Satusehat\Enums\Condition;

/**
 * FHIR R4 - Condition.clinicalStatus.coding.code
 * Standard: http://terminology.hl7.org/CodeSystem/condition-clinical
 */
enum ConditionClinicalStatusEnum: string
{
    /** Kondisi masih aktif */
    case Active     = 'active';
    /** Kondisi kambuh setelah pernah remisi */
    case Recurrence = 'recurrence';
    /** Kondisi kambuh setelah sembuh */
    case Relapse    = 'relapse';
    /** Kondisi tidak aktif */
    case Inactive   = 'inactive';
    /** Kondisi dalam remisi */
    case Remission  = 'remission';
    /** Kondisi sudah sembuh/resolved */
    case Resolved   = 'resolved';
}
