<?php

namespace Wawaiguntang\Satusehat\Enums\Composition;

/**
 * FHIR R4 - Composition.status
 * Standard: http://hl7.org/fhir/composition-status
 */
enum CompositionStatusEnum: string
{
    /** Draft awal, belum final */
    case Preliminary    = 'preliminary';
    /** Dokumen sudah final */
    case Final          = 'final';
    /** Dokumen direvisi setelah final */
    case Amended        = 'amended';
    /** Dokumen dibuat dengan error */
    case EnteredInError = 'entered-in-error';
}
