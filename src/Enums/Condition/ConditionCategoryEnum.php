<?php

namespace Wawaiguntang\Satusehat\Enums\Condition;

/**
 * FHIR R4 - Condition.category.coding.code
 * Standard: http://terminology.hl7.org/CodeSystem/condition-category
 */
enum ConditionCategoryEnum: string
{
    /** Diagnosis pada kunjungan (paling umum di SATUSEHAT) */
    case EncounterDiagnosis = 'encounter-diagnosis';
    /** Item dalam daftar masalah pasien */
    case ProblemListItem    = 'problem-list-item';
}
