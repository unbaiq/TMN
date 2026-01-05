
@include("user.components.meta")
@include("user.components.header")

@php
  $assetBase = app()->environment('local')
    ? ''
    : config('app.url') . '/tmn/public';
@endphp
{{-- ================= HERO ================= --}}
<section class="bg-gray-100 border-b border-gray-200">
    <div class="main-width py-10">
        <h1 class="text-3xl md:text-4xl font-bold text-[#232323]">
            <span class="text-red-600">TMN</span> Disclaimer
        </h1>

        <p class="text-gray-600 mt-3 max-w-3xl leading-relaxed">
            This disclaimer governs the use of the Top Management Network (TMN)
            website, services, content, events, and platforms.
        </p>
    </div>
</section>

{{-- ================= CONTENT ================= --}}
<section class="py-14 bg-white">
    <div class="main-width grid lg:grid-cols-[65%,1fr] gap-10">

        {{-- MAIN CONTENT --}}
        <div class="space-y-8 text-[#232323] leading-[28px]">

            <div>
                <h2 class="text-2xl font-semibold mb-2">1. General Information</h2>
                <p>
                    The information provided on TMN’s website and platforms is for
                    general informational purposes only. While we strive to keep
                    content accurate and up to date, TMN makes no warranties of any
                    kind regarding completeness, reliability, or accuracy.
                </p>
            </div>

            <div>
                <h2 class="text-2xl font-semibold mb-2">2. Professional Disclaimer</h2>
                <p>
                    TMN does not provide legal, financial, investment, or business
                    advice. Any insights, opinions, or discussions shared during
                    meetings, events, advisory sessions, or articles are for
                    informational purposes only and should not be relied upon
                    as professional advice.
                </p>
            </div>

            <div>
                <h2 class="text-2xl font-semibold mb-2">3. Events & Networking</h2>
                <p>
                    Participation in TMN events, meetings, and networking activities
                    is voluntary. TMN is not responsible for individual business
                    outcomes, partnerships, financial decisions, or disputes that
                    may arise between members or participants.
                </p>
            </div>

            <div>
                <h2 class="text-2xl font-semibold mb-2">4. External Links</h2>
                <p>
                    TMN’s website may contain links to external websites that are
                    not maintained or controlled by TMN. We do not guarantee the
                    accuracy, relevance, or reliability of information on
                    third-party websites.
                </p>
            </div>

            <div>
                <h2 class="text-2xl font-semibold mb-2">5. Limitation of Liability</h2>
                <p>
                    TMN shall not be liable for any loss or damage including,
                    without limitation, indirect or consequential loss arising
                    from the use of the website, services, or participation in
                    TMN activities.
                </p>
            </div>

            <div>
                <h2 class="text-2xl font-semibold mb-2">6. Accuracy of Content</h2>
                <p>
                    Content such as articles, speaker profiles, schedules, and
                    event details may change without notice. TMN does not guarantee
                    that all information will always be current or error-free.
                </p>
            </div>

            <div>
                <h2 class="text-2xl font-semibold mb-2">7. Consent</h2>
                <p>
                    By using TMN’s website and services, you hereby consent to this
                    disclaimer and agree to its terms.
                </p>
            </div>

            <div>
                <h2 class="text-2xl font-semibold mb-2">8. Updates</h2>
                <p>
                    TMN reserves the right to update, amend, or change this
                    disclaimer at any time without prior notice.
                </p>
            </div>

            <div class="pt-4 text-sm text-gray-500">
                Last Updated: {{ now()->format('F d, Y') }}
            </div>
        </div>

        {{-- SIDEBAR --}}
        <aside class="bg-gray-50 border border-gray-200 rounded-xl p-6 h-fit">
            <h3 class="text-xl font-semibold mb-3">
                Questions?
            </h3>

            <p class="text-sm text-gray-600 leading-relaxed">
                If you have any questions regarding this disclaimer,
                please contact the TMN support team.
            </p>

            <div class="mt-6">
                <a href="{{ url('/contact') }}"
                   class="inline-block bg-red-600 text-white
                          px-5 py-2 rounded font-semibold
                          hover:bg-red-700 transition">
                    Contact TMN
                </a>
            </div>
        </aside>

    </div>
</section>

@include("user.components.footer")
