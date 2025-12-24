{{-- =========================
   GLOBAL ASSET BASE
========================= --}}
@php
    $assetBase = app()->environment('local')
        ? ''
        : config('app.url') . '/tmn/public';
@endphp

{{-- =========================
   META + HEADER
========================= --}}
@include('user.components.meta')
@include('user.components.header')

{{-- =========================
   HERO SECTION
========================= --}}

   <section class="bg-[url({{ $assetBase }}/images/program-banner.png)] bg-cover bg-center bg-no-repeat">
    <div class="w-full py-10 h-full banner-grid">
        <div class="main-width h-full py-4 flex items-center lg:justify-start">
            <div class="grid md:grid-cols-[58%,1fr] gap-6 items-center">
                <div h-full>
                    <p class="text-white lg:py-3 py-2 lg:text-[25px] text-[17px] font-normal lg:leading-[25px]">
                        Path to Business Growth.
                    </p>
                    <div class="w-full">
                        <span class="heading2 bg-primary text-white py-2 px-7">
                            Meetups
                        </span>
                    </div>
                    <p class="text-white lg:py-3 py-2 lg:text-[19px] text-[16px] font-normal lg:leading-[30px]">
                        Have a question or need more information? Whether you're interested in membership, learning about Chapters, or exploring franchise opportunities, we're here to help. Reach out, and our team will connect you with the right resources.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- =========================
   MEETUP DETAILS + FORM
========================= --}}
<section class="py-14 bg-white">
    <div class="main-width grid lg:grid-cols-2 gap-14 items-start">

        {{-- ================= LEFT : MEETUP INFO ================= --}}
        <div>

    {{-- DATE BADGE --}}
    <span class="inline-block bg-red-600/10 text-red-600 px-4 py-2 rounded text-sm font-medium">
        {{ $meetup->event_date?->format('l, d F') }}
    </span>

    {{-- TITLE --}}
    <h1 class="text-4xl font-bold text-[#232323] mt-6 leading-snug">
        {{ $meetup->title }}
        @if($meetup->tagline)
            – <span class="text-red-600">{{ $meetup->tagline }}</span>
        @endif
    </h1>

    {{-- META --}}
    <div class="mt-8 space-y-5 text-[#232323]">

        {{-- LOCATION --}}
        <div class="flex items-start gap-3">
            <i class="fa-solid fa-location-dot mt-1"></i>
            <div>
                <p class="font-semibold">Location:</p>
                <p>
                    {{ $meetup->venue_name }},
                    {{ $meetup->city }},
                    {{ $meetup->state }}
                </p>
            </div>
        </div>

        {{-- DATE & TIME --}}
        <div class="flex items-start gap-3">
            <i class="fa-solid fa-calendar-days mt-1"></i>
            <div>
                <p class="font-semibold">Date & Time:</p>
                <p>
                    {{ $meetup->formatted_date }}
                    @if($meetup->event_timing)
                        , {{ $meetup->event_timing }}
                    @endif
                </p>
            </div>
        </div>

        {{-- THEME --}}
        @if($meetup->theme)
        <div class="flex items-start gap-3">
            <i class="fa-solid fa-diamond mt-1"></i>
            <div>
                <p class="font-semibold">Theme:</p>
                <p>{{ $meetup->theme }}</p>
            </div>
        </div>
        @endif

        {{-- WHO SHOULD ATTEND --}}
        @if($meetup->short_description)
        <div class="flex items-start gap-3">
            <i class="fa-solid fa-users mt-1"></i>
            <div>
                <p class="font-semibold">Who Should Attend:</p>
                <p>{{ $meetup->short_description }}</p>
            </div>
        </div>
        @endif

        {{-- WHAT TO EXPECT --}}
        @if($meetup->description)
        <div class="flex items-start gap-3">
            <i class="fa-solid fa-check-square mt-1"></i>
            <div>
                <p class="font-semibold">What to Expect:</p>
                <div class="mt-1 prose max-w-none">
                    {!! nl2br(e($meetup->description)) !!}
                </div>
            </div>
        </div>
        @endif

    </div>
