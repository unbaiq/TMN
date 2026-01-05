@include("user.components.meta")
@include("user.components.header")

@php
  $assetBase = app()->environment('local')
    ? ''
    : config('app.url') . '/tmn/public';
@endphp

{{-- ================= HERO SECTION ================= --}}
<section class="bg-gray-100 border-b border-gray-200">
    <div class="main-width py-14">

        <h1 class="text-3xl md:text-4xl font-bold text-[#232323]">
            TMN <span class="text-red-600">Certificates</span>
        </h1>

        <p class="mt-4 max-w-3xl text-gray-600 leading-relaxed">
            TMN certificates recognize participation, contribution, and excellence
            across meetings, events, advisory sessions, and leadership programs.
        </p>
    </div>
</section>

{{-- ================= CERTIFICATE TYPES ================= --}}
<section class="py-16 bg-white">
    <div class="main-width">

        <h2 class="text-2xl font-semibold text-[#232323] mb-10">
            Certificate Categories
        </h2>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">

            {{-- CARD --}}
            <div class="border rounded-2xl p-6 hover:shadow-lg transition">
                <div class="text-red-600 text-3xl mb-4">
                    <i class="fa-solid fa-award"></i>
                </div>

                <h3 class="text-xl font-semibold text-[#232323]">
                    Participation Certificate
                </h3>

                <p class="mt-3 text-gray-600 leading-relaxed">
                    Awarded to members and guests for attending TMN meetings,
                    workshops, and networking events.
                </p>
            </div>

            {{-- CARD --}}
            <div class="border rounded-2xl p-6 hover:shadow-lg transition">
                <div class="text-red-600 text-3xl mb-4">
                    <i class="fa-solid fa-medal"></i>
                </div>

                <h3 class="text-xl font-semibold text-[#232323]">
                    Excellence Certificate
                </h3>

                <p class="mt-3 text-gray-600 leading-relaxed">
                    Recognizes outstanding contribution, leadership,
                    and consistent performance within TMN chapters.
                </p>
            </div>

            {{-- CARD --}}
            <div class="border rounded-2xl p-6 hover:shadow-lg transition">
                <div class="text-red-600 text-3xl mb-4">
                    <i class="fa-solid fa-certificate"></i>
                </div>

                <h3 class="text-xl font-semibold text-[#232323]">
                    Advisory & Speaker Certificate
                </h3>

                <p class="mt-3 text-gray-600 leading-relaxed">
                    Issued to advisors, speakers, and panelists
                    for sharing expertise and insights at TMN sessions.
                </p>
            </div>

        </div>
    </div>
</section>

{{-- ================= SAMPLE CERTIFICATE PREVIEW ================= --}}
<section class="py-16 bg-[#f8f8f8]">
    <div class="main-width grid lg:grid-cols-2 gap-12 items-center">

        {{-- TEXT --}}
        <div>
            <h2 class="text-2xl font-semibold text-[#232323]">
                Digital & Verifiable Certificates
            </h2>

            <p class="mt-4 text-gray-600 leading-relaxed">
                All TMN certificates are digitally issued and verifiable.
                Each certificate includes participant details, event information,
                date, and authorized TMN validation.
            </p>

            <ul class="mt-6 space-y-3 text-gray-700">
                <li class="flex items-center gap-3">
                    <i class="fa-solid fa-check text-red-600"></i>
                    Unique certificate ID
                </li>
                <li class="flex items-center gap-3">
                    <i class="fa-solid fa-check text-red-600"></i>
                    Official TMN branding
                </li>
                <li class="flex items-center gap-3">
                    <i class="fa-solid fa-check text-red-600"></i>
                    Digital verification support
                </li>
            </ul>
        </div>

        {{-- IMAGE --}}
        <div>
            <img src="{{ $assetBase }}/images/certificate-sample.png"
                 alt="TMN Certificate Sample"
                 class="w-full rounded-2xl shadow-lg">
        </div>

    </div>
</section>

{{-- ================= HOW TO GET CERTIFICATE ================= --}}
<section class="py-16 bg-white">
    <div class="main-width">

        <h2 class="text-2xl font-semibold text-[#232323] mb-10">
            How to Receive a TMN Certificate
        </h2>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">

            <div class="p-6 border rounded-xl text-center">
                <div class="text-red-600 text-2xl mb-3 font-bold">01</div>
                <p class="text-gray-700">Register & attend a TMN event</p>
            </div>

            <div class="p-6 border rounded-xl text-center">
                <div class="text-red-600 text-2xl mb-3 font-bold">02</div>
                <p class="text-gray-700">Complete participation requirements</p>
            </div>

            <div class="p-6 border rounded-xl text-center">
                <div class="text-red-600 text-2xl mb-3 font-bold">03</div>
                <p class="text-gray-700">Certificate reviewed & approved</p>
            </div>

            <div class="p-6 border rounded-xl text-center">
                <div class="text-red-600 text-2xl mb-3 font-bold">04</div>
                <p class="text-gray-700">Receive certificate via email/dashboard</p>
            </div>

        </div>
    </div>
</section>

@include("user.components.footer")
