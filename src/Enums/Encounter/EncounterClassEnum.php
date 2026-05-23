<?php

namespace Wawaiguntang\Satusehat\Enums\Encounter;

/**
 * FHIR R4 - Encounter.class (Coding)
 * Standard: http://terminology.hl7.org/CodeSystem/v3-ActCode
 */
enum EncounterClassEnum: string
{
    /** Ambulatory — rawat jalan */
    case AMB  = 'AMB';
    /** Inpatient Encounter — rawat inap */
    case IMP  = 'IMP';
    /** Emergency — IGD/UGD */
    case EMER = 'EMER';
    /** Virtual — kunjungan virtual/telemedicine */
    case VR   = 'VR';
    /** Home Health — layanan kesehatan di rumah */
    case HH   = 'HH';
    /** Observation Encounter */
    case OBSENC = 'OBSENC';
    /** Pre-Admission */
    case PRENC  = 'PRENC';
    /** Short Stay */
    case SS     = 'SS';
}
