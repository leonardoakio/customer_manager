<?php

namespace App\Infrastructure\Cache;

use App\Infrastructure\Adapters\CacheInterface;

class PostalCodeCache
{
    private const KEY = '_postal-code_%s';


    public function __construct(
        private CacheInterface $cache
    ) {
    }

    public function save(string $postalCode, array $data, int $ttl = 86400000)
    {
        $serializedData = json_encode($data);

        return $this->cache->save(
            key: sprintf(self::KEY, $postalCode),
            value: $serializedData,
            ttl: $ttl
        );
    }

    public function get(string $postalCode): ?array
    {
        $cachedData = $this->cache->get(sprintf(self::KEY, $postalCode));
    
        if ($cachedData !== null) {
            return json_decode($cachedData, true);
        }
    
        return null;
    }
    public function delete(string $postalCode)
    {
        return $this->cache->delete(sprintf(self::KEY, $postalCode));
    }
}
