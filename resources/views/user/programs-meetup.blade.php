@include("user.components.meta")
@include("user.components.header")

@php
    $assetBase = app()->environment('local')
        ? ''
        : config('app.url') . '/tmn/public';
@endphp

<section class="bg-[url({{ $assetBase }}/images/program-banner.png)] bg-cover lg:bg-right bg-center bg-no-repeat">
    <div class="w-full py-10 h-full ">
        <div class="main-width h-full py-4 flex items-center lg:justify-start">
            <div class="w-full grid md:grid-cols-[58%,1fr] gap-6 items-center">
                <div h-full>
                    <p class="text-white lg:py-3 py-2 lg:text-[25px] text-[17px] font-normal lg:leading-[25px]">
                        Path to Business Growth
                    </p>
                    <div class="w-full ">
                        <span class="heading2 bg-primary text-white py-2 px-7">
                            Meetups
                        </span>
                    </div>
                    <p class="text-white lg:py-3 py-2 lg:text-[19px] text-[16px] font-normal lg:leading-[30px]">
                        Have a question or need more information? Whether you're interested in membership, learning
                        about Chapters, or exploring franchise opportunities, we're here to help. Reach out, and our
                        team will connect you with the right resources.
                    </p>
                </div>

            </div>
        </div>
    </div>
