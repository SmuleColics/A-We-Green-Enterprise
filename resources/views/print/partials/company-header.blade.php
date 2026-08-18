<header class="header">
    <div class="brand">{{ strtoupper(setting('company_name', 'A We Green Enterprise')) }}</div>
    <div class="contact">
        {{ str_replace("\n", ' ', setting('company_address_main', '')) }}<br>
        Smart: {{ setting('company_phone_primary', '') }}
        @if (setting('company_phone_secondary')) | Globe: {{ setting('company_phone_secondary') }} @endif
        @if (setting('company_phone_landline')) | Landline: {{ setting('company_phone_landline') }} @endif
        <br>Email: {{ setting('company_email_primary', '') }}
    </div>
    <img class="logo" src="{{ asset(setting('company_logo_path', 'css/images/AWeGreen-Logo.svg')) }}"
        alt="{{ setting('company_name', 'A We Green Enterprise') }}">
</header>
