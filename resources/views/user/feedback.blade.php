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
            Share Your <span class="text-red-600">Feedback</span>
        </h1>

        <p class="text-gray-600 mt-4 max-w-2xl mx-auto leading-relaxed">
            Your feedback helps TMN enhance experiences, improve events,
            and serve our community better.
        </p>
    </div>
</section>

{{-- ================= CONTENT ================= --}}
<section class="py-20 bg-[#f8f8f8]">
    <div class="main-width grid lg:grid-cols-[60%,1fr] gap-12 items-start">

        {{-- ================= FORM CARD ================= --}}
        <div class="bg-white rounded-2xl shadow-xl p-8 md:p-10">

            <h2 class="text-2xl font-semibold text-[#232323] mb-6">
                We’d love to hear from you
            </h2>

            <form class="space-y-6">

                {{-- NAME + EMAIL --}}
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Your Name
                        </label>
                        <input type="text"
                               placeholder="Enter your name"
                               class="w-full rounded-lg border-gray-300
                                      focus:border-red-600 focus:ring-red-600">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Email Address
                        </label>
                        <input type="email"
                               placeholder="you@example.com"
                               class="w-full rounded-lg border-gray-300
                                      focus:border-red-600 focus:ring-red-600">
                    </div>
                </div>

                {{-- TYPE --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Feedback Category
                    </label>
                    <select
                        class="w-full rounded-lg border-gray-300
                               focus:border-red-600 focus:ring-red-600">
                        <option>Select category</option>
                        <option>Website Experience</option>
                        <option>Events & Meetups</option>
                        <option>Membership</option>
                        <option>Support</option>
                        <option>Other</option>
                    </select>
                </div>

                {{-- MESSAGE --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Your Feedback
                    </label>
                    <textarea rows="5"
                              placeholder="Share your thoughts with us..."
                              class="w-full rounded-lg border-gray-300
                                     focus:border-red-600 focus:ring-red-600"></textarea>
                </div>

                {{-- SUBMIT --}}
                <div class="pt-4">
                    <button type="submit"
                            class="inline-flex items-center gap-2
                                   bg-red-600 hover:bg-red-700
                                   text-white px-8 py-3
                                   rounded-full font-semibold
                                   shadow-lg transition">
                        <i class="fa-solid fa-paper-plane"></i>
                        Submit Feedback
                    </button>
                </div>

            </form>
        </div>

        {{-- ================= INFO CARD ================= --}}
        <aside class="bg-white rounded-2xl shadow-lg p-8 border border-gray-200">

            <h3 class="text-xl font-semibold text-[#232323] mb-4">
                Why Your Feedback Matters
            </h3>

            <ul class="space-y-4 text-gray-600 text-sm leading-relaxed">
                <li class="flex gap-3">
                    <i class="fa-solid fa-check text-red-600 mt-1"></i>
                    Helps us improve events, meetings, and experiences
                </li>
                <li class="flex gap-3">
                    <i class="fa-solid fa-check text-red-600 mt-1"></i>
                    Shapes future TMN initiatives
                </li>
                <li class="flex gap-3">
                    <i class="fa-solid fa-check text-red-600 mt-1"></i>
                    Ensures better support for members
                </li>
            </ul>

            <div class="mt-8 border-t pt-6 text-sm text-gray-500">
                TMN values transparency, growth, and continuous improvement.
                Thank you for being part of our journey.
            </div>

        </aside>
    </div>
</section>

@include("user.components.footer")
