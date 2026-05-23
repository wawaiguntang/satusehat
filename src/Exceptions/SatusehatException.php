<?php

namespace Wawaiguntang\Satusehat\Exceptions;

use RuntimeException;
use Wawaiguntang\Satusehat\Responses\OperationOutcomeResponse;

class SatusehatException extends RuntimeException
{
    public function __construct(
        string                           $message,
        public readonly int              $httpStatusCode,
        public readonly ?OperationOutcomeResponse $operationOutcome = null,
        public readonly ?string          $rawBody = null,
    ) {
        parent::__construct($message, $httpStatusCode);
    }

    public static function fromResponseBody(int $statusCode, string $body): static
    {
        $data    = json_decode($body, true) ?? [];
        $outcome = null;

        if (isset($data['resourceType']) && $data['resourceType'] === 'OperationOutcome') {
            $outcome = OperationOutcomeResponse::fromArray($data);
            $message = $outcome->details ?: $outcome->code;
        } elseif (isset($data['fault'])) {
            $outcome = OperationOutcomeResponse::fromApigee($data);
            $message = $outcome->details;
        } elseif (isset($data['ErrorCode'])) {
            $outcome = OperationOutcomeResponse::fromAuthError($data);
            $message = $outcome->details;
        } else {
            $message = "HTTP {$statusCode}";
        }

        return new static($message, $statusCode, $outcome, $body);
    }
}
