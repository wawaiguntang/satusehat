<?php

namespace Wawaiguntang\Satusehat\Enums\CarePlan;

/**
 * FHIR R4 - CarePlan.intent
 * Standard: http://hl7.org/fhir/care-plan-intent
 */
enum CarePlanIntentEnum: string
{
    /** Usulan */
    case Proposal  = 'proposal';
    /** Rencana */
    case Plan      = 'plan';
    /** Order */
    case Order     = 'order';
    /** Opsi */
    case Option    = 'option';
}
