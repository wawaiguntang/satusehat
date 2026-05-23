<?php

namespace Wawaiguntang\Satusehat\Enums\Encounter;

/**
 * FHIR R4 - Encounter.participant.type.coding.code
 * Standard: http://terminology.hl7.org/CodeSystem/v3-ParticipationType
 */
enum ParticipantTypeEnum: string
{
    /** Attender — tenaga kesehatan yang melayani pasien */
    case ATND = 'ATND';
    /** Consultant */
    case CON  = 'CON';
    /** Referrer */
    case REF  = 'REF';
    /** Secondary performer */
    case SPRF = 'SPRF';
    /** Primary performer */
    case PPRF = 'PPRF';
    /** Participant */
    case PART = 'PART';
    /** Translator */
    case TRANS = 'TRANS';
    /** Emergency contact */
    case ESM  = 'ESM';
    /** Admitter */
    case ADM  = 'ADM';
    /** Discharger */
    case DIS  = 'DIS';
}
