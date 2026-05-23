<?php

namespace Wawaiguntang\Satusehat\Enums\MedicationRequest;

/**
 * FHIR R4 - MedicationRequest.category.coding.code
 * Standard: http://terminology.hl7.org/CodeSystem/medicationrequest-category
 */
enum MedicationRequestCategoryEnum: string
{
    /** Rawat jalan */
    case Outpatient  = 'outpatient';
    /** Rawat inap */
    case Inpatient   = 'inpatient';
    /** Komunitas / home care */
    case Community   = 'community';
    /** Obat pulang / discharge */
    case Discharge   = 'discharge';
}
