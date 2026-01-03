@php
    $assetBase = app()->environment('local')
        ? ''
        : config('app.url') . '/tmn/public';
@endphp

@include("user.components.meta")
@include("user.components.header")

{{-- ================= BANNER ================= --}}
<section class="bg-[url('{{ $advisory->banner_url ?? $assetBase . '/images/committee-banner.png' }}')]
               bg-cover bg-center bg-no-repeat">
    <div class="bg-black/60 py-14">
        <div class="main-width">

            <p class="text-white text-lg">
                Advisory Committee
            </p>

            <h1 class="text-white text-3xl md:text-4xl font-bold mt-2">
                {{ $advisory->title }}
            </h1>

            @if($advisory->tagline)
                <p class="text-white/80 mt-2 text-lg">
                    {{ $advisory->tagline }}
                </p>
            @endif

        </div>
    </div>
</section>

{{-- ================= CONTENT ================= --}}
<section class="py-14 bg-[#f2f2f2]">
    <div class="main-width grid lg:grid-cols-[32%,1fr] gap-10">

        {{-- ================= LEFT: ADVISOR PROFILE ================= --}}
        <aside class="bg-white p-6 rounded-xl shadow h-fit">

            <img src="{{ $advisory->thumbnail_url }}"
                 alt="{{ $advisory->advisor_display }}"
                 class="w-[200px] h-[200px] rounded-full mx-auto object-cover">

            <div class="text-center mt-4">
                <h2 class="text-xl font-bold">
                    {{ $advisory->advisor_name }}
                </h2>

                <p class="text-gray-600">
                    {{ $advisory->advisor_designation }}
                </p>

                @if($advisory->organization)
                    <p class="text-sm text-gray-500 mt-1">
                        {{ $advisory->organization }}
                    </p>
                @endif

                @if($advisory->advisor_experience_label)
                    <span class="inline-block mt-3 px-4 py-1 text-sm
                                 bg-red-600/10 text-red-600 rounded-full font-semibold">
                        {{ $advisory->advisor_experience_label }}
                    </span>
                @endif
            </div>

            {{-- CONTACT --}}
            <div class="mt-6 space-y-2 text-sm text-gray-700">
                @if($advisory->advisor_email)
                    <p><strong>Email:</strong> {{ $advisory->advisor_email }}</p>
                @endif

                @if($advisory->advisor_phone)
                    <p><strong>Phone:</strong> {{ $advisory->advisor_phone }}</p>
                @endif
            </div>

        </aside>

        {{-- ================= RIGHT: DETAILS ================= --}}
        <div class="bg-white p-8 rounded-xl shadow space-y-8">

            {{-- DESCRIPTION --}}
            <div>
                <h3 class="text-2xl font-bold mb-3">About the Advisory</h3>

                @if($advisory->short_description)
                    <p class="font-semibold text-primary mb-3">
                        {{ $advisory->short_description }}
                    </p>
                @endif

                <div class="text-[#232323] leading-[28px]">
                    {!! nl2br(e($advisory->description)) !!}
                </div>
            </div>

            {{-- EXPERIENCE SUMMARY --}}
            @if($advisory->advisor_experience_summary)
                <div>
                    <h4 class="text-xl font-bold mb-2">Advisor Experience</h4>
                    <p class="text-gray-700 leading-[26px]">
                        {{ $advisory->advisor_experience_summary }}
                    </p>
                </div>
            @endif

            {{-- SESSION DETAILS --}}
            <div>
                <h4 class="text-xl font-bold mb-4">Session Details</h4>

                <div class="grid md:grid-cols-2 gap-4 text-sm">

                    <p><strong>Date:</strong> {{ $advisory->formatted_date }}</p>
                    <p><strong>Time:</strong> {{ $advisory->time_range ?? '-' }}</p>

                    <p><strong>Mode:</strong> {{ ucfirst($advisory->mode) }}</p>
                    <p><strong>Status:</strong> {{ ucfirst($advisory->status) }}</p>

                    @if($advisory->venue)
                        <p><strong>Venue:</strong> {{ $advisory->venue }}</p>
                    @endif

                    @if($advisory->city)
                        <p><strong>City:</strong> {{ $advisory->city }}</p>
                    @endif

                    @if($advisory->country)
                        <p><strong>Country:</strong> {{ $advisory->country }}</p>
                    @endif
                </div>
            </div>

            {{-- ONLINE / REGISTRATION --}}
            <div>
                <h4 class="text-xl font-bold mb-3">Participation</h4>

                <div class="space-y-2 text-sm">
                    <p><strong>Registration Open:</strong>
                        {{ $advisory->is_registration_open ? 'Yes' : 'No' }}
                    </p>

                    @if($advisory->registration_link)
                        <p>
                            <strong>Register:</strong>
                            <a href="{{ $advisory->registration_link }}"
                               target="_blank"
                               class="text-primary font-semibold underline">
                                Click here
                            </a>
                        </p>
                    @endif

                    @if($advisory->meeting_link_url)
                        <p>
                            <strong>Meeting Link:</strong>
                            <a href="{{ $advisory->meeting_link_url }}"
                               target="_blank"
                               class="text-primary font-semibold underline">
                                Join Session
                            </a>
                        </p>
                    @endif
                </div>
            </div>

            {{-- DOWNLOADS --}}
            @if($advisory->brochure_url || $advisory->presentation_url)
                <div>
                    <h4 class="text-xl font-bold mb-3">Resources</h4>

                    <div class="flex gap-4">
                        @if($advisory->brochure_url)
                            <a href="{{ $advisory->brochure_url }}"
                               target="_blank"
                               class="bg-red-600 text-white px-5 py-2 rounded font-semibold">
                                Brochure
                            </a>
                        @endif

                        @if($advisory->presentation_url)
                            <a href="{{ $advisory->presentation_url }}"
                               target="_blank"
                               class="bg-gray-800 text-white px-5 py-2 rounded font-semibold">
                                Presentation
                            </a>
                        @endif
                    </div>
                </div>
            @endif

        </div>
    </div>
</section>

{{-- BACK --}}
<section class="pb-14 bg-[#f2f2f2]">
    <div class="main-width">
        <a href="{{ url()->previous() }}"
           class="inline-flex items-center gap-2
                  bg-red-600 text-white px-6 py-3 rounded font-semibold">
            ← Back to Advisory Committee
        </a>
    </div>
</section>

@include("user.components.footer")
