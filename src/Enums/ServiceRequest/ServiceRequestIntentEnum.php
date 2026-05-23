<?php

namespace Wawaiguntang\Satusehat\Enums\ServiceRequest;

/**
 * FHIR R4 - ServiceRequest.intent
 * Standard: http://hl7.org/fhir/request-intent
 */
enum ServiceRequestIntentEnum: string
{
    /** Usulan */
    case Proposal      = 'proposal';
    /** Rencana */
    case Plan          = 'plan';
    /** Direktif */
    case Directive     = 'directive';
    /** Order */
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
