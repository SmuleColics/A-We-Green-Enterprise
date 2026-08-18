<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\Controller;
use App\Models\LandingService;
use App\Models\LandingStat;
use App\Models\LandingTestimonial;
use App\Services\LandingContentService;
use App\Services\SettingsService;
use Illuminate\Http\Request;

/**
 * Website Content lives as a tab inside Super Admin Settings (not a
 * separate page) — "modifies system contents" is one unified capability,
 * so landing-page copy is edited from the same screen as everything else.
 */
class WebsiteContentController extends Controller
{
    public function updateHero(Request $request)
    {
        $validated = $request->validate([
            'landing_hero_badge' => 'required|string|max:100',
            'landing_hero_headline' => 'required|string|max:500',
            'landing_hero_subtitle' => 'required|string|max:500',
            'landing_hero_cta_primary' => 'required|string|max:60',
            'landing_hero_cta_secondary' => 'required|string|max:60',
            'hero_image' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        $values = collect($validated)->except(['hero_image'])->all();

        if ($request->hasFile('hero_image')) {
            $path = $request->file('hero_image')->store('landing', 'public');
            $values['landing_hero_image_path'] = 'storage/'.$path;
        }

        SettingsService::setMany($values, 'landing', auth()->id());
        LandingContentService::forgetCache();

        ActivityLogController::log('Settings', 'Updated', 'Super Admin updated the landing page hero section.');

        return redirect(route('admin-settings').'#website-content')->with('success', 'Hero section saved.');
    }

    public function updateServicesSection(Request $request)
    {
        $validated = $request->validate([
            'landing_services_heading' => 'required|string|max:200',
            'landing_services_subtitle' => 'required|string|max:300',
        ]);

        SettingsService::setMany($validated, 'landing', auth()->id());
        LandingContentService::forgetCache();

        ActivityLogController::log('Settings', 'Updated', 'Super Admin updated the landing page services section heading.');

        return redirect(route('admin-settings').'#website-content')->with('success', 'Services section saved.');
    }

    public function updateCtaBanner(Request $request)
    {
        $validated = $request->validate([
            'landing_cta_headline' => 'required|string|max:200',
            'landing_cta_subtext' => 'required|string|max:400',
            'landing_cta_footnote' => 'required|string|max:150',
        ]);

        SettingsService::setMany($validated, 'landing', auth()->id());
        LandingContentService::forgetCache();

        ActivityLogController::log('Settings', 'Updated', 'Super Admin updated the landing page CTA banner.');

        return redirect(route('admin-settings').'#website-content')->with('success', 'CTA banner saved.');
    }

    public function storeStat(Request $request)
    {
        $validated = $request->validate([
            'placement' => 'required|in:hero,bar',
            'icon' => 'nullable|string|max:50',
            'value' => 'required|string|max:50',
            'label' => 'required|string|max:100',
        ]);

        $validated['sort_order'] = (LandingStat::where('placement', $validated['placement'])->max('sort_order') ?? -1) + 1;
        $validated['active'] = true;
        LandingStat::create($validated);

        LandingContentService::forgetCache();
        ActivityLogController::log('Settings', 'Updated', 'Super Admin added a landing page '.$validated['placement'].' stat.');

        return redirect(route('admin-settings').'#website-content')->with('success', 'Stat added.');
    }

    public function updateStat(Request $request, LandingStat $landingStat)
    {
        $validated = $request->validate([
            'icon' => 'nullable|string|max:50',
            'value' => 'required|string|max:50',
            'label' => 'required|string|max:100',
        ]);
        $validated['active'] = $request->boolean('active');
        $landingStat->update($validated);

        LandingContentService::forgetCache();
        ActivityLogController::log('Settings', 'Updated', 'Super Admin updated a landing page '.$landingStat->placement.' stat.');

        return redirect(route('admin-settings').'#website-content')->with('success', 'Stat updated.');
    }

    public function storeService(Request $request)
    {
        $validated = $request->validate([
            'icon' => 'nullable|string|max:50',
            'title' => 'required|string|max:100',
            'description' => 'required|string|max:500',
            'features' => 'nullable|string|max:500',
        ]);

        $validated['sort_order'] = (LandingService::max('sort_order') ?? -1) + 1;
        $validated['active'] = true;
        LandingService::create($validated);

        LandingContentService::forgetCache();
        ActivityLogController::log('Settings', 'Updated', "Super Admin added the landing page service \"{$validated['title']}\".");

        return redirect(route('admin-settings').'#website-content')->with('success', 'Service added.');
    }

    public function updateService(Request $request, LandingService $landingService)
    {
        $validated = $request->validate([
            'icon' => 'nullable|string|max:50',
            'title' => 'required|string|max:100',
            'description' => 'required|string|max:500',
            'features' => 'nullable|string|max:500',
        ]);
        $validated['active'] = $request->boolean('active');
        $landingService->update($validated);

        LandingContentService::forgetCache();
        ActivityLogController::log('Settings', 'Updated', "Super Admin updated the landing page service \"{$landingService->title}\".");

        return redirect(route('admin-settings').'#website-content')->with('success', 'Service updated.');
    }

    public function storeTestimonial(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'role' => 'required|string|max:150',
            'quote' => 'required|string|max:500',
        ]);

        $validated['sort_order'] = (LandingTestimonial::max('sort_order') ?? -1) + 1;
        $validated['active'] = true;
        LandingTestimonial::create($validated);

        LandingContentService::forgetCache();
        ActivityLogController::log('Settings', 'Updated', "Super Admin added a testimonial from \"{$validated['name']}\".");

        return redirect(route('admin-settings').'#website-content')->with('success', 'Testimonial added.');
    }

    public function updateTestimonial(Request $request, LandingTestimonial $landingTestimonial)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'role' => 'required|string|max:150',
            'quote' => 'required|string|max:500',
        ]);
        $validated['active'] = $request->boolean('active');
        $landingTestimonial->update($validated);

        LandingContentService::forgetCache();
        ActivityLogController::log('Settings', 'Updated', "Super Admin updated the testimonial from \"{$landingTestimonial->name}\".");

        return redirect(route('admin-settings').'#website-content')->with('success', 'Testimonial updated.');
    }
}
