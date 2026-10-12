<?php

declare (strict_types=1);
namespace ShopMagicVendor\WPDesk\Mutex;

interface ExpiringMutex extends Mutex
{
    public function getKey(): LockKey;
    public function refreshLock(int $ttl): bool;
}
