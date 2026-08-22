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
        $stats = Cache::remember('landing.stats.hero', self::CACHE_TTL, function () {
            return LandingStat::where('placement', 'hero')->where('active', true)->orderBy('sort_order')->get();
        });

        return self::applyDynamicYears($stats);
    }

    public static function statsBar()
    {
        $stats = Cache::remember('landing.stats.bar', self::CACHE_TTL, function () {
            return LandingStat::where('placement', 'bar')->where('active', true)->orderBy('sort_order')->get();
        });

        return self::applyDynamicYears($stats);
    }

    /**
     * The "years of excellence" / "since <year>" stats are computed from
     * company_founded_year (not the cached DB value) so they stay correct
     * every year without anyone having to edit the stat text — see
     * company_years_active() in app/helpers.php.
     */
    private static function applyDynamicYears($stats)
    {
        return $stats->map(function ($stat) {
            if ($stat->label === 'of Excellence') {
                $stat->value = company_years_active().' Years';
            } elseif ($stat->label === 'Years of Service') {
                $stat->value = 'Since '.setting('company_founded_year');
            }

            return $stat;
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
