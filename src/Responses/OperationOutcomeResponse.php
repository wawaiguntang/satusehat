<?php

namespace Wawaiguntang\Satusehat\Responses;

class OperationOutcomeResponse
{
    public function __construct(
        public readonly string  $severity,
        public readonly string  $code,
        public readonly string  $details,
        public readonly ?string $diagnostics = null,
        public readonly ?string $expression  = null,
    ) {}

    public static function fromArray(array $data): self
    {
        $issue = $data['issue'][0] ?? [];

        return new self(
            severity:    $issue['severity']              ?? 'error',
            code:        $issue['code']                  ?? 'unknown',
            details:     $issue['details']['text']       ?? '',
            diagnostics: $issue['diagnostics']           ?? null,
            expression:  $issue['expression'][0]        ?? null,
        );
    }

    /**
     * Parse from Apigee fault body: {"fault":{"faultstring":"...","detail":{"errorcode":"..."}}}
     */
    public static function fromApigee(array $data): self
    {
        $fault = $data['fault'] ?? [];

        return new self(
            severity:    'error',
            code:        'security',
            details:     $fault['faultstring']               ?? '',
            diagnostics: $fault['detail']['errorcode']       ?? null,
        );
    }

    /**
     * Parse from auth error body: {"ErrorCode":"invalid_client","Error":"ClientId is Invalid"}
     */
    public static function fromAuthError(array $data): self
    {
        return new self(
            severity:    'error',
            code:        'security',
            details:     $data['Error']     ?? '',
            diagnostics: $data['ErrorCode'] ?? null,
        );
    }
}
