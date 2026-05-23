<?php

namespace Wawaiguntang\Satusehat\Enums\MedicationRequest;

/**
 * FHIR R4 - MedicationRequest.intent
 * Standard: http://hl7.org/fhir/CodeSystem/medicationrequest-intent
 */
enum MedicationRequestIntentEnum: string
{
    /** Usulan pemberian obat */
    case Proposal      = 'proposal';
    /** Rencana pemberian obat */
    case Plan          = 'plan';
    /** Order resep (paling umum) */
    case Order         = 'order';
    /** Order asli */
    case OriginalOrder = 'original-order';
    /** Order refleks */
    case ReflexOrder   = 'reflex-order';
    /** Order pengisian */
    case FillerOrder   = 'filler-order';
    /** Order instance */
    case InstanceOrder = 'instance-order';
    /** Opsi */
    case Option        = 'option';
}
