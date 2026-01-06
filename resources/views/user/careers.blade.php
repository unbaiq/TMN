@include("user.components.meta")
@include("user.components.header")

@php
  $assetBase = app()->environment('local')
    ? ''
    : config('app.url') . '/tmn/public';
@endphp

{{-- ================= HERO SECTION ================= --}}
<section class="bg-white">
    <div class="main-width pt-10">
        <h1 class="text-3xl md:text-4xl font-semibold text-[#232323]">
            Build Your <span class="text-red-600 font-bold">Career</span> With TMN
        </h1>
    </div>

    <div class="main-width relative mt-6">
        {{-- IMAGE --}}
        <img src="{{$assetBase}}/images/abt-img.png"
             alt="TMN Careers"
             class="w-full h-[420px] object-cover rounded-2xl">

        {{-- OVERLAY CARD --}}
        <div class="absolute right-6 bottom-6 bg-[#232323]/90 text-white
                    rounded-2xl p-8 max-w-md shadow-xl">
            <h3 class="text-2xl font-semibold leading-tight">
                Let’s Grow <br>
                <span class="font-bold">Together</span>
            </h3>

            <p class="text-sm text-gray-200 mt-3 leading-relaxed">
                Join Top Management Network (TMN) and be part of a fast-growing
                professional ecosystem that empowers leaders, innovators,
                and entrepreneurs.
            </p>

            <a href="#openings"
               class="inline-block mt-5 bg-red-600 hover:bg-red-700
                      text-white px-6 py-3 rounded-full font-semibold transition">
                View Open Roles
            </a>
        </div>
    </div>
</section>

{{-- ================= APPLICATION PROCESS ================= --}}
<section class="py-16 bg-[#f8f8f8]">
    <div class="main-width grid lg:grid-cols-2 gap-14 items-center">

        {{-- TEXT --}}
        <div>
            <h2 class="text-3xl font-semibold text-[#232323]">
                The Application <span class="text-red-600">Process</span>
            </h2>

            <p class="mt-4 text-gray-600 leading-relaxed">
                Our hiring process is designed to ensure the best fit for both
                you and TMN. We focus on skills, mindset, experience, and
                alignment with our core values.
            </p>

            {{-- STEPS --}}
            <ul class="mt-6 space-y-4 text-[#232323]">
                <li class="flex gap-3">
                    <span class="text-red-600 font-bold">01.</span>
                    Apply for a suitable role
                </li>
                <li class="flex gap-3">
                    <span class="text-red-600 font-bold">02.</span>
                    Initial screening & interaction
                </li>
                <li class="flex gap-3">
                    <span class="text-red-600 font-bold">03.</span>
                    Skill & culture alignment discussion
                </li>
                <li class="flex gap-3">
                    <span class="text-red-600 font-bold">04.</span>
                    Final decision & onboarding
                </li>
            </ul>

            {{-- QUICK LINKS --}}
            <div class="flex flex-wrap gap-3 mt-8">
                <span class="px-5 py-2 rounded-full bg-white border text-sm">Life at TMN</span>
                <span class="px-5 py-2 rounded-full bg-white border text-sm">Core Values</span>
                <span class="px-5 py-2 rounded-full bg-white border text-sm">Meet Our Team</span>
                <span class="px-5 py-2 rounded-full bg-white border text-sm">Current Openings</span>
            </div>
        </div>

        {{-- IMAGE --}}
        <div>
            <img src="{{$assetBase}}/images/abt-img.png"
                 alt="TMN Recruitment Process"
                 class="w-full h-[360px] object-cover rounded-2xl shadow-lg">
        </div>
    </div>
</section>

