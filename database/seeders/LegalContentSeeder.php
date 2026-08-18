<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class LegalContentSeeder extends Seeder
{
    /**
     * Seeds today's real Terms of Service and Privacy Policy — pulled from
     * the registration page's modals, written in the plain ## heading / -
     * bullet convention (see App\Support\SimpleMarkdown) so the Super
     * Admin edits plain text, never raw HTML. Nothing changes for users
     * on cutover — SimpleMarkdown renders this back to the same markup.
     */
    public function run(): void
    {
        $terms = <<<'TEXT'
## 1. Acceptance of Terms
By creating an account and using the A We Green Enterprise platform ("Service"), you agree to be bound by these Terms of Service. If you do not agree to these terms, please do not use the Service.

## 2. Use of the Service
The Service is intended for clients and partners of A We Green Enterprise to monitor and manage their CCTV, security, and solar installation projects. You agree to use the Service only for lawful purposes and in accordance with these Terms.
- You must have the legal capacity to agree to these Terms. If you are using the Service on behalf of another person or organization, you confirm that you are authorized to do so.
- You are responsible for maintaining the confidentiality of your login credentials.
- You agree not to share your account with any third party.

## 3. Account Registration
You agree to provide accurate, current, and complete information during registration and to update such information to keep it accurate. A We Green Enterprise reserves the right to suspend or terminate accounts with inaccurate information.

## 4. Intellectual Property
All content, trademarks, logos, and data on this platform are the property of A We Green Enterprise or its licensors. You may not reproduce, distribute, or create derivative works without our express written permission.

## 5. Limitation of Liability
A We Green Enterprise shall not be liable for any indirect, incidental, or consequential damages arising from your use of the Service. Our total liability shall not exceed the amount paid by you, if any, for access to the Service.

## 6. Termination
We reserve the right to suspend or terminate your access to the Service at our sole discretion, without notice, for conduct that we believe violates these Terms or is harmful to other users, us, or third parties.

## 7. Changes to Terms
We may update these Terms from time to time. Continued use of the Service after changes are posted constitutes your acceptance of the revised Terms.

## 8. Contact Us
For questions about these Terms, contact us at support@awegreenenterprise.com.
TEXT;

        $privacy = <<<'TEXT'
A We Green Enterprise ("we", "us", or "our") is committed to protecting your personal information. This Privacy Policy explains how we collect, use, and safeguard your data when you use our platform.

## 1. Information We Collect
We collect information you provide directly to us when registering or using the Service, including:
- Full name, email address, and phone number
- Account credentials (stored securely, passwords are hashed)
- Project-related communications and support requests
- Usage data and device/browser information for analytics

## 2. How We Use Your Information
We use the information collected to:
- Create and manage your account
- Provide project tracking and monitoring features
- Send service-related notifications and updates
- Respond to support inquiries
- Improve and secure the platform

## 3. Sharing of Information
We do not sell or rent your personal information to third parties. We may share data with trusted service providers who assist in operating our platform, subject to confidentiality agreements. We may also disclose information if required by law.

## 4. Data Security
We implement industry-standard security measures including encryption, access controls, and regular audits to protect your information. However, no method of transmission over the internet is 100% secure.

## 5. Data Retention
We retain your personal data for as long as your account is active or as needed to provide services. You may request deletion of your account and associated data by contacting us.

## 6. Your Rights
Under applicable Philippine data privacy laws (Republic Act No. 10173), you have the right to access, correct, or request deletion of your personal data. To exercise these rights, contact our Data Protection Officer.

## 7. Cookies
We use cookies and similar technologies to maintain sessions and improve user experience. You may disable cookies in your browser settings, though some features may not function properly as a result.

## 8. Contact Us
For privacy-related concerns, reach us at privacy@awegreenenterprise.com.
TEXT;

        Setting::updateOrCreate(['key' => 'legal_terms_content'], ['value' => $terms, 'group' => 'legal']);
        Setting::updateOrCreate(['key' => 'legal_terms_updated_at'], ['value' => '2025-01-01', 'group' => 'legal']);
        Setting::updateOrCreate(['key' => 'legal_privacy_content'], ['value' => $privacy, 'group' => 'legal']);
        Setting::updateOrCreate(['key' => 'legal_privacy_updated_at'], ['value' => '2025-01-01', 'group' => 'legal']);
    }
}
