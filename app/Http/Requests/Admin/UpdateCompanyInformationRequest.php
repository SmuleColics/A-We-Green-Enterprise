<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyInformationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isSuperAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'company_name' => 'required|string|max:150',
            'company_tagline' => 'nullable|string|max:150',
            'company_description' => 'nullable|string|max:500',
            'company_founded_year' => 'nullable|digits:4|integer|min:1900|max:'.date('Y'),
            'logo' => 'nullable|file|mimes:jpg,jpeg,png,svg,webp|max:3072',
            'company_address_main' => 'required|string|max:500',
            'company_address_satellite' => 'nullable|string|max:500',
            'company_phone_primary' => 'required|string|max:30',
            'company_phone_secondary' => 'nullable|string|max:30',
            'company_phone_landline' => 'nullable|string|max:30',
            'company_email_primary' => 'required|email|max:150',
            'company_email_secondary' => 'nullable|email|max:150',
            'company_hours_days' => 'nullable|string|max:50',
            'company_hours_open' => 'nullable|date_format:H:i',
            'company_hours_close' => 'nullable|date_format:H:i',
        ];
    }
}
