<?php

namespace Wawaiguntang\Satusehat\Enums\Encounter;

/**
 * FHIR R4 - Encounter.diagnosis.use.coding.code
 * Standard: http://terminology.hl7.org/CodeSystem/diagnosis-role
 */
enum DiagnosisRoleEnum: string
{
    /** Admission Diagnosis */
    case AD      = 'AD';
    /** Discharge Diagnosis */
    case DD      = 'DD';
    /** Chief Complaint */
    case CC      = 'CC';
    /** Comorbidity Diagnosis */
    case CM      = 'CM';
    /** Pre-op Diagnosis */
    case PreOp   = 'pre-op';
    /** Post-op Diagnosis */
    case PostOp  = 'post-op';
    /** Billing */
    case Billing = 'billing';
}
