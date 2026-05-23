<?php

namespace Wawaiguntang\Satusehat\Enums\Observation;

/**
 * FHIR R4 - Observation.category.coding.code
 * Standard: http://terminology.hl7.org/CodeSystem/observation-category
 */
enum ObservationCategoryEnum: string
{
    /** Tanda-tanda vital (TTV) — paling umum di SATUSEHAT */
    case VitalSigns  = 'vital-signs';
    /** Laboratorium */
    case Laboratory  = 'laboratory';
    /** Pencitraan/imaging */
    case Imaging     = 'imaging';
    /** Prosedur */
    case Procedure   = 'procedure';
    /** Survei/kuesioner */
    case Survey      = 'survey';
    /** Pemeriksaan fisik */
    case Exam        = 'exam';
    /** Terapi */
    case Therapy     = 'therapy';
    /** Aktivitas */
    case Activity    = 'activity';
}
