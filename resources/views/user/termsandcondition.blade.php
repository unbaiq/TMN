@include("user.components.meta")
@include("user.components.header")

@php
  $assetBase = app()->environment('local')
    ? ''
    : config('app.url') . '/tmn/public';
@endphp
{{-- ================= HERO / HEADER ================= --}}
<section class="bg-gray-100 border-b border-gray-200">
    <div class="main-width py-10">
        <h1 class="text-3xl md:text-4xl font-bold text-[#232323]">
            <span class="text-red-600">TMN</span> Terms & Conditions
        </h1>

        <p class="text-gray-600 mt-3 max-w-3xl leading-relaxed">
            Please read these Terms and Conditions carefully before using the
            Top Management Network (TMN) website, services, events, and platforms.
        </p>
    </div>
</section>

{{-- ================= CONTENT ================= --}}
<section class="py-14 bg-white">
    <div class="main-width grid lg:grid-cols-[65%,1fr] gap-10">

        {{-- ================= MAIN CONTENT ================= --}}
        <div class="space-y-10 text-[#232323] leading-[28px]">

            {{-- 1 --}}
            <div>
                <h2 class="text-2xl font-semibold mb-3">
                    1. Acceptance of Terms
                </h2>
                <p>
                    By accessing or using TMN’s website, platforms, events, or services,
                    you agree to be bound by these Terms & Conditions, our Privacy Policy,
                    and all applicable laws and regulations.
                </p>
            </div>

            {{-- 2 --}}
            <div>
                <h2 class="text-2xl font-semibold mb-3">
                    2. About TMN
                </h2>
                <p>
                    Top Management Network (TMN) is a professional business networking
                    platform designed to connect CXOs, founders, professionals, and
                    entrepreneurs for collaboration, learning, and growth through
                    meetings, advisory sessions, events, and digital content.
                </p>
            </div>

            {{-- 3 --}}
            <div>
                <h2 class="text-2xl font-semibold mb-3">
                    3. Membership & Participation
                </h2>
                <ul class="list-disc pl-6 space-y-2">
                    <li>Membership is subject to approval by TMN.</li>
                    <li>Members must provide accurate and up-to-date information.</li>
                    <li>TMN reserves the right to suspend or terminate memberships
                        for violations of policies or unethical conduct.</li>
                </ul>
            </div>

            {{-- 4 --}}
            <div>
                <h2 class="text-2xl font-semibold mb-3">
                    4. Events, Meetings & Advisory Sessions
                </h2>
                <p>
                    TMN organizes physical and virtual events, meetings, and advisory
                    sessions. Schedules, speakers, venues, and formats may change
                    without prior notice. TMN is not responsible for individual
                    business outcomes arising from participation.
                </p>
            </div>

            {{-- 5 --}}
            <div>
                <h2 class="text-2xl font-semibold mb-3">
                    5. Intellectual Property
                </h2>
                <p>
                    All content including logos, text, graphics, videos, articles,
                    and designs on TMN platforms are the intellectual property of TMN
                    or its partners. Unauthorized reproduction or redistribution
                    is strictly prohibited.
                </p>
            </div>

            {{-- 6 --}}
            <div>
                <h2 class="text-2xl font-semibold mb-3">
                    6. User Conduct
                </h2>
                <ul class="list-disc pl-6 space-y-2">
                    <li>No abusive, misleading, or unlawful behavior.</li>
                    <li>No spamming, solicitation, or misuse of member data.</li>
                    <li>Respect confidentiality and professional ethics.</li>
                </ul>
            </div>

            {{-- 7 --}}
            <div>
                <h2 class="text-2xl font-semibold mb-3">
                    7. Limitation of Liability
                </h2>
                <p>
                    TMN shall not be liable for any direct, indirect, incidental,
                    or consequential damages arising from the use of its services,
                    events, or content.
                </p>
            </div>

            {{-- 8 --}}
            <div>
                <h2 class="text-2xl font-semibold mb-3">
                    8. Privacy
                </h2>
                <p>
                    Your use of TMN is also governed by our Privacy Policy.
                    We are committed to protecting your data and maintaining
                    confidentiality.
                </p>
            </div>

            {{-- 9 --}}
            <div>
                <h2 class="text-2xl font-semibold mb-3">
                    9. Modifications
                </h2>
                <p>
                    TMN reserves the right to modify these Terms & Conditions
                    at any time. Continued use of the platform constitutes
                    acceptance of updated terms.
                </p>
            </div>

            {{-- 10 --}}
            <div>
                <h2 class="text-2xl font-semibold mb-3">
                    10. Governing Law
                </h2>
                <p>
                    These Terms shall be governed by and interpreted in accordance
                    with the laws of India. Any disputes shall be subject to the
                    jurisdiction of Indian courts.
                </p>
            </div>

            {{-- LAST UPDATED --}}
            <div class="pt-6 text-sm text-gray-500">
                Last Updated: {{ now()->format('F d, Y') }}
            </div>
        </div>

        {{-- ================= SIDEBAR ================= --}}
        <aside class="bg-gray-50 border border-gray-200 rounded-xl p-6 h-fit">

            <h3 class="text-xl font-semibold mb-4">
                Need Help?
            </h3>

            <p class="text-sm text-gray-600 leading-relaxed">
                If you have any questions about these Terms & Conditions,
                please contact the TMN support team.
            </p>

            <div class="mt-6">
                <a href="/contact"
                   class="inline-block bg-red-600 text-white px-5 py-2 rounded font-semibold hover:bg-red-700 transition">
                    Contact TMN
                </a>
            </div>

        </aside>
    </div>
</section>

@include("user.components.footer")
