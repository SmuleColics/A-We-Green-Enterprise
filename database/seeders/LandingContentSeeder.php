<?php

namespace Database\Seeders;

use App\Models\LandingService;
use App\Models\LandingStat;
use App\Models\LandingTestimonial;
use App\Models\Setting;
use Illuminate\Database\Seeder;

class LandingContentSeeder extends Seeder
{
    /**
     * Seeds today's real landing-page content verbatim from
     * landing-page.blade.php. Nothing changes for visitors on cutover.
     */
    public function run(): void
    {
        $scalars = [
            'landing_hero_image_path' => 'css/images/hero-img.jpg',
            'landing_hero_badge' => 'Trusted Since 2014',
            'landing_hero_headline' => 'We Bring The Right Technology',
            'landing_hero_subtitle' => 'Your trusted partner for CCTV, Solar Energy, Solar Street Lighting, and Public Address Systems since 2014.',
            'landing_hero_cta_primary' => 'Schedule Free Assessment',
            'landing_hero_cta_secondary' => 'View Our Projects',
            'landing_services_heading' => 'Comprehensive Solutions for Your Security and Energy Needs',
            'landing_services_subtitle' => 'We specialize in four core services designed to protect your property and reduce your energy costs.',
            'landing_cta_headline' => 'Ready to Secure and Power Your Property?',
            'landing_cta_subtext' => 'Schedule your free site assessment today. Our team will check your location and recommend the best solution for your needs.',
            'landing_cta_footnote' => 'Free consultation • Transparent pricing • No hidden fees',
        ];

        foreach ($scalars as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value, 'group' => 'landing']);
        }

        $heroStats = [
            ['icon' => 'bi-shield-check', 'value' => '5,000+', 'label' => 'Cameras Installed'],
            ['icon' => 'bi-lightbulb', 'value' => '800+', 'label' => 'Solar Street Lights'],
            ['icon' => 'bi-award', 'value' => '12 Years', 'label' => 'of Excellence'],
            ['icon' => 'bi-building', 'value' => "Gov't & Private", 'label' => 'Trusted'],
        ];
        foreach ($heroStats as $order => $stat) {
            LandingStat::updateOrCreate(
                ['placement' => 'hero', 'value' => $stat['value'], 'label' => $stat['label']],
                ['icon' => $stat['icon'], 'sort_order' => $order, 'active' => true]
            );
        }

        $barStats = [
            ['icon' => 'bi-calendar-check', 'value' => 'Since 2014', 'label' => 'Years of Service'],
            ['icon' => 'bi-check-circle', 'value' => '5,800+', 'label' => 'Installations Completed'],
            ['icon' => 'bi-emoji-smile', 'value' => '500+', 'label' => 'Satisfied Customers'],
            ['icon' => 'bi-geo-alt', 'value' => 'Region IV-A & NCR', 'label' => 'Coverage Areas'],
        ];
        foreach ($barStats as $order => $stat) {
            LandingStat::updateOrCreate(
                ['placement' => 'bar', 'value' => $stat['value'], 'label' => $stat['label']],
                ['icon' => $stat['icon'], 'sort_order' => $order, 'active' => true]
            );
        }

        $services = [
            [
                'icon' => 'bi-camera-video', 'title' => 'CCTV Surveillance',
                'description' => 'HD & IP camera systems with 24/7 monitoring, remote access, and intelligent video analytics for total protection.',
                'features' => "IP & Analog HD\nMobile App Access\nCloud Recording",
            ],
            [
                'icon' => 'bi-sun', 'title' => 'Solar Energy Systems',
                'description' => 'On-grid, off-grid, and hybrid solar power solutions that cut electric bills and provide reliable clean energy.',
                'features' => "Residential & Commercial\nBattery Backup\nNet Metering",
            ],
            [
                'icon' => 'bi-lightbulb', 'title' => 'Street Lights',
                'description' => 'Strong and bright street lights for roads, subdivisions, parking areas, and barangays.',
                'features' => "Bright LED Light\nAuto On at Night\nRainproof Design",
            ],
            [
                'icon' => 'bi-megaphone', 'title' => 'Public Address Systems',
                'description' => 'Outdoor & indoor PA systems for plazas, schools, and LGUs. Wireless and weatherproof options available.',
                'features' => "Wireless Mics\nWeatherproof\nLong-Range Coverage",
            ],
        ];
        foreach ($services as $order => $service) {
            LandingService::updateOrCreate(
                ['title' => $service['title']],
                ['icon' => $service['icon'], 'description' => $service['description'], 'features' => $service['features'], 'sort_order' => $order, 'active' => true]
            );
        }

        $testimonials = [
            ['name' => 'Engr. Roberto Cruz', 'role' => 'Operations Manager, Manufacturing Plant', 'quote' => 'A We Green installed CCTV across our entire facility. Quality of work is excellent and after-sales support is top-notch.'],
            ['name' => 'Hon. Maria Santos', 'role' => 'Barangay Captain, Bulacan', 'quote' => 'Our solar street lights have been running flawlessly for 3 years. Best decision our barangay ever made.'],
            ['name' => 'Anna Reyes', 'role' => 'Homeowner, Quezon City', 'quote' => 'Professional team, fair pricing, and they actually deliver on time. Highly recommend their solar systems.'],
        ];
        foreach ($testimonials as $order => $t) {
            LandingTestimonial::updateOrCreate(
                ['name' => $t['name']],
                ['role' => $t['role'], 'quote' => $t['quote'], 'sort_order' => $order, 'active' => true]
            );
        }
    }
}
