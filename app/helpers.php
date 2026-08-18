<?php

use App\Services\SettingsService;
use App\Support\SimpleMarkdown;

if (! function_exists('setting')) {
    /**
     * Read a Super Admin-configured value. Every Blade file that needs a
     * setting (company name, contact info, etc.) should call this instead
     * of hardcoding the value, so there is exactly one source of truth.
     */
    function setting(string $key, $default = null)
    {
        return SettingsService::get($key, $default);
    }
}

if (! function_exists('simple_markdown_to_html')) {
    /**
     * Renders the ## heading / - bullet / blank-line-paragraph convention
     * used by Legal & Policies content into HTML.
     */
    function simple_markdown_to_html(string $text): string
    {
        return SimpleMarkdown::toHtml($text);
    }
}