</div>


        {{-- ================= RIGHT : RESERVATION FORM ================= --}}
        <div class="bg-gray-100 rounded-2xl p-8 shadow-sm">

            <form method="POST" action="#">
                @csrf

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold mb-2">FIRST NAME</label>
                        <input type="text" placeholder="Jane"
                               class="w-full px-4 py-3 rounded bg-gray-200 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2">LAST NAME</label>
                        <input type="text" placeholder="Doe"
                               class="w-full px-4 py-3 rounded bg-gray-200 focus:outline-none">
                    </div>
                </div>

                <div class="mt-6">
                    <label class="block text-sm font-semibold mb-2">EMAIL</label>
                    <input type="email" placeholder="Enter Your Email"
                           class="w-full px-4 py-3 rounded bg-gray-200 focus:outline-none">
                    <p class="text-xs text-gray-500 mt-1">
                        We'll use this to send you meetup updates
                    </p>
                </div>

                <div class="mt-6">
                    <label class="block text-sm font-semibold mb-2">PHONE</label>
                    <input type="text" placeholder="Enter Your Phone Number"
                           class="w-full px-4 py-3 rounded bg-gray-200 focus:outline-none">
                    <p class="text-xs text-gray-500 mt-1">
                        For meetup-related communications
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-6 mt-6">
                    <div>
                        <label class="block text-sm font-semibold mb-2">CITY</label>
                        <input type="text" placeholder="Your City"
                               class="w-full px-4 py-3 rounded bg-gray-200 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2">ZIP</label>
                        <input type="text" placeholder="201301"
                               class="w-full px-4 py-3 rounded bg-gray-200 focus:outline-none">
                    </div>
                </div>

                <button type="submit"
                        class="w-full bg-red-600 text-white py-3 mt-8 rounded-lg
                               text-lg font-semibold hover:bg-red-700 transition">
                    Reserve Your Spot
                </button>
            </form>

        </div>

    </div>
</section>
{{-- ================= PREVIOUS MEETUPS ================= --}}
@if(isset($previousMeetups) && $previousMeetups->count())
<section class="py-14 bg-[#f8f8f8]">
  <div class="main-width">

    <h2 class="text-[#232323] font-semibold text-[30px] mb-6">
      Previous Meetups
    </h2>

    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-10">

      @foreach($previousMeetups as $meetup)
        <div
          class="h-[380px] border overflow-hidden rounded-xl shadow-xl
                 relative cursor-pointer group bg-white">

          {{-- IMAGE --}}
          <img
            class="w-full h-full object-cover transition-all duration-700
                   group-hover:scale-110"
            src="{{ $meetup->thumbnail_url }}"
            alt="{{ $meetup->title }}">

          {{-- CONTENT --}}
          <div
            class="absolute bottom-0 bg-white w-full h-[120px]
                   group-hover:h-[300px] transition-all duration-700 p-6">

            <h3 class="font-semibold text-[18px] leading-tight text-[#232323]">
              {{ $meetup->title }}
            </h3>

            <p class="text-sm text-gray-600 mt-2">
              {{ \Illuminate\Support\Str::limit($meetup->short_description, 90) }}
            </p>

            <p class="text-xs text-gray-500 mt-2">
              {{ optional($meetup->event_date)->format('d M Y') }}
            </p>

            <div class="mt-4">
              <a href="{{ route('meetups.show', $meetup->slug) }}">
                <span class="bg-red-600 text-white px-4 py-2 text-[13px] rounded">
                  View Meetup
                </span>
              </a>
            </div>

          </div>
        </div>
      @endforeach

    </div>
  </div>
</section>
@endif

<div class="mt-10 mb-10 ml-10">
    <a href="/programs-meetup"
       class="inline-flex items-center gap-2
              bg-red-600 text-white
              px-6 py-3 rounded-lg font-semibold
              hover:bg-red-700
              transition-all duration-200">

        <i class="fa-solid fa-arrow-left"></i>
        Back to Meetups
    </a>
</div>

{{-- =========================
   FOOTER
========================= --}}
@include('user.components.footer')
