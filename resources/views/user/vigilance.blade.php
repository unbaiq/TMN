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
            <span class="text-red-600">TMN</span> Vigilance Policy
        </h1>

        <p class="text-gray-600 mt-3 max-w-3xl leading-relaxed">
            Top Management Network (TMN) is committed to maintaining the highest
            standards of integrity, transparency, and ethical conduct across all
            its operations, members, partners, and stakeholders.
        </p>
    </div>
</section>

{{-- ================= CONTENT ================= --}}
<section class="py-16 bg-white">
    <div class="main-width grid lg:grid-cols-[65%,1fr] gap-10">

        {{-- ================= MAIN CONTENT ================= --}}
        <div class="space-y-10 text-[#232323] leading-[28px]">

            {{-- 1 --}}
            <div>
                <h2 class="text-2xl font-semibold mb-3">
                    1. Purpose of Vigilance
                </h2>
                <p>
                    The vigilance mechanism of TMN aims to prevent, detect, and address
                    unethical practices, misconduct, corruption, conflicts of interest,
                    and misuse of authority within the organization.
                </p>
            </div>

            {{-- 2 --}}
            <div>
                <h2 class="text-2xl font-semibold mb-3">
                    2. Scope
                </h2>
                <p>
                    This policy applies to all TMN members, employees, advisors,
                    vendors, partners, and associates across chapters, events,
                    advisory programs, and digital platforms.
                </p>
            </div>

            {{-- 3 --}}
            <div>
                <h2 class="text-2xl font-semibold mb-3">
                    3. Reportable Matters
                </h2>

                <ul class="list-disc pl-6 space-y-2">
                    <li>Financial irregularities or misrepresentation</li>
                    <li>Abuse of position or authority</li>
                    <li>Bribery, corruption, or unethical conduct</li>
                    <li>Conflict of interest</li>
                    <li>Harassment or discrimination</li>
                    <li>Data misuse or confidentiality breaches</li>
                </ul>
            </div>

            {{-- 4 --}}
            <div>
                <h2 class="text-2xl font-semibold mb-3">
                    4. Reporting Mechanism
                </h2>
                <p>
                    Any individual may report concerns in good faith through
                    TMN’s designated vigilance communication channels.
                    All reports will be handled confidentially and reviewed
                    by the appropriate authority.
                </p>
            </div>

            {{-- 5 --}}
            <div>
                <h2 class="text-2xl font-semibold mb-3">
                    5. Protection Against Retaliation
                </h2>
                <p>
                    TMN strictly prohibits retaliation against individuals
                    who report concerns honestly. Any form of victimization
                    will be treated as a serious violation.
                </p>
            </div>

            {{-- 6 --}}
            <div>
                <h2 class="text-2xl font-semibold mb-3">
                    6. Investigation & Action
                </h2>
                <p>
                    All reported matters will be assessed fairly and impartially.
                    Appropriate corrective or disciplinary actions will be taken
                    based on findings and applicable policies.
                </p>
            </div>

            {{-- 7 --}}
            <div>
                <h2 class="text-2xl font-semibold mb-3">
                    7. Confidentiality
                </h2>
                <p>
                    TMN ensures strict confidentiality of complainants, witnesses,
                    and investigation details, subject to legal and procedural
                    requirements.
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
                Report a Concern
            </h3>

            <p class="text-sm text-gray-600 leading-relaxed">
                If you wish to report a vigilance-related issue or ethical concern,
                please contact TMN through official communication channels.
            </p>

            <div class="mt-6">
                <a href="{{ url('/contact') }}"
                   class="inline-block bg-red-600 text-white px-5 py-2 rounded
                          font-semibold hover:bg-red-700 transition">
                    Contact TMN
                </a>
            </div>

        </aside>
    </div>
</section>

@include("user.components.footer")
