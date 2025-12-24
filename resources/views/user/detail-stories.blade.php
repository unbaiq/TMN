{{-- =========================
   GLOBAL ASSET BASE (REQUIRED)
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
<section
    class="bg-[url({{ $assetBase }}/images/banner.png)] bg-cover py-10 lg:bg-right bg-center bg-no-repeat"
>
    <div class="main-width h-full py-4 flex items-center lg:justify-center">
        <div class="grid md:grid-cols-[68%,1fr] gap-6 items-center">
            <div>
                <p class="text-white lg:py-3 py-2 lg:text-[25px] text-[17px] font-normal lg:leading-[25px]">
                    Path to Business Growth.
                </p>

                <div class="w-full py-4">
                    <span class="heading2 px-6 py-3 bg-[rgba(207,32,49,0.80)] text-white leading-[60px]">
                        TMNians Story
                    </span>
                </div>

                <p class="text-white lg:py-3 py-2 lg:text-[19px] text-[17px] font-normal lg:leading-[30px]">
                    Have a question or need more information? Whether you're interested in membership,
                    learning about Chapters, or exploring franchise opportunities, we're here to help.
                </p>
            </div>
        </div>
    </div>
</section>
@php
    $shareUrl = url()->current();
@endphp

<section class="py-12">
    <div class="main-width grid lg:grid-cols-[70%,30%] gap-10">

        {{-- =========================
           LEFT : STORY CONTENT
        ========================= --}}
        <div>

            {{-- STORY HEADER CARD --}}
            <div class="bg-white shadow-sm rounded-lg p-6 mb-6 flex items-center gap-6">

                {{-- LOGO / IMAGE --}}
                <img src="{{ $story->image_url }}"
                     class="w-[120px] object-contain"
                     alt="{{ $story->title }}">

                <div class="border-l-4 border-gray-300 h-[80px] hidden md:block"></div>

                {{-- TITLE + AUTHOR --}}
                <div>
                    <h1 class="text-3xl font-bold text-[#232323]">
                        {{ $story->title }}
                    </h1>

                    <p class="text-red-600 font-semibold mt-1">
                        {{ $story->author_name }}
                    </p>

                    <p class="text-gray-500 text-sm mt-1">
                        {{ optional($story->publish_date)->format('F jS, Y') }}
                    </p>
                </div>
            </div>

            {{-- STORY DESCRIPTION --}}
            <div class="text-[#232323] leading-7 mb-6">
                {!! nl2br(e($story->description)) !!}
            </div>

            {{-- SHARE THIS STORY --}}
            <div class="mt-8">
                <h3 class="text-red-600 font-semibold mb-3 text-lg">
                    Share This Story
                </h3>

                <div class="flex items-center gap-4">

                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($shareUrl) }}"
                       target="_blank"
                       class="w-[44px] h-[44px] rounded-full border border-red-600 flex items-center justify-center text-red-600 hover:bg-red-600 hover:text-white transition">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>

                    <a href="https://www.instagram.com/"
                       target="_blank"
                       class="w-[44px] h-[44px] rounded-full border border-red-600 flex items-center justify-center text-red-600 hover:bg-red-600 hover:text-white transition">
                        <i class="fa-brands fa-instagram"></i>
                    </a>

                    <a href="https://twitter.com/intent/tweet?url={{ urlencode($shareUrl) }}"
                       target="_blank"
                       class="w-[44px] h-[44px] rounded-full border border-red-600 flex items-center justify-center text-red-600 hover:bg-red-600 hover:text-white transition">
                        <i class="fa-brands fa-x-twitter"></i>
                    </a>

                    <a href="mailto:?subject={{ urlencode($story->title) }}&body={{ urlencode($shareUrl) }}"
                       class="w-[44px] h-[44px] rounded-full border border-red-600 flex items-center justify-center text-red-600 hover:bg-red-600 hover:text-white transition">
                        <i class="fa fa-envelope"></i>
                    </a>

                </div>
            </div>

            {{-- BACK BUTTON --}}
            <div class="mt-10">
                <a href="{{ route('stories.index') }}"
                   class="inline-flex items-center gap-2 bg-red-600 text-white px-6 py-3 rounded font-semibold hover:bg-red-700 transition">
                    <i class="fa-solid fa-arrow-left"></i>
                    Back to Stories
                </a>
            </div>

        </div>

        {{-- =========================
           RIGHT : SIDEBAR
        ========================= --}}
        <aside class="space-y-6">

            {{-- ABOUT TMN --}}
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="text-xl font-semibold text-[#232323] border-b-2 border-red-600 inline-block pb-2 mb-4">
                    About TMN
                </h3>

                <p class="text-gray-700 leading-6">
                    TMN (The Merchants Network) is dedicated to fostering business growth and
                    creating success stories. Join our community of entrepreneurs and business
                    leaders transforming industries and creating lasting impact.
                </p>
            </div>

            {{-- RELATED STORIES --}}
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="text-xl font-semibold text-[#232323] border-b-2 border-red-600 inline-block pb-2 mb-4">
                    Related Stories
                </h3>

               @if(isset($relatedStories) && $relatedStories->count())
    @foreach($relatedStories as $item)
        <a href="{{ route('stories.show', $item->slug) }}"
           class="flex items-center gap-4 mb-4 pb-4 border-b last:border-b-0 last:pb-0">

            <img src="{{ $item->image_url }}"
                 class="w-[60px] h-[60px] object-contain"
                 alt="{{ $item->title }}">

            <div>
                <p class="font-semibold text-sm text-[#232323]">
                    {{ $item->title }}
                </p>
                <p class="text-xs text-gray-500 mt-1">
                    {{ optional($item->publish_date)->format('M d, Y') }}
                </p>
            </div>
        </a>
    @endforeach
@else
    <p class="text-sm text-gray-500">
        No related stories found.
    </p>
@endif

            </div>

        </aside>

    </div>
</section>



{{-- =========================
   FOOTER
========================= --}}
@include('user.components.footer')
