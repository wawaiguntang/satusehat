<?php

namespace Wawaiguntang\Satusehat\Shared\Enums;

/**
 * FHIR R4 - request-priority
 * Standard: http://hl7.org/fhir/request-priority
 *
 * Digunakan oleh: MedicationRequest.priority, ServiceRequest.priority
 */
enum RequestPriorityEnum: string
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
