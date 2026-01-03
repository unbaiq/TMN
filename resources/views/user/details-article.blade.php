@include("user.components.meta")
@include("user.components.header")
@php
    $assetBase = app()->environment('local')
        ? ''
        : config('app.url') . '/tmn/public';
@endphp


   <section
  class="bg-[url('{{ config('app.url') }}/tmn/public/images/committee-banner.png')] bg-cover lg:bg-right bg-center bg-no-repeat"
>
 <div class="w-full py-10 h-full banner-grid"> 
      <div class="main-width h-full py-4 flex items-center lg:justify-start">
        <div class="grid md:grid-cols-[58%,1fr] gap-6 items-center">
          <div h-full>
            <p
              class="text-white lg:py-3 py-2 lg:text-[25px] text-[17px] font-normal lg:leading-[25px]"
            >
             Path to Business Growth.
            </p>
            <div class="w-full ">
              <span class="heading2 bg-primary text-white py-2 px-7">
              Articles
              </span>
            </div>
            <p
              class="text-white lg:py-3 py-2 lg:text-[19px] text-[16px] font-normal lg:leading-[30px]"
            >
             Have a question or need more information? Whether you're interested in membership, learning about Chapters, or exploring franchise opportunities, we're here to help. Reach out, and our team will connect you with the right resources.  
            </p>
          </div>
          
        </div>
      </div>
      </div>
    </section>
<section class="py-14 bg-white">
    <div class="main-width">

        {{-- CATEGORY TAG --}}
        <span class="inline-block mb-4 px-4 py-1 text-sm font-medium
                     bg-red-600/10 text-red-600 rounded">
            ARTICLE
        </span>

        {{-- TITLE --}}
        <h1 class="text-3xl md:text-4xl font-bold text-[#232323] leading-tight">
            {{ $article->title }}
        </h1>

        {{-- META --}}
        <p class="text-sm text-gray-500 mt-3">
            Published: {{ $article->publish_date?->format('F d, Y') }}
            &nbsp; | &nbsp;
            By: {{ $article->author_name ?? 'TMN Editorial' }}
        </p>

        {{-- CONTENT GRID --}}
        <div class="grid lg:grid-cols-2 gap-10 mt-8 items-start">

            {{-- LEFT CONTENT --}}
            <div class="text-[#232323] leading-[28px] space-y-6">

                {{-- SHORT DESCRIPTION --}}
                @if($article->short_description)
                    <p class="text-lg font-medium">
                        {{ $article->short_description }}
                    </p>
                @endif

                {{-- FULL CONTENT --}}
                <div class="prose max-w-none">
                    {!! nl2br(e($article->description)) !!}
                </div>

                {{-- SHARE --}}
                <div class="pt-6">
                    <h4 class="text-red-600 font-semibold mb-3">
                        Share This Article
                    </h4>

                    <div class="flex gap-3">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}"
                           target="_blank"
                           class="w-10 h-10 border border-red-600 rounded-full
                                  flex items-center justify-center
                                  text-red-600 hover:bg-red-600 hover:text-white transition">
                            <i class="fa-brands fa-facebook-f"></i>
                        </a>

                        <a href="https://www.instagram.com/"
                           target="_blank"
                           class="w-10 h-10 border border-red-600 rounded-full
                                  flex items-center justify-center
                                  text-red-600 hover:bg-red-600 hover:text-white transition">
                            <i class="fa-brands fa-instagram"></i>
                        </a>

                        <a href="https://twitter.com/intent/tweet?url={{ url()->current() }}"
                           target="_blank"
                           class="w-10 h-10 border border-red-600 rounded-full
                                  flex items-center justify-center
                                  text-red-600 hover:bg-red-600 hover:text-white transition">
                            <i class="fa-brands fa-x-twitter"></i>
                        </a>

                        <a href="mailto:?subject={{ $article->title }}&body={{ url()->current() }}"
                           class="w-10 h-10 border border-red-600 rounded-full
                                  flex items-center justify-center
                                  text-red-600 hover:bg-red-600 hover:text-white transition">
                            <i class="fa fa-envelope"></i>
                        </a>
                    </div>
                </div>

                {{-- BACK --}}
                <div class="pt-6">
                    <a href="{{ route('articles.index') }}"
                       class="inline-flex items-center gap-2
                              bg-red-600 text-white px-6 py-3 rounded font-semibold">
                        <i class="fa-solid fa-arrow-left"></i>
                        Back to Articles
                    </a>
                </div>
            </div>

            {{-- RIGHT IMAGE --}}
            <div>
               <img src="{{ asset('storage/' . $article->banner) }}">

            </div>

        </div>
    </div>
</section>
{{-- ================= PREVIOUS ARTICLES ================= --}}
@if($previousArticles->count())
<section class="py-14 bg-[#f8f8f8]">
  <div class="main-width">

    <h2 class="text-[#232323] font-semibold text-[30px] mb-6">
      Previous Articles
    </h2>

    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-10">

      @foreach($previousArticles as $prev)
        <div
          class="h-[380px] border overflow-hidden rounded-xl shadow-xl
                 relative cursor-pointer group bg-white">

          {{-- IMAGE --}}
          <img
            class="w-full h-full object-cover transition-all duration-700
                   group-hover:scale-110"
            src="{{ asset('storage/' . $prev->thumbnail) }}"
            alt="{{ $prev->title }}">

          {{-- CONTENT --}}
          <div
            class="absolute bottom-0 bg-white w-full h-[120px]
                   group-hover:h-[300px] transition-all duration-700 p-6">

            <h3 class="font-semibold text-[18px] leading-tight">
              {{ $prev->title }}
            </h3>

            <p class="text-sm text-gray-600 mt-2">
              {{ \Illuminate\Support\Str::limit($prev->short_description, 90) }}
            </p>

            <div class="mt-4">
              <a href="{{ route('articles.show', $prev->slug) }}">
                <span class="bg-red-600 text-white px-4 py-2 text-[13px] rounded">
                  Read More
                </span>
              </a>
            </div>

          </div>
        </div>
      @endforeach

    </div>
  </div>
</section>
@endif


@include("user.components.footer")