</section>
<section class="py-10">
    <div class="main-width">
        <p class="text-[#232323] font-normal leading-[30px] pt-2">
            Nothing beats face-to-face conversations when it comes to networking and building meaningful business
            relationships. That’s why TMN brings you exclusive café meetups in key business hubs, where professionals,
            entrepreneurs, and industry leaders gather to share insights, discuss trends, and explore collaboration
            opportunities—over great coffee!

        </p>
    </div>
    @foreach($meetups as $index => $meetup)
        <div class="main-width pt-10">
            <div class="bg-[#F8F8F8] p-8">

                @php
                    $titleParts = explode('–', $meetup->title, 2);
                @endphp

                <h4 class="xl:text-[40px] lg:text-[30px] font-semibold text-[20px] leading-tight">
                    <span class="text-black">{{ trim($titleParts[0]) }}</span>
                    @if(isset($titleParts[1]))
                        <span class="text-primary"> – {{ trim($titleParts[1]) }}</span>
                    @endif
                </h4>


                <div class="grid lg:grid-cols-2 mt-6 gap-10 items-center">

                    <!-- TEXT SECTION -->
                    <div class="{{ $index % 2 == 0 ? 'order-1' : 'order-2' }}">

                        <ul class="text-[#232323] space-y-3">

                            <!-- Location -->
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 mt-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10 2C6.686 2 4 4.686 4 8c0 4.418 6 10 6 10s6-5.582 6-10c0-3.314-2.686-6-6-6zm0 8a2 2 0 110-4 2 2 0 010 4z" />
                                </svg>
                                <span>
                                    <span class="font-semibold">Location:</span>
                                    {{ $meetup->venue_name }}, {{ $meetup->city }}
                                </span>
                            </li>

                            <!-- Date -->
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 mt-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M6 2a1 1 0 100 2h8a1 1 0 100-2H6zM3 6a2 2 0 012-2h10a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V6z" />
                                </svg>
                                <span>
                                    <span class="font-semibold">Date & Time:</span>
                                    {{ $meetup->formatted_date }}
                                    @if($meetup->event_timing)
                                        | {{ $meetup->event_timing }}
                                    @endif
                                </span>
                            </li>

                            <!-- Theme -->
                            @if($meetup->theme)
                                <li class="flex items-start gap-3">
                                    <svg class="w-5 h-5 mt-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927C9.469 1.725 11.531 1.725 11.951 2.927l1.286 3.743a1 1 0 00.95.69h3.939c1.26 0 1.781 1.615.764 2.351l-3.19 2.316a1 1 0 00-.364 1.118l1.286 3.743c.42 1.202-.943 2.198-1.96 1.462l-3.19-2.316a1 1 0 00-1.176 0l-3.19 2.316c-1.017.736-2.38-.26-1.96-1.462l1.286-3.743a1 1 0 00-.364-1.118L1.97 9.711c-1.017-.736-.496-2.351.764-2.351h3.939a1 1 0 00.95-.69l1.286-3.743z" />
                                    </svg>
                                    <span>
                                        <span class="font-semibold">Theme:</span>
                                        {{ $meetup->theme }}
                                    </span>
                                </li>
                            @endif

                            <!-- Short Description -->
                            @if($meetup->short_description)
                                <li class="flex items-start gap-3">
                                    <svg class="w-5 h-5 mt-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2 5a2 2 0 012-2h12a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V5z" />
                                    </svg>
                                    <span>{{ $meetup->short_description }}</span>
                                </li>
                            @endif

                            <!-- Full Description -->
                            @if($meetup->description)
                                <li class="text-gray-700 leading-relaxed">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($meetup->description), 300) }}
                                </li>
                            @endif

                        </ul>
                    </div>

                    <!-- IMAGE SECTION -->
                    <div class="flex justify-center {{ $index % 2 == 0 ? 'order-2' : 'order-1' }}">
                        <img src="{{ $meetup->banner_url }}" alt="{{ $meetup->title }}"
                            class="w-[80%] h-[220px] md:h-[240px] lg:h-[360px] object-cover object-center rounded-md">
                    </div>

                </div>

                <!-- CTA -->
                <div class="mt-8">
                    <span class="bg-primary rounded-[5px] text-white px-6 py-3 text-[18px] font-bold inline-block">
                        {{ $meetup->registration_link ? 'Reserve Your Spot Now!' : 'Coming Soon' }}
                    </span>
                </div>

            </div>
        </div>
    @endforeach

    <div class="main-width pt-10">


        <h4 class=" xl:text-[25px] lg:text-[20px] font-semibold text-[18px]">
            Limited seats available for each meetup.Secure your spot and join us for an exclusive TMN networking
            experience!
        </h4>
        <p class="flex items-start gap-2">
            <span><svg xmlns="http://www.w3.org/2000/svg" width="33" height="25" viewBox="0 0 33 25" fill="none">
                    <path
                        d="M23.9662 4.62861C23.1826 2.14014 22.157 0.906658 20.8964 0.95705C20.5052 0.975947 20.1387 1.1249 19.8074 1.4002L7.42591 7.80069L3.88256 7.97261C2.5042 8.03894 1.36631 8.81223 0.677869 10.1495C-0.335152 12.1192 -0.199169 15.0026 0.99467 16.856C1.76463 18.0524 2.90733 18.7112 4.21159 18.7112C4.27495 18.7112 4.33831 18.7094 4.40352 18.7068L4.59768 18.6972L5.58143 22.3902C5.70666 22.8597 6.10869 23.1709 6.84715 23.3695C7.01944 23.4158 7.47816 23.524 8.00912 23.524C8.72498 23.524 9.28114 23.3313 9.66204 22.9512C9.9166 22.6977 10.306 22.1331 10.057 21.1978L9.51568 19.1648L21.0094 23.7819C21.3033 23.956 21.613 24.0442 21.9306 24.0442C21.9591 24.0442 21.9884 24.0435 22.0173 24.042C23.2678 23.9812 24.176 22.6518 24.7173 20.0911C25.1616 17.9891 25.3287 15.2286 25.1879 12.3185C25.046 9.41063 24.6124 6.67947 23.9662 4.62861ZM22.4234 12.0958C22.3715 11.0324 21.9862 10.0405 21.3385 9.30206C20.8716 8.77036 20.2969 8.40391 19.6696 8.2368C19.9238 4.83202 20.6278 3.11574 20.9905 2.87231C21.5886 3.18318 23.0051 6.59647 23.2871 12.4108C23.5683 18.2132 22.4801 21.8129 21.935 22.1327C21.5 21.9356 20.5285 19.8947 19.979 16.2306C21.493 15.7029 22.5145 13.9866 22.4234 12.0958ZM31.3023 16.8994C31.3642 17.092 31.3471 17.2973 31.2545 17.477C31.1241 17.7304 30.8658 17.8876 30.5805 17.8876C30.4616 17.8876 30.3419 17.8587 30.2348 17.8038L27.6326 16.4651C27.4529 16.3725 27.3195 16.2154 27.258 16.0227C27.1961 15.83 27.2132 15.6251 27.3058 15.445C27.4966 15.0741 27.9539 14.9278 28.3255 15.1182L30.9273 16.4569C31.107 16.5499 31.2404 16.7071 31.3023 16.8994ZM27.6404 9.55291C27.3814 9.55291 27.1431 9.42286 27.0031 9.20536C26.8934 9.03529 26.8567 8.83298 26.8997 8.63512C26.9427 8.43762 27.0598 8.26829 27.2299 8.15862L29.6902 6.57461C30.041 6.34859 30.5105 6.45049 30.7369 6.80138C30.9629 7.15227 30.861 7.62209 30.5101 7.84849L28.0498 9.43249C27.9264 9.51104 27.7849 9.55291 27.6404 9.55291ZM32.4258 12.0699C32.4458 12.4871 32.1227 12.8428 31.7058 12.8632L28.746 13.0059C28.3414 13.0059 28.0094 12.6894 27.9902 12.2852C27.9805 12.0832 28.0498 11.8895 28.1858 11.7398C28.3218 11.5901 28.5078 11.5019 28.7101 11.4923L31.6325 11.3507C32.0526 11.3348 32.4057 11.6571 32.4258 12.0699Z"
                        fill="black" />
                </svg></span>
            <span class="text-primary font-medium">Sign Up Now</span>
            <span> and be a part of the TMN Café Meetups!</span>
        </p>
    </div>
</section>
@include('user.components.footer')