{{-- ================= RECRUITMENT TEAM ================= --}}
<section class="py-20 bg-white">
    <div class="main-width text-center mb-14">
        <h2 class="text-4xl font-bold text-gray-700">
            Meet Our <span class="text-red-600">Recruitment Team</span>
        </h2>
    </div>

    <div class="relative max-w-5xl mx-auto">

        {{-- LEFT ARROW --}}
        <button
            class="hidden md:flex absolute -left-16 top-1/2 -translate-y-1/2
                   w-12 h-12 rounded-full border border-gray-300
                   items-center justify-center text-gray-600
                   hover:bg-red-600 hover:text-white transition">
            <i class="fa-solid fa-chevron-left"></i>
        </button>

        {{-- CARD --}}
        <div class="bg-white rounded-3xl shadow-xl p-8 md:p-10
                    flex flex-col md:flex-row gap-8 items-center">

            {{-- IMAGE --}}
            <div class="w-[220px] h-[260px] rounded-2xl overflow-hidden flex-shrink-0">
                <img
                    src="{{ asset('tmn/public/images/recruitment/todd-rimer.jpg') }}"
                    alt="Todd Rimer"
                    class="w-full h-full object-cover">
            </div>

            {{-- CONTENT --}}
            <div class="flex-1 text-left">

                <h3 class="text-2xl font-bold text-red-600">
                    Todd Rimer
                </h3>

                <p class="text-lg text-gray-700 mt-1">
                    Talent Acquisition Global Director
                </p>

                <p class="text-sm text-gray-500">
                    TMN Global, Scion, CorporateConnections®
                </p>

                <p class="mt-4 text-gray-600 leading-relaxed">
                    Leading Global Talent Acquisition for TMN and its divisions since
                    December 2022, Todd brings 29 years of experience in both corporate
                    and agency recruiting.
                </p>

                {{-- META --}}
                <div class="mt-4 space-y-2 text-sm text-gray-600">
                    <p class="flex items-center gap-2">
                        <i class="fa-solid fa-location-dot text-red-600"></i>
                        Global HQ, Charlotte, NC
                    </p>

                    <p class="flex items-center gap-2">
                        <i class="fa-solid fa-envelope text-red-600"></i>
                        toddrimer@TMN.com
                    </p>
                </div>

                {{-- QUOTE --}}
                <p class="mt-5 text-red-600 italic font-medium">
                    “People make the competitive difference.”
                </p>
            </div>

            {{-- LINKEDIN --}}
            <div class="self-end md:self-center">
                <a href="#" target="_blank"
                   class="text-[#0A66C2] text-3xl hover:opacity-80 transition">
                    <i class="fa-brands fa-linkedin"></i>
                </a>
            </div>
        </div>

        {{-- RIGHT ARROW --}}
        <button
            class="hidden md:flex absolute -right-16 top-1/2 -translate-y-1/2
                   w-12 h-12 rounded-full border border-gray-300
                   items-center justify-center text-gray-600
                   hover:bg-red-600 hover:text-white transition">
            <i class="fa-solid fa-chevron-right"></i>
        </button>

    </div>
</section>

