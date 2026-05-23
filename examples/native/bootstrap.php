<?php

/**
 * Bootstrap — inisialisasi SatusehatClient untuk Native PHP
 *
 * Dependencies:
 *   composer require wawaiguntang/satusehat guzzlehttp/guzzle \
 *                    http-interop/http-factory-guzzle cache/filesystem-adapter
 */

require_once __DIR__ . '/../../vendor/autoload.php';

use Cache\Adapter\Filesystem\FilesystemCachePool;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\HttpFactory;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use Wawaiguntang\Satusehat\SatusehatClient;

// ── Konfigurasi ────────────────────────────────────────────────────────────
$clientId     = getenv('SATUSEHAT_CLIENT_ID')     ?: 'your-client-id';
$clientSecret = getenv('SATUSEHAT_CLIENT_SECRET') ?: 'your-client-secret';
$env          = getenv('SATUSEHAT_ENV')            ?: 'production'; // 'staging' | 'production'

$baseUrl = $env === 'staging'
    ? 'https://api-satusehat-stg.dto.kemkes.go.id/fhir-r4/v1'
    : 'https://api-satusehat.kemkes.go.id/fhir-r4/v1';

$authUrl = $env === 'staging'
    ? 'https://api-satusehat-stg.dto.kemkes.go.id/oauth2/v1'
    : 'https://api-satusehat.kemkes.go.id/oauth2/v1';

// ── PSR-16 Cache (file-based) ───────────────────────────────────────────────
$cacheDir       = __DIR__ . '/../../storage/cache';
$filesystemCache = new FilesystemCachePool(
    new Filesystem(new Local($cacheDir))
);

// ── SatusehatClient ─────────────────────────────────────────────────────────
$httpFactory = new HttpFactory();

$satusehat = new SatusehatClient(
    clientId:       $clientId,
    clientSecret:   $clientSecret,
    httpClient:     new GuzzleClient(),
    requestFactory: $httpFactory,
    streamFactory:  $httpFactory,
    cache:          $filesystemCache,
    baseUrl:        $baseUrl,
    authUrl:        $authUrl,
);

return $satusehat;
