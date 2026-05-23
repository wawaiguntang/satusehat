<?php

namespace Wawaiguntang\Satusehat\Enums\Condition;

/**
 * Code system yang digunakan untuk Condition.code.coding.system di SATUSEHAT.
 * Pilih salah satu sesuai jenis kode diagnosis yang digunakan.
 */
enum ConditionCodeSystemEnum: string
{
    /** ICD-10 — kode diagnosis standar internasional */
    case Icd10   = 'http://hl7.org/fhir/sid/icd-10';
    /** SNOMED CT — terminologi klinis internasional */
    case SnomedCt = 'http://snomed.info/sct';
}