{{-- ================= CORE VALUES ================= --}}
<section class="py-20 bg-white"
    x-data="{ open: 0 }">

    <div class="main-width grid lg:grid-cols-2 gap-16 items-start">

        {{-- LEFT CONTENT --}}
        <div>

            <h2 class="text-4xl font-bold text-gray-700">
                Core <span class="text-red-600">Values</span>
            </h2>

            <p class="mt-6 text-gray-600 leading-relaxed text-lg">
                TMN is built on a set of guiding principles which form the
                foundation on which members interact, conduct themselves,
                and fulfill their professional goals.
            </p>

            <h3 class="mt-12 text-3xl font-semibold text-gray-700 leading-tight">
                At TMN, we’re <span class="text-red-600">Changing the Way the World Does Business</span>
            </h3>

            {{-- TESTIMONIAL --}}
            <div class="mt-10 flex items-start gap-4">

                <img src="{{ asset('tmn/public/images/team/nancy.jpg') }}"
                     class="w-14 h-14 rounded-full object-cover"
                     alt="TMN Leader">

                <div>
                    <p class="text-gray-600 italic">
                        As part of TMN leadership, I’ve experienced tremendous
                        growth, learning, and global collaboration.
                    </p>

                    <p class="mt-3 font-semibold text-gray-800">
                        Nancy Deva Priya
                    </p>

                    <p class="text-sm text-gray-500">
                        Director of APAC Operations | India
                    </p>
                </div>
            </div>
        </div>

        {{-- RIGHT ACCORDION --}}
        <div class="space-y-6">

            {{-- ITEM --}}
            <div class="border-b pb-4">
                <button @click="open = open === 1 ? 0 : 1"
                        class="w-full flex justify-between items-center text-left">
                    <div class="flex items-center gap-4">
                        <span class="text-red-600 text-2xl">🤝</span>
                        <h4 class="text-xl font-semibold text-red-600">
                            Givers Gain®
                        </h4>
                    </div>
                    <span class="text-2xl" x-text="open === 1 ? '−' : '+'"></span>
                </button>

                <div x-show="open === 1"
                     x-transition
                     class="mt-4 text-gray-600 leading-relaxed">
                    Be willing to give first before you expect to gain.
                    Giving unconditionally creates better opportunities
                    and long-lasting relationships.
                </div>
            </div>

            {{-- ITEM --}}
            <div class="border-b pb-4">
                <button @click="open = open === 2 ? 0 : 2"
                        class="w-full flex justify-between items-center text-left">
                    <h4 class="text-xl text-gray-700">Lifelong Learning</h4>
                    <span class="text-2xl" x-text="open === 2 ? '−' : '+'"></span>
                </button>

                <div x-show="open === 2"
                     x-transition
                     class="mt-4 text-gray-600 leading-relaxed">
                    TMN encourages continuous personal and professional
                    development through learning, mentoring, and experience.
                </div>
            </div>

            {{-- ITEM --}}
            <div class="border-b pb-4">
                <button @click="open = open === 3 ? 0 : 3"
                        class="w-full flex justify-between items-center text-left">
                    <h4 class="text-xl text-gray-700">Traditions + Innovation</h4>
                    <span class="text-2xl" x-text="open === 3 ? '−' : '+'"></span>
                </button>

                <div x-show="open === 3"
                     x-transition
                     class="mt-4 text-gray-600 leading-relaxed">
                    We honor proven systems while embracing innovation
                    to remain relevant and impactful.
                </div>
            </div>

            {{-- ITEM --}}
            <div class="border-b pb-4">
                <button @click="open = open === 4 ? 0 : 4"
                        class="w-full flex justify-between items-center text-left">
                    <h4 class="text-xl text-gray-700">Positive Attitude</h4>
                    <span class="text-2xl" x-text="open === 4 ? '−' : '+'"></span>
                </button>

                <div x-show="open === 4"
                     x-transition
                     class="mt-4 text-gray-600 leading-relaxed">
                    We choose optimism, resilience, and solution-oriented thinking.
                </div>
            </div>

            {{-- ITEM --}}
            <div class="border-b pb-4">
                <button @click="open = open === 5 ? 0 : 5"
                        class="w-full flex justify-between items-center text-left">
                    <h4 class="text-xl text-gray-700">Building Relationships</h4>
                    <span class="text-2xl" x-text="open === 5 ? '−' : '+'"></span>
                </button>

                <div x-show="open === 5"
                     x-transition
                     class="mt-4 text-gray-600 leading-relaxed">
                    Meaningful relationships are the foundation of
                    sustainable business success.
                </div>
            </div>

            {{-- ITEM --}}
            <div class="border-b pb-4">
                <button @click="open = open === 6 ? 0 : 6"
                        class="w-full flex justify-between items-center text-left">
                    <h4 class="text-xl text-gray-700">Accountability</h4>
                    <span class="text-2xl" x-text="open === 6 ? '−' : '+'"></span>
                </button>

                <div x-show="open === 6"
                     x-transition
                     class="mt-4 text-gray-600 leading-relaxed">
                    We take ownership of our actions, commitments,
                    and results.
                </div>
            </div>

            {{-- ITEM --}}
            <div class="border-b pb-4">
                <button @click="open = open === 7 ? 0 : 7"
                        class="w-full flex justify-between items-center text-left">
                    <h4 class="text-xl text-gray-700">Recognition</h4>
                    <span class="text-2xl" x-text="open === 7 ? '−' : '+'"></span>
                </button>

                <div x-show="open === 7"
                     x-transition
                     class="mt-4 text-gray-600 leading-relaxed">
                    We celebrate achievements, effort, and contribution
                    across the TMN ecosystem.
                </div>
            </div>

        </div>
    </div>
</section>

<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>


@include("user.components.footer")
