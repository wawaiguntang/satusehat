<?php

namespace App\Providers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use Wawaiguntang\Satusehat\SatusehatClient;
use Wawaiguntang\Satusehat\SatusehatClientFactory;

class SatusehatServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../../../config/satusehat.php',
            'satusehat'
        );

        $this->app->singleton(SatusehatClient::class, function ($app) {
            $config = $app['config']['satusehat'];
            $env    = $config['env'] ?? 'production';
            $urls   = $config['urls'][$env] ?? $config['urls']['production'];

            $cacheStore = $config['cache_store']
                ? Cache::store($config['cache_store'])
                : Cache::store();

            return SatusehatClientFactory::create(
                clientId:     $config['client_id'],
                clientSecret: $config['client_secret'],
                cache:        $cacheStore,
                baseUrl:      $urls['base'],
                authUrl:      $urls['auth'],
            );
        });
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../../../../config/satusehat.php' => config_path('satusehat.php'),
        ], 'satusehat-config');
    }
}
