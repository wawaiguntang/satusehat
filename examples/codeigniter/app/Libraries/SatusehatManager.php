<?php

namespace App\Libraries;

use CodeIgniter\Cache\CacheInterface as CICache;
use Config\Satusehat as SatusehatConfig;
use Psr\SimpleCache\CacheInterface as PsrCache;
use Wawaiguntang\Satusehat\SatusehatClient;
use Wawaiguntang\Satusehat\SatusehatClientFactory;

/**
 * Wrapper PSR-16 untuk CodeIgniter CacheInterface
 */
class CIToSatusehatCache implements PsrCache
{
    public function __construct(
        private readonly CICache $cache,
        private readonly string  $prefix = 'satusehat_',
    ) {}

    public function get(string $key, mixed $default = null): mixed
    {
        $value = $this->cache->get($this->prefix . $key);
        return $value !== null ? $value : $default;
    }

    public function set(string $key, mixed $value, null|int|\DateInterval $ttl = null): bool
    {
        $seconds = $ttl instanceof \DateInterval ? (int) $ttl->s : (int) ($ttl ?? 0);
        return $this->cache->save($this->prefix . $key, $value, $seconds);
    }

    public function delete(string $key): bool
    {
        return $this->cache->delete($this->prefix . $key);
    }

    public function clear(): bool
    {
        return $this->cache->clean();
    }

    public function getMultiple(iterable $keys, mixed $default = null): iterable
    {
        foreach ($keys as $key) {
            yield $key => $this->get($key, $default);
        }
    }

    public function setMultiple(iterable $values, null|int|\DateInterval $ttl = null): bool
    {
        foreach ($values as $key => $value) {
            $this->set($key, $value, $ttl);
        }
        return true;
    }

    public function deleteMultiple(iterable $keys): bool
    {
        foreach ($keys as $key) {
            $this->delete($key);
        }
        return true;
    }

    public function has(string $key): bool
    {
        return $this->cache->get($this->prefix . $key) !== null;
    }
}

/**
 * SatusehatManager — singleton factory untuk SatusehatClient di CodeIgniter 4
 *
 * Penggunaan:
 *   $manager   = new SatusehatManager();
 *   $satusehat = $manager->client();
 *   $patient   = $satusehat->patient()->getByNik('3271...');
 */
class SatusehatManager
{
    private static ?SatusehatClient $instance = null;

    public function __construct(
        private readonly SatusehatConfig $config,
    ) {
        if ($this->config->clientId === '') {
            $this->config = config('Satusehat');
        }
    }

    public function client(): SatusehatClient
    {
        if (self::$instance === null) {
            $ciCache = \Config\Services::cache();
            $cache   = new CIToSatusehatCache($ciCache);

            self::$instance = SatusehatClientFactory::create(
                clientId:     $this->config->clientId,
                clientSecret: $this->config->clientSecret,
                cache:        $cache,
                baseUrl:      $this->config->baseUrl(),
                authUrl:      $this->config->authUrl(),
            );
        }

        return self::$instance;
    }
}
