<?php

namespace App\Services;

use App\Models\LandingService;
use App\Models\LandingStat;
use App\Models\LandingTestimonial;
use Illuminate\Support\Facades\Cache;

/**
 * Single source of truth for the public landing page's editable content.
 * Kept separate from SettingsService/AssessmentConfigService because this
 * is marketing content, not system configuration — see the Website
 * Content vs. Settings split in the admin navigation.
 */
class LandingContentService
{
    private const CACHE_TTL = 3600;

    public static function heroStats()
    {
        return Cache::remember('landing.stats.hero', self::CACHE_TTL, function () {
            return LandingStat::where('placement', 'hero')->where('active', true)->orderBy('sort_order')->get();
        });
    }

    public static function statsBar()
    {
        return Cache::remember('landing.stats.bar', self::CACHE_TTL, function () {
            return LandingStat::where('placement', 'bar')->where('active', true)->orderBy('sort_order')->get();
        });
    }

    public static function services()
    {
        return Cache::remember('landing.services', self::CACHE_TTL, function () {
            return LandingService::where('active', true)->orderBy('sort_order')->get();
        });
    }

    public static function testimonials()
    {
        return Cache::remember('landing.testimonials', self::CACHE_TTL, function () {
            return LandingTestimonial::where('active', true)->orderBy('sort_order')->get();
        });
    }

    public static function forgetCache(): void
    {
        Cache::forget('landing.stats.hero');
        Cache::forget('landing.stats.bar');
        Cache::forget('landing.services');
        Cache::forget('landing.testimonials');
    }
}
