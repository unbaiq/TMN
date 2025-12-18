@php use Illuminate\Support\Str; @endphp

@include("user.components.meta")
@include("user.components.header")

@php
    $assetBase = app()->environment('local')
        ? ''
        : config('app.url') . '/tmn/public';
@endphp

{{-- ================= BANNER ================= --}}
<section class="bg-[url({{ $assetBase  }}/images/committee-banner.png)] bg-cover bg-center bg-no-repeat">
    <div class="w-full py-10 banner-grid">
        <div class="main-width flex items-center">
            <div class="max-w-2xl">
                <p class="text-white text-[25px]">Path to Business Growth.</p>

                <span class="heading2 bg-primary text-white py-2 px-7 inline-block mt-3">
                    Articles
                </span>

                <p class="text-white mt-4 text-[18px] leading-[30px]">
                    Have a question or need more information? Whether you're interested in
                    membership, learning about Chapters, or exploring franchise opportunities,
                    we're here to help.
                </p>
            </div>
        </div>
    </div>
</section>

{{-- ================= MAIN ================= --}}
<section class="py-10 bg-[#f2f2f2]">
    <div class="main-width grid grid-cols-[65%,1fr] gap-8">

        {{-- ============ LEFT : ARTICLES LIST ============ --}}
        <div class="space-y-10">

            @forelse($articles as $article)
                <div class="bg-white shadow border">

                    {{-- Image --}}
                    <img src="{{ $article->thumbnail_url }}" class="w-full h-[320px] object-cover"
                        alt="{{ $article->title }}">

                    <div class="p-8">

                        {{-- Meta --}}
                        <p class="text-sm text-gray-600">
                            {{ $article->publish_date?->format('F d, Y') }}
                            • {{ $article->author_name ?? 'TMN Editorial' }}
                        </p>

                        {{-- Title --}}
                        <h2 class="text-[32px] font-medium mt-2">
                            {{ $article->title }}
                        </h2>

                        {{-- Short Description --}}
                        <p class="mt-3 text-[16px] leading-[28px]">
                            {{ $article->short_description }}
                        </p>

                        {{-- CTA --}}
                        <div class="mt-6">
                            <a href="{{ route('articles.show', $article->slug) }}"
                                class="bg-red-600 text-white px-5 py-2 rounded">
                                Continue Reading →
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-500">No articles found.</p>
            @endforelse

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $articles->links() }}
            </div>
        </div>

        {{-- ============ RIGHT : SIDEBAR ============ --}}
        <aside>

            {{-- About TMN --}}
            <div class="px-4">
                <h2 class="text-[25px]">About TMN</h2>
                <hr class="w-[40%] border-2 mt-2 border-[#CF2031]">

                <p class="pt-6 text-[15px] leading-[26px]">
                    Top Management Network (TMN) brings CXOs under one roof
                    to exchange ideas, challenges and opportunities over
                    meaningful interactions.
                </p>
            </div>

            {{-- Social --}}
            <div class="px-4 mt-14">
                <h2 class="text-[25px]">Social</h2>
                <hr class="w-[20%] border-2 mt-2 border-[#CF2031]">

                <div class="flex gap-2 mt-4">
                    <div
                        class="border border-red-600 w-[40px] h-[40px] rounded-full flex items-center justify-center text-[#CF2031] hover:bg-[#CF2031] hover:text-white transition">
                        <i class="fa-brands fa-facebook-f"></i>
                    </div>
                    <div
                        class="border border-red-600 w-[40px] h-[40px] rounded-full flex items-center justify-center text-[#CF2031] hover:bg-[#CF2031] hover:text-white transition">
                        <i class="fa-brands fa-instagram"></i>
                    </div>
                    <div
                        class="border border-red-600 w-[40px] h-[40px] rounded-full flex items-center justify-center text-[#CF2031] hover:bg-[#CF2031] hover:text-white transition">
                        <i class="fa-brands fa-twitter"></i>
                    </div>
                    <div
                        class="border border-red-600 w-[40px] h-[40px] rounded-full flex items-center justify-center text-[#CF2031] hover:bg-[#CF2031] hover:text-white transition">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <div
                        class="border border-red-600 w-[40px] h-[40px] rounded-full flex items-center justify-center text-[#CF2031] hover:bg-[#CF2031] hover:text-white transition">
                        <i class="fa-brands fa-youtube"></i>
                    </div>
                </div>
            </div>

            {{-- Latest Articles --}}
            <div class="px-4 mt-14">
                <h2 class="text-[22px]">Latest Articles</h2>
                <hr class="w-[20%] border-2 mt-2 border-[#CF2031]">

                @foreach($latestArticles as $latest)
                    <a href="{{ route('articles.show', $latest->slug) }}" class="grid grid-cols-[90px,1fr] gap-4 mt-4">
                        <img src="{{ $latest->thumbnail_url }}" class="h-[80px] w-full object-cover"
                            alt="{{ $latest->title }}">

                        <div>
                            <h4 class="font-medium">{{ $latest->title }}</h4>
                            <p class="text-sm text-gray-600">
                                {{ $latest->publish_date?->format('F d, Y') }}
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>

        </aside>
    </div>
</section>

{{-- ================= PREVIOUS ARTICLES ================= --}}
<section class="py-14">
    <div class="main-width">
        <h2 class="text-[#232323] font-semibold text-[30px] mb-6">
            Previous Articles
        </h2>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-10">

            @forelse($previousArticles as $prev)
                <div class="h-[380px] border overflow-hidden rounded-xl shadow-xl
                     w-[340px] relative cursor-pointer group">

                    {{-- Article Image --}}
                    <img class="w-full h-full transition-all duration-700 group-hover:scale-110"
                        src="{{ $prev->thumbnail_url }}" alt="{{ $prev->title }}">

                    {{-- Hover Content --}}
                    <div class="absolute bottom-0 bg-white w-full h-[120px]
                       group-hover:h-[300px] duration-700 p-6">

                        <h2 class="font-semibold py-4 text-[20px]">
                            {{ $prev->title }}
                        </h2>

                        <p class="text-sm">
                            {{ Str::limit($prev->short_description, 90) }}
                        </p>

                        <div class="mt-3">
                            <a href="{{ route('articles.show', $prev->slug) }}">
                                <span class="bg-red-600 text-white px-4 py-2 text-[13px]">
                                    Read More
                                </span>
                            </a>
                        </div>

                    </div>
                </div>
            @empty
                <p class="text-gray-500">No previous articles available.</p>
            @endforelse
        </div>
    </div>
</section>

@include("user.components.footer")