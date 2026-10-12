<?php

namespace ShopMagicVendor\WPDesk\Tracker;

if (interface_exists(\ShopMagicVendor\WPDesk\PluginBuilder\Plugin\Hookable::class) && interface_exists(\ShopMagicVendor\WPDesk\PluginBuilder\Plugin\HookableCollection::class)) {
    class_alias(\ShopMagicVendor\WPDesk\PluginBuilder\Plugin\Hookable::class, Hookable::class);
    class_alias(\ShopMagicVendor\WPDesk\PluginBuilder\Plugin\HookableCollection::class, HookableCollection::class);
} else {
    require_once __DIR__ . '/Hookable.php';
    require_once __DIR__ . '/HookableCollection.php';
}
