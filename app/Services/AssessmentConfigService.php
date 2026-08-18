<?php

namespace App\Services;

use App\Models\Assessment;
use App\Models\AssessmentService;
use App\Models\BlockedDate;
use App\Models\ClientType;
use App\Models\CoverageProvince;
use Carbon\CarbonInterface;
use Illuminate\Support\Facades\Cache;

/**
 * Single source of truth for client types and establishment types. The
 * booking wizard, its server-side validation, and the Settings CRUD all
 * read through here so a type disabled in Settings actually disappears
 * from the form AND stops being accepted by the server — not just one
 * of the two, which was the original audit's core finding.
 */
class AssessmentConfigService
{
    private const CACHE_KEY = 'assessment-config.client-types';

    private const SERVICES_CACHE_KEY = 'assessment-config.services';

    private const CACHE_TTL = 3600;

    /**
     * Active client types with their active establishment types, in
     * display order. Used both for rendering the wizard and for validation.
     */
    public static function activeClientTypes()
    {
        return Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function () {
            return ClientType::with(['establishmentTypes' => fn ($q) => $q->where('active', true)])
                ->where('active', true)
                ->orderBy('sort_order')
                ->get();
        });
    }

    public static function isValidClientType(string $name): bool
    {
        return self::activeClientTypes()->contains('name', $name);
    }

    public static function isValidEstablishment(string $clientTypeName, string $establishmentName): bool
    {
        $clientType = self::activeClientTypes()->firstWhere('name', $clientTypeName);

        return $clientType && $clientType->establishmentTypes->contains('name', $establishmentName);
    }

    /**
     * Active assessment services with their active sub-types, in display order.
     */
    public static function activeServices()
    {
        return Cache::remember(self::SERVICES_CACHE_KEY, self::CACHE_TTL, function () {
            return AssessmentService::with(['subtypes' => fn ($q) => $q->where('active', true)])
                ->where('active', true)
                ->orderBy('sort_order')
                ->get();
        });
    }

    public static function isValidService(string $name): bool
    {
        return self::activeServices()->contains('name', $name);
    }

    public static function isValidSubtype(string $serviceName, string $subtypeName): bool
    {
        $service = self::activeServices()->firstWhere('name', $serviceName);

        return $service && $service->subtypes->contains('name', $subtypeName);
    }

    /**
     * Weekday numbers (0=Sun..6=Sat) the business is open on.
     */
    public static function workingDays(): array
    {
        $raw = SettingsService::get('scheduling_working_days');

        return $raw ? json_decode($raw, true) : [1, 2, 3, 4, 5, 6];
    }

    public static function maxBookingsPerSlot(): int
    {
        return (int) SettingsService::get('scheduling_max_bookings_per_slot', 1);
    }

    public static function isBlockedDate(string $isoDate): bool
    {
        return in_array($isoDate, self::blockedDateStrings());
    }

    public static function blockedDateStrings(): array
    {
        return Cache::remember('assessment-config.blocked-dates', self::CACHE_TTL, function () {
            return BlockedDate::pluck('date')->map(fn ($d) => $d->format('Y-m-d'))->all();
        });
    }

    public static function isWorkingDay(CarbonInterface $date): bool
    {
        return in_array($date->dayOfWeek, self::workingDays())
            && ! in_array($date->format('Y-m-d'), self::blockedDateStrings());
    }

    /**
     * Whether a given date + time slot still has room, honoring
     * max_bookings_per_slot and the fact that a Full Day booking occupies
     * both the morning and afternoon capacity for that date.
     */
    public static function isSlotAvailable(string $isoDate, string $timeSlot): bool
    {
        $max = self::maxBookingsPerSlot();

        $existing = Assessment::whereDate('preferred_date', $isoDate)
            ->whereIn('status', ['Pending', 'Confirmed'])
            ->pluck('time_slot');

        $morningCount = $existing->filter(fn ($slot) => in_array($slot, ['Morning', 'Full Day']))->count();
        $afternoonCount = $existing->filter(fn ($slot) => in_array($slot, ['Afternoon', 'Full Day']))->count();

        return match ($timeSlot) {
            'Full Day' => $morningCount < $max && $afternoonCount < $max,
            'Morning' => $morningCount < $max,
            'Afternoon' => $afternoonCount < $max,
            default => false,
        };
    }

    /**
     * Active provinces, grouped by region and in display order. Used both
     * for the booking form's province dropdown and for validation.
     */
    public static function activeProvinces()
    {
        return Cache::remember('assessment-config.provinces', self::CACHE_TTL, function () {
            return CoverageProvince::where('active', true)->orderBy('sort_order')->get();
        });
    }

    public static function isValidProvince(string $province): bool
    {
        return self::activeProvinces()->contains('province', $province);
    }

    public static function forgetCache(): void
    {
        Cache::forget(self::CACHE_KEY);
        Cache::forget(self::SERVICES_CACHE_KEY);
        Cache::forget('assessment-config.blocked-dates');
        Cache::forget('assessment-config.provinces');
    }
}
