<?php

namespace App\Services;

use App\Models\LaborRate;
use Illuminate\Support\Facades\Cache;

/**
 * Single source of truth for the labor rate matrix. Quotation generation
 * reads the rate through here instead of a hardcoded lookup, but the
 * resolved rate is still snapshotted onto the Quotation row at creation
 * time — a later rate change never retroactively alters an issued quote.
 */
class QuotationConfigService
{
    private const CACHE_KEY = 'quotation-config.labor-rates';

    private const CACHE_TTL = 3600;

    public static function activeLaborRates()
    {
        return Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function () {
            return LaborRate::where('active', true)->get();
        });
    }

    /**
     * Resolves the labor rate percentage for a service + client type.
     * Falls back to the service's "Any / Other" row when no client-type-
     * specific override exists, and to 20% if the service isn't configured
     * at all (matching the original hardcoded default).
     */
    public static function resolveLaborRate(string $service, ?string $clientType): float
    {
        $rates = self::activeLaborRates();

        if ($clientType) {
            $specific = $rates->first(fn ($r) => $r->service_type === $service && $r->client_type_condition === $clientType);
            if ($specific) {
                return (float) $specific->rate_percent;
            }
        }

        $any = $rates->first(fn ($r) => $r->service_type === $service && $r->client_type_condition === null);

        return $any ? (float) $any->rate_percent : 20.0;
    }

    public static function forgetCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
