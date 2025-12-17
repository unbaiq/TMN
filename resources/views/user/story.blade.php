@include('user.components.meta')
@include('user.components.header')

{{-- ===================== HERO / BANNER ===================== --}}
<section class="bg-[url({{ config('app.url') }}/tmn/public/images/banner.png)] bg-cover bg-center py-14">
    <div class="main-width">
        <div class="max-w-3xl">
            <p class="text-white text-[18px] mb-2">
                TMNians Story
            </p>

            <h1 class="text-white text-[36px] leading-[46px] font-semibold">
                {{ $story->title }}
            </h1>

            <div class="flex items-center gap-4 text-white text-sm mt-4">
                <span>
                    {{ $story->publish_date?->format('F d, Y') }}
                </span>
                <span>•</span>
                <span>
                    {{ $story->author_name ?? 'TMN Editorial' }}
                </span>
            </div>
        </div>
    </div>
</section>

{{-- ===================== STORY CONTENT ===================== --}}
<section class="py-14 bg-[#f2f2f2]">
    <div class="main-width grid lg:grid-cols-[70%,1fr] gap-10">

        {{-- ========= LEFT : STORY ========= --}}
        <div class="bg-white rounded-xl shadow p-8">

            {{-- Image --}}
            @if($story->image_url)
                <img
                    src="{{ $story->image_url }}"
                    alt="{{ $story->title }}"
                    class="w-full rounded-lg mb-6"
                >
            @endif

            {{-- Short Description --}}
            @if($story->short_description)
                <p class="text-[18px] text-[#232323] font-medium mb-6 leading-[30px]">
                    {{ $story->short_description }}
                </p>
            @endif

            {{-- Full Content --}}
            <div class="text-[16px] leading-[30px] text-[#232323] space-y-4">
                {!! nl2br(e($story->description)) !!}
            </div>

            {{-- Back --}}
            <div class="mt-10">
                <a href="{{ route('stories.index') }}"
                   class="inline-flex items-center gap-2 text-[#CF2031] font-medium">
                    ← Back to Stories
                </a>
            </div>
        </div>

        {{-- ========= RIGHT : SIDEBAR ========= --}}
        <aside class="space-y-10">

            {{-- About --}}
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-[22px] font-medium text-[#232323]">
                    About TMN
                </h3>
                <hr class="w-[40%] border-2 border-[#CF2031] mt-2 mb-4">
                <p class="text-[#232323] text-[15px] leading-[26px]">
                    Top Management Network is a premium business networking
                    platform bringing CXOs under one roof to connect, collaborate
                    and grow together.
                </p>
            </div>

            {{-- Meta --}}
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-[20px] font-medium text-[#232323] mb-4">
                    Story Details
                </h3>

                <ul class="text-sm text-gray-700 space-y-2">
                    <li><strong>Published:</strong>
                        {{ $story->publish_date?->format('F d, Y') }}
                    </li>
                    <li><strong>Author:</strong>
                        {{ $story->author_name ?? 'TMN Editorial' }}
                    </li>
                    <li><strong>Views:</strong>
                        {{ $story->views ?? 0 }}
                    </li>
                </ul>
            </div>

        </aside>
    </div>
</section>

@include('user.components.footer')
