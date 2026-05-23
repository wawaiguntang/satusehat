<?php

namespace Wawaiguntang\Satusehat\Enums\EpisodeOfCare;

/**
 * FHIR R4 - EpisodeOfCare.status
 * Standard: http://hl7.org/fhir/episode-of-care-status
 */
enum EpisodeOfCareStatusEnum: string
{
    /** Direncanakan */
    case Planned        = 'planned';
    /** Dalam antrian */
    case Waitlist       = 'waitlist';
    /** Aktif */
    case Active         = 'active';
    /** Ditunda */
    case OnHold         = 'onhold';
    /** Selesai */
    case Finished       = 'finished';
    /** Dibatalkan */
    case Cancelled      = 'cancelled';
    /** Input dengan error */
    case EnteredInError = 'entered-in-error';
}
