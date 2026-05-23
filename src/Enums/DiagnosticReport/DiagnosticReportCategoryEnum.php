<?php

namespace Wawaiguntang\Satusehat\Enums\DiagnosticReport;

/**
 * FHIR R4 - DiagnosticReport.category.coding.code
 * Standard: http://terminology.hl7.org/CodeSystem/v2-0074
 */
enum DiagnosticReportCategoryEnum: string
{
    /** Laboratory — Laboratorium umum */
    case LAB = 'LAB';
    /** Microbiology — Mikrobiologi */
    case MB  = 'MB';
    /** Radiology — Radiologi */
    case RAD = 'RAD';
    /** Chemistry — Kimia klinik */
    case CH  = 'CH';
    /** Hematology — Hematologi */
    case HM  = 'HM';
    /** Pathology — Patologi */
    case PAT = 'PAT';
    /** Cytology — Sitologi */
    case CYT = 'CYT';
    /** Surgical Pathology */
    case SP  = 'SP';
    /** Urinalysis */
    case URN = 'URN';
    /** Blood Bank */
    case BLB = 'BLB';
}
