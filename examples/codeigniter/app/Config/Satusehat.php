<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Satusehat extends BaseConfig
{
    /**
     * Client ID dari platform.satusehat.kemkes.go.id
     */
    public string $clientId = '';

    /**
     * Client Secret dari platform.satusehat.kemkes.go.id
     */
    public string $clientSecret = '';

    /**
     * Environment: 'production' atau 'staging'
     */
    public string $env = 'production';

    /**
     * URL API per environment
     */
    public array $urls = [
        'production' => [
            'base' => 'https://api-satusehat.kemkes.go.id/fhir-r4/v1',
            'auth' => 'https://api-satusehat.kemkes.go.id/oauth2/v1',
        ],
        'staging' => [
            'base' => 'https://api-satusehat-stg.dto.kemkes.go.id/fhir-r4/v1',
            'auth' => 'https://api-satusehat-stg.dto.kemkes.go.id/oauth2/v1',
        ],
    ];

    public function __construct()
    {
        parent::__construct();

        // Baca dari .env jika tersedia
        $this->clientId     = env('SATUSEHAT_CLIENT_ID',     $this->clientId);
        $this->clientSecret = env('SATUSEHAT_CLIENT_SECRET', $this->clientSecret);
        $this->env          = env('SATUSEHAT_ENV',           $this->env);
    }

    public function baseUrl(): string
    {
        return $this->urls[$this->env]['base'] ?? $this->urls['production']['base'];
    }

    public function authUrl(): string
    {
        return $this->urls[$this->env]['auth'] ?? $this->urls['production']['auth'];
    }
}
