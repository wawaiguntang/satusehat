<?php

namespace Wawaiguntang\Satusehat\Enums\MedicationRequest;

/**
 * FHIR R4 - MedicationRequest.priority
 * Standard: http://hl7.org/fhir/request-priority
 */
enum MedicationRequestPriorityEnum: string
{
    /** Rutin */
    case Routine = 'routine';
    /** Mendesak */
    case Urgent  = 'urgent';
    /** Sesegera mungkin */
    case Asap    = 'asap';
    /** Segera/darurat */
    case Stat    = 'stat';
}
