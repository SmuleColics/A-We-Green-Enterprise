<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

/**
 * Single source of truth for system configuration values. Every
 * Super Admin-editable setting is read and written through here so
 * callers never query the settings table directly and never disagree
 * on what the current value is.
 */
class SettingsService
{
    private const CACHE_TTL = 3600;

    public static function get(string $key, $default = null)
    {
        return Cache::remember("settings.{$key}", self::CACHE_TTL, function () use ($key, $default) {
            $value = Setting::where('key', $key)->value('value');

            return $value ?? $default;
        });
    }

    public static function getGroup(string $group): array
    {
        return Cache::remember("settings.group.{$group}", self::CACHE_TTL, function () use ($group) {
            return Setting::where('group', $group)->pluck('value', 'key')->all();
        });
    }

    /**
     * @param  array<string,string|null>  $values
     */
    public static function setMany(array $values, string $group, ?int $updatedBy = null): void
    {
        foreach ($values as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'group' => $group, 'updated_by' => $updatedBy]
            );
            Cache::forget("settings.{$key}");
        }
        Cache::forget("settings.group.{$group}");
    }
}
