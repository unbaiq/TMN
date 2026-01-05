@include("user.components.meta")
@include("user.components.header")

@php
  $assetBase = app()->environment('local')
    ? ''
    : config('app.url') . '/tmn/public';
@endphp

{{-- ================= HERO ================= --}}
<section class="bg-gradient-to-r from-gray-100 to-gray-50 border-b border-gray-200">
    <div class="main-width py-14 text-center">
        <h1 class="text-3xl md:text-4xl font-bold text-[#232323]">
            Frequently Asked <span class="text-red-600">Questions</span>
        </h1>

        <p class="text-gray-600 mt-4 max-w-3xl mx-auto leading-relaxed">
            Find answers to common questions about Top Management Network (TMN),
            memberships, events, advisory sessions, and more.
        </p>
    </div>
</section>

{{-- ================= FAQ CONTENT ================= --}}
<section class="py-20 bg-white">
    <div class="main-width max-w-4xl"
         x-data="{ open: null }">

        {{-- FAQ ITEM --}}
        <div class="space-y-6">

            {{-- 1 --}}
            <div class="border border-gray-200 rounded-2xl p-6 shadow-sm">
                <button @click="open === 1 ? open = null : open = 1"
                        class="w-full flex justify-between items-center text-left">
                    <h3 class="text-lg font-semibold text-[#232323]">
                        What is Top Management Network (TMN)?
                    </h3>
                    <i class="fa-solid"
                       :class="open === 1 ? 'fa-minus text-red-600' : 'fa-plus text-gray-500'"></i>
                </button>

                <div x-show="open === 1"
                     x-collapse
                     class="mt-4 text-gray-600 leading-relaxed">
                    TMN is a professional business networking platform that connects
                    CXOs, founders, entrepreneurs, and senior professionals to
                    collaborate, learn, and grow through structured meetings,
                    advisory sessions, and curated events.
                </div>
            </div>

            {{-- 2 --}}
            <div class="border border-gray-200 rounded-2xl p-6 shadow-sm">
                <button @click="open === 2 ? open = null : open = 2"
                        class="w-full flex justify-between items-center text-left">
                    <h3 class="text-lg font-semibold text-[#232323]">
                        Who can join TMN?
                    </h3>
                    <i class="fa-solid"
                       :class="open === 2 ? 'fa-minus text-red-600' : 'fa-plus text-gray-500'"></i>
                </button>

                <div x-show="open === 2"
                     x-collapse
                     class="mt-4 text-gray-600 leading-relaxed">
                    TMN is open to business owners, CXOs, directors, senior leaders,
                    and professionals who are committed to ethical networking and
                    business growth. Membership approval is subject to TMN review.
                </div>
            </div>

            {{-- 3 --}}
            <div class="border border-gray-200 rounded-2xl p-6 shadow-sm">
                <button @click="open === 3 ? open = null : open = 3"
                        class="w-full flex justify-between items-center text-left">
                    <h3 class="text-lg font-semibold text-[#232323]">
                        Is TMN membership paid?
                    </h3>
                    <i class="fa-solid"
                       :class="open === 3 ? 'fa-minus text-red-600' : 'fa-plus text-gray-500'"></i>
                </button>

                <div x-show="open === 3"
                     x-collapse
                     class="mt-4 text-gray-600 leading-relaxed">
                    Yes, TMN offers structured membership plans. Fees vary depending
                    on chapter, benefits, and engagement level. Details are shared
                    during the onboarding process.
                </div>
            </div>

            {{-- 4 --}}
            <div class="border border-gray-200 rounded-2xl p-6 shadow-sm">
                <button @click="open === 4 ? open = null : open = 4"
                        class="w-full flex justify-between items-center text-left">
                    <h3 class="text-lg font-semibold text-[#232323]">
                        What types of events does TMN organize?
                    </h3>
                    <i class="fa-solid"
                       :class="open === 4 ? 'fa-minus text-red-600' : 'fa-plus text-gray-500'"></i>
                </button>

                <div x-show="open === 4"
                     x-collapse
                     class="mt-4 text-gray-600 leading-relaxed">
                    TMN organizes chapter meetings, leadership talks, business
                    networking events, advisory sessions, workshops, and
                    industry-specific roundtables—both online and offline.
                </div>
            </div>

            {{-- 5 --}}
            <div class="border border-gray-200 rounded-2xl p-6 shadow-sm">
                <button @click="open === 5 ? open = null : open = 5"
                        class="w-full flex justify-between items-center text-left">
                    <h3 class="text-lg font-semibold text-[#232323]">
                        How do advisory sessions work?
                    </h3>
                    <i class="fa-solid"
                       :class="open === 5 ? 'fa-minus text-red-600' : 'fa-plus text-gray-500'"></i>
                </button>

                <div x-show="open === 5"
                     x-collapse
                     class="mt-4 text-gray-600 leading-relaxed">
                    Advisory sessions are conducted by experienced industry experts.
                    Members can participate in scheduled sessions to gain insights,
                    strategic guidance, and real-world solutions.
                </div>
            </div>

            {{-- 6 --}}
            <div class="border border-gray-200 rounded-2xl p-6 shadow-sm">
                <button @click="open === 6 ? open = null : open = 6"
                        class="w-full flex justify-between items-center text-left">
                    <h3 class="text-lg font-semibold text-[#232323]">
                        How can I contact TMN for support?
                    </h3>
                    <i class="fa-solid"
                       :class="open === 6 ? 'fa-minus text-red-600' : 'fa-plus text-gray-500'"></i>
                </button>

                <div x-show="open === 6"
                     x-collapse
                     class="mt-4 text-gray-600 leading-relaxed">
                    You can reach TMN via the Contact page, email support, or through
                    your chapter coordinator. Our team is always happy to assist.
                </div>
            </div>

        </div>

        {{-- FOOT NOTE --}}
        <div class="mt-16 text-center text-gray-500 text-sm">
            Didn’t find what you were looking for?
            <a href="{{ url('/contact') }}"
               class="text-red-600 font-semibold hover:underline">
                Contact TMN Support
            </a>
        </div>

    </div>
</section>

@include("user.components.footer")
