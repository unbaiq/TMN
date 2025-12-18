@php
    use Illuminate\Support\Str;

    $assetBase = app()->environment('local')
        ? ''
        : config('app.url') . '/tmn/public';
@endphp

@include("user.components.meta")
@include("user.components.header")

{{-- ================= BANNER ================= --}}
<section
    style="background-image: url('{{ $assetBase }}/images/committee-banner.png')"
    class="bg-cover lg:bg-right bg-center bg-no-repeat"
>
    <div class="w-full py-10 h-full banner-grid">
        <div class="main-width h-full py-4 flex items-center lg:justify-start">
            <div class="w-full grid md:grid-cols-[58%,1fr] gap-6 items-center">
                <div>
                    <p class="text-white lg:py-3 py-2 lg:text-[25px] text-[17px] font-normal lg:leading-[25px]">
                        Path of Business Networking and Growth
                    </p>

                    <div class="w-full">
                        <span class="heading2 bg-primary text-white py-2 px-7 inline-block">
                            Our Sponsors
                        </span>
                    </div>

                    <p class="text-white lg:py-3 py-2 lg:text-[19px] text-[16px] font-normal lg:leading-[30px]">
                        Empowering Brands with Premium Visibility & Engagement (Sponsorship)
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ================= CONTENT ================= --}}
<section class="bg-[#f2f2f2] py-10">
    <div class="base-template main-width py-10 md:py-4">

        <div class="grid grid-cols-1">
            <div class="text-[#232323]">
                <p class="lg:text-[19px] text-[16px] font-normal lg:leading-[30px]">
                    At Top Management Network (TMN), we offer exclusive sponsorship opportunities
                    for brands that want to engage with industry leaders, business executives,
                    and top professionals. As a TMN sponsor, you gain access to a highly targeted
                    and influential audience, allowing your brand to establish credibility,
                    enhance visibility, and generate valuable business connections.
                </p>
            </div>

            {{-- ================= SPONSORS GRID ================= --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6 items-center mt-10">

                @forelse($sponsors as $sponsor)
                    <div
                        class="rounded cursor-pointer hover:shadow h-[100px]
                               flex items-center justify-center
                               transition-all duration-300 ease-in
                               hover:bg-white transform hover:scale-105">

                        @if($sponsor->website)
                            <a href="{{ $sponsor->website }}" target="_blank" rel="noopener">
                        @endif

                        <img
                            src="{{ $sponsor->logo_url
                                ? $sponsor->logo_url
                                : $assetBase.'/images/default-sponsor.png' }}"
                            class="object-contain w-[60%] mx-auto"
                            alt="{{ $sponsor->company_name ?? $sponsor->name }}">

                        @if($sponsor->website)
                            </a>
                        @endif
                    </div>
                @empty
                    <p class="col-span-full text-center text-gray-500">
                        No sponsors available at the moment.
                    </p>
                @endforelse

            </div>
        </div>

    </div>
</section>

@include("user.components.footer")
