@php use Illuminate\Support\Str; @endphp

@include('user.components.meta')
@include('user.components.header')

    @php
        $assetBase = app()->environment('local')
            ? ''
            : config('app.url') . '/tmn/public';
    @endphp

{{-- ================= BANNER ================= --}}
<section
    class="bg-cover bg-center bg-no-repeat"
    style="background-image:url('{{ asset('{{ asset('images/insight-banner.png') }}
')">

    <div class="w-full py-10 banner-grid">
        <div class="main-width py-4 flex items-center">
            <div class="grid md:grid-cols-[58%,1fr] gap-6 items-center">
                <div>

                    <p class="text-white py-2 text-[17px] lg:text-[25px]">
                        {{ $banner->subtitle ?? 'Path to Business Growth.' }}
                    </p>

                    <span class="heading2 bg-primary text-white py-2 px-7 inline-block">
                        {{ $banner->title ?? 'Build Your Brand' }}
                    </span>

                    <p class="text-white py-2 text-[16px] lg:text-[19px] leading-[30px]">
                        {!! $banner->content ?? '' !!}
                    </p>

                </div>
            </div>
        </div>
    </div>
</section>

{{-- ================= CONTENT ================= --}}
<section class="py-10">
    <div class="main-width grid grid-cols-1 lg:grid-cols-2 items-center gap-10">

        {{-- LEFT CONTENT --}}
        <div>
            <h2 class="text-[24px] lg:text-[30px] font-semibold text-[#232323]">
                {{ $intro->title ?? '' }}
            </h2>

            <p class="py-2 text-[16px] lg:text-[19px] leading-[30px]">
                {!! $intro->content ?? '' !!}
            </p>

            <hr class="mt-4 border border-[#CF2031]">

            @if($cta)
                <div class="mt-6">
                    <a href="{{ $cta->cta_url }}"
                       class="inline-block font-medium text-[16px] lg:text-[20px]
                              border text-white bg-primary rounded
                              transition-all duration-700 hover:bg-white hover:border-[#CF2031]
                              hover:text-[#CF2031]
                              px-6 py-3">
                        {{ $cta->cta_text ?? 'FREE CONSULTATION' }}
                    </a>
                </div>
            @endif
        </div>

        {{-- ================= TESTIMONIAL SLIDER ================= --}}
        <div class="testimonial-container overflow-y-hidden w-full sm:w-[90%] lg:w-[70%] h-[380px] lg:h-[440px] mx-auto">
            <div class="testimonial-slider" id="slider">

                @forelse($testimonials as $testimonial)
                    <div class="testimonial grid grid-cols-[70px,1fr] gap-3 items-center">

                        <div class="flex justify-center">
                            <div class="w-[60px] h-[60px] sm:w-[80px] sm:h-[80px] rounded-full overflow-hidden">
                                <img
                                    src="{{ asset('images/default-user.png') }}"
                                    class="h-full w-full object-cover"
                                    alt="{{ $testimonial->title }}">
                            </div>
                        </div>

                        <div>
                            <p class="text-left text-[14px] sm:text-[16px]">
                                {{ Str::limit(strip_tags($testimonial->content), 120) }}
                            </p>

                            <p class="text-left mt-1 text-sm font-medium">
                                {{ $testimonial->title }}
                            </p>
                        </div>

                    </div>
                @empty
                    <div class="testimonial">
                        <p>No testimonials available.</p>
                    </div>
                @endforelse

            </div>
        </div>

    </div>
</section>

@include('user.components.footer')
