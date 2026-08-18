<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateCompanyInformationRequest;
use App\Models\AssessmentService;
use App\Models\AssessmentServiceSubtype;
use App\Models\BlockedDate;
use App\Models\ClientType;
use App\Models\CoverageProvince;
use App\Models\EstablishmentType;
use App\Models\LaborRate;
use App\Models\LandingService;
use App\Models\LandingStat;
use App\Models\LandingTestimonial;
use App\Models\Setting;
use App\Services\AssessmentConfigService;
use App\Services\QuotationConfigService;
use App\Services\SettingsService;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    private const COMPANY_FIELD_LABELS = [
        'company_name' => 'company name',
        'company_tagline' => 'tagline',
        'company_description' => 'short description',
        'company_founded_year' => 'year founded',
        'company_logo_path' => 'logo',
        'company_address_main' => 'main office address',
        'company_address_satellite' => 'satellite office address',
        'company_phone_primary' => 'primary phone',
        'company_phone_secondary' => 'secondary phone',
        'company_phone_landline' => 'landline',
        'company_email_primary' => 'primary email',
        'company_email_secondary' => 'secondary email',
        'company_hours_days' => 'working days',
        'company_hours_open' => 'opening time',
        'company_hours_close' => 'closing time',
    ];

    public function index()
    {
        $company = SettingsService::getGroup('company');
        $clientTypes = ClientType::with('establishmentTypes')->orderBy('sort_order')->get();
        $services = AssessmentService::with('subtypes')->orderBy('sort_order')->get();
        $workingDays = AssessmentConfigService::workingDays();
        $maxBookingsPerSlot = AssessmentConfigService::maxBookingsPerSlot();
        $blockedDates = BlockedDate::orderBy('date')->get();
        $coverageProvinces = CoverageProvince::orderBy('sort_order')->get();
        $laborRates = LaborRate::orderBy('service_type')->orderByRaw('client_type_condition IS NULL')->orderBy('client_type_condition')->get();
        $legal = SettingsService::getGroup('legal');
        $legalMeta = Setting::whereIn('key', ['legal_terms_content', 'legal_privacy_content'])
            ->with('updatedBy')->get()->keyBy('key');

        $landing = SettingsService::getGroup('landing');
        $landingHeroStats = LandingStat::where('placement', 'hero')->orderBy('sort_order')->get();
        $landingBarStats = LandingStat::where('placement', 'bar')->orderBy('sort_order')->get();
        $landingServices = LandingService::orderBy('sort_order')->get();
        $landingTestimonials = LandingTestimonial::orderBy('sort_order')->get();

        return view('admin.admin-settings', compact(
            'company', 'clientTypes', 'services', 'workingDays', 'maxBookingsPerSlot', 'blockedDates',
            'coverageProvinces', 'laborRates', 'legal', 'legalMeta',
            'landing', 'landingHeroStats', 'landingBarStats', 'landingServices', 'landingTestimonials'
        ));
    }

    public function updateCompanyInformation(UpdateCompanyInformationRequest $request)
    {
        $validated = collect($request->validated())
            ->map(fn ($value) => is_string($value) ? str_replace("\r\n", "\n", $value) : $value)
            ->all();

        $before = Setting::whereIn('key', array_keys(self::COMPANY_FIELD_LABELS))->pluck('value', 'key');

        $values = collect(self::COMPANY_FIELD_LABELS)->keys()
            ->mapWithKeys(fn ($key) => [$key => $validated[$key] ?? null])
            ->all();

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('company', 'public');
            $values['company_logo_path'] = 'storage/'.$path;
        } else {
            unset($values['company_logo_path']);
        }

        SettingsService::setMany($values, 'company', auth()->id());

        $changed = collect($values)
            ->filter(fn ($value, $key) => ($before[$key] ?? null) !== $value)
            ->keys()
            ->map(fn ($key) => self::COMPANY_FIELD_LABELS[$key])
            ->all();

        if (! empty($changed)) {
            ActivityLogController::log(
                'Settings',
                'Updated',
                'Super Admin updated company information ('.implode(', ', $changed).').'
            );
        }

        return redirect()->route('admin-settings')->with('success', 'Company information saved.');
    }

    public function storeClientType(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:client_types,name',
            'description' => 'nullable|string|max:150',
            'icon' => 'nullable|string|max:50',
            'default_size' => 'required|in:small,large',
        ]);

        $validated['sort_order'] = (ClientType::max('sort_order') ?? -1) + 1;
        $validated['active'] = true;
        ClientType::create($validated);

        AssessmentConfigService::forgetCache();

        ActivityLogController::log('Settings', 'Updated', "Super Admin added client type \"{$validated['name']}\".");

        return redirect(route('admin-settings').'#assessment-scheduling')->with('success', 'Client type added.');
    }

    public function updateClientType(Request $request, ClientType $clientType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:client_types,name,'.$clientType->id,
            'description' => 'nullable|string|max:150',
            'icon' => 'nullable|string|max:50',
            'default_size' => 'required|in:small,large',
        ]);
        $validated['active'] = $request->boolean('active');

        $wasActive = $clientType->active;
        $clientType->update($validated);

        AssessmentConfigService::forgetCache();

        if ($wasActive !== $validated['active']) {
            ActivityLogController::log(
                'Settings',
                'Updated',
                'Super Admin '.($validated['active'] ? 'enabled' : 'disabled')." client type \"{$clientType->name}\"."
            );
        } else {
            ActivityLogController::log('Settings', 'Updated', "Super Admin updated client type \"{$clientType->name}\".");
        }

        return redirect(route('admin-settings').'#assessment-scheduling')->with('success', 'Client type updated.');
    }

    public function storeEstablishmentType(Request $request)
    {
        $validated = $request->validate([
            'client_type_id' => 'required|exists:client_types,id',
            'name' => 'required|string|max:150',
            'icon' => 'nullable|string|max:50',
            'size' => 'required|in:small,large',
        ]);

        $validated['sort_order'] = (EstablishmentType::where('client_type_id', $validated['client_type_id'])->max('sort_order') ?? -1) + 1;
        $validated['active'] = true;
        $establishmentType = EstablishmentType::create($validated);

        AssessmentConfigService::forgetCache();

        ActivityLogController::log(
            'Settings',
            'Updated',
            "Super Admin added establishment type \"{$establishmentType->name}\" under {$establishmentType->clientType->name}."
        );

        return redirect(route('admin-settings').'#assessment-scheduling')->with('success', 'Establishment type added.');
    }

    public function updateEstablishmentType(Request $request, EstablishmentType $establishmentType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'icon' => 'nullable|string|max:50',
            'size' => 'required|in:small,large',
        ]);
        $validated['active'] = $request->boolean('active');

        $wasActive = $establishmentType->active;
        $establishmentType->update($validated);

        AssessmentConfigService::forgetCache();

        if ($wasActive !== $validated['active']) {
            ActivityLogController::log(
                'Settings',
                'Updated',
                'Super Admin '.($validated['active'] ? 'enabled' : 'disabled')." establishment type \"{$establishmentType->name}\"."
            );
        } else {
            ActivityLogController::log('Settings', 'Updated', "Super Admin updated establishment type \"{$establishmentType->name}\".");
        }

        return redirect(route('admin-settings').'#assessment-scheduling')->with('success', 'Establishment type updated.');
    }

    public function storeService(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:assessment_services,name',
            'icon' => 'nullable|string|max:50',
            'has_subtypes' => 'nullable|boolean',
        ]);
        $validated['has_subtypes'] = $request->boolean('has_subtypes');
        $validated['sort_order'] = (AssessmentService::max('sort_order') ?? -1) + 1;
        $validated['active'] = true;

        AssessmentService::create($validated);
        AssessmentConfigService::forgetCache();

        ActivityLogController::log('Settings', 'Updated', "Super Admin added assessment service \"{$validated['name']}\".");

        return redirect(route('admin-settings').'#assessment-scheduling')->with('success', 'Service added.');
    }

    public function updateService(Request $request, AssessmentService $assessmentService)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:assessment_services,name,'.$assessmentService->id,
            'icon' => 'nullable|string|max:50',
            'has_subtypes' => 'nullable|boolean',
        ]);
        $validated['has_subtypes'] = $request->boolean('has_subtypes');
        $validated['active'] = $request->boolean('active');

        $wasActive = $assessmentService->active;
        $assessmentService->update($validated);

        AssessmentConfigService::forgetCache();

        if ($wasActive !== $validated['active']) {
            ActivityLogController::log(
                'Settings',
                'Updated',
                'Super Admin '.($validated['active'] ? 'enabled' : 'disabled')." assessment service \"{$assessmentService->name}\"."
            );
        } else {
            ActivityLogController::log('Settings', 'Updated', "Super Admin updated assessment service \"{$assessmentService->name}\".");
        }

        return redirect(route('admin-settings').'#assessment-scheduling')->with('success', 'Service updated.');
    }

    public function storeSubtype(Request $request)
    {
        $validated = $request->validate([
            'assessment_service_id' => 'required|exists:assessment_services,id',
            'name' => 'required|string|max:100',
        ]);

        $validated['sort_order'] = (AssessmentServiceSubtype::where('assessment_service_id', $validated['assessment_service_id'])->max('sort_order') ?? -1) + 1;
        $validated['active'] = true;
        $subtype = AssessmentServiceSubtype::create($validated);

        AssessmentConfigService::forgetCache();

        ActivityLogController::log(
            'Settings',
            'Updated',
            "Super Admin added sub-type \"{$subtype->name}\" under {$subtype->service->name}."
        );

        return redirect(route('admin-settings').'#assessment-scheduling')->with('success', 'Sub-type added.');
    }

    public function updateSubtype(Request $request, AssessmentServiceSubtype $subtype)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
        ]);
        $validated['active'] = $request->boolean('active');

        $wasActive = $subtype->active;
        $subtype->update($validated);

        AssessmentConfigService::forgetCache();

        if ($wasActive !== $validated['active']) {
            ActivityLogController::log(
                'Settings',
                'Updated',
                'Super Admin '.($validated['active'] ? 'enabled' : 'disabled')." sub-type \"{$subtype->name}\"."
            );
        } else {
            ActivityLogController::log('Settings', 'Updated', "Super Admin updated sub-type \"{$subtype->name}\".");
        }

        return redirect(route('admin-settings').'#assessment-scheduling')->with('success', 'Sub-type updated.');
    }

    public function updateScheduling(Request $request)
    {
        $validated = $request->validate([
            'working_days' => 'nullable|array',
            'working_days.*' => 'integer|min:0|max:6',
            'max_bookings_per_slot' => 'required|integer|min:1|max:20',
        ]);

        SettingsService::setMany([
            'scheduling_working_days' => json_encode(array_values($validated['working_days'] ?? [])),
            'scheduling_max_bookings_per_slot' => (string) $validated['max_bookings_per_slot'],
        ], 'scheduling', auth()->id());

        AssessmentConfigService::forgetCache();

        ActivityLogController::log('Settings', 'Updated', 'Super Admin updated working days and slot capacity.');

        return redirect(route('admin-settings').'#assessment-scheduling')->with('success', 'Scheduling settings saved.');
    }

    public function storeBlockedDate(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date|unique:blocked_dates,date',
            'label' => 'nullable|string|max:100',
        ]);

        BlockedDate::create($validated);
        AssessmentConfigService::forgetCache();

        ActivityLogController::log(
            'Settings',
            'Updated',
            "Super Admin blocked {$validated['date']}".(empty($validated['label']) ? '' : " ({$validated['label']})").' on the assessment calendar.'
        );

        return redirect(route('admin-settings').'#assessment-scheduling')->with('success', 'Blocked date added.');
    }

    public function destroyBlockedDate(BlockedDate $blockedDate)
    {
        $date = $blockedDate->date->format('Y-m-d');
        $blockedDate->delete();
        AssessmentConfigService::forgetCache();

        ActivityLogController::log('Settings', 'Updated', "Super Admin removed the block on {$date}.");

        return redirect(route('admin-settings').'#assessment-scheduling')->with('success', 'Blocked date removed.');
    }

    public function storeLaborRate(Request $request)
    {
        $validated = $request->validate([
            'service_type' => 'required|string|max:100',
            'client_type_condition' => 'nullable|string|max:100',
            'rate_percent' => 'required|numeric|min:0|max:100',
        ]);
        $validated['client_type_condition'] = $validated['client_type_condition'] ?: null;

        $exists = LaborRate::where('service_type', $validated['service_type'])
            ->where('client_type_condition', $validated['client_type_condition'])
            ->exists();
        abort_if($exists, 422, 'A rate for that service and client type already exists — edit it below instead.');

        $validated['active'] = true;
        $validated['updated_by'] = auth()->id();
        $rate = LaborRate::create($validated);

        QuotationConfigService::forgetCache();

        $condition = $rate->client_type_condition ?? 'Any client type';
        ActivityLogController::log(
            'Settings',
            'Updated',
            "Super Admin added a labor rate: {$rate->service_type} / {$condition} = {$rate->rate_percent}%."
        );

        return redirect(route('admin-settings').'#quotation-configuration')->with('success', 'Labor rate added.');
    }

    public function updateLaborRate(Request $request, LaborRate $laborRate)
    {
        $validated = $request->validate([
            'rate_percent' => 'required|numeric|min:0|max:100',
        ]);
        $validated['active'] = $request->boolean('active');
        $validated['updated_by'] = auth()->id();

        $before = (float) $laborRate->rate_percent;
        $wasActive = $laborRate->active;
        $laborRate->update($validated);

        QuotationConfigService::forgetCache();

        $condition = $laborRate->client_type_condition ?? 'Any client type';
        if ($before !== (float) $validated['rate_percent']) {
            ActivityLogController::log(
                'Settings',
                'Updated',
                "Super Admin changed the {$laborRate->service_type} / {$condition} labor rate from {$before}% to {$validated['rate_percent']}%."
            );
        } elseif ($wasActive !== $validated['active']) {
            ActivityLogController::log(
                'Settings',
                'Updated',
                'Super Admin '.($validated['active'] ? 'enabled' : 'disabled')." the {$laborRate->service_type} / {$condition} labor rate."
            );
        }

        return redirect(route('admin-settings').'#quotation-configuration')->with('success', 'Labor rate updated.');
    }

    public function updateTerms(Request $request)
    {
        $validated = $request->validate(['content' => 'required|string|max:20000']);

        SettingsService::setMany([
            'legal_terms_content' => $validated['content'],
            'legal_terms_updated_at' => now()->toDateString(),
        ], 'legal', auth()->id());

        ActivityLogController::log('Settings', 'Updated', 'Super Admin updated the Terms of Service.');

        return redirect(route('admin-settings').'#legal-policies')->with('success', 'Terms of Service saved.');
    }

    public function updatePrivacy(Request $request)
    {
        $validated = $request->validate(['content' => 'required|string|max:20000']);

        SettingsService::setMany([
            'legal_privacy_content' => $validated['content'],
            'legal_privacy_updated_at' => now()->toDateString(),
        ], 'legal', auth()->id());

        ActivityLogController::log('Settings', 'Updated', 'Super Admin updated the Privacy Policy.');

        return redirect(route('admin-settings').'#legal-policies')->with('success', 'Privacy Policy saved.');
    }

    public function storeCoverageProvince(Request $request)
    {
        $validated = $request->validate([
            'region' => 'required|string|max:100',
            'province' => 'required|string|max:100|unique:coverage_provinces,province',
        ]);

        $validated['sort_order'] = (CoverageProvince::max('sort_order') ?? -1) + 1;
        $validated['active'] = true;
        CoverageProvince::create($validated);

        AssessmentConfigService::forgetCache();
        ActivityLogController::log('Settings', 'Updated', "Super Admin added \"{$validated['province']}\" to the assessment coverage area.");

        return redirect(route('admin-settings').'#assessment-scheduling')->with('success', 'Province added.');
    }

    public function updateCoverageProvince(Request $request, CoverageProvince $coverageProvince)
    {
        $validated = $request->validate([
            'region' => 'required|string|max:100',
            'province' => 'required|string|max:100|unique:coverage_provinces,province,'.$coverageProvince->id,
        ]);
        $validated['active'] = $request->boolean('active');

        $wasActive = $coverageProvince->active;
        $coverageProvince->update($validated);

        AssessmentConfigService::forgetCache();

        if ($wasActive !== $validated['active']) {
            ActivityLogController::log(
                'Settings',
                'Updated',
                'Super Admin '.($validated['active'] ? 'enabled' : 'disabled')." assessment coverage for \"{$coverageProvince->province}\"."
            );
        } else {
            ActivityLogController::log('Settings', 'Updated', "Super Admin updated the coverage area \"{$coverageProvince->province}\".");
        }

        return redirect(route('admin-settings').'#assessment-scheduling')->with('success', 'Province updated.');
    }
}
