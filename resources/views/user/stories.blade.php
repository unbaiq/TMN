@include("user.components.meta")
@include("user.components.header")

    @php
        $assetBase = app()->environment('local')
            ? ''
            : config('app.url') . '/tmn/public';
    @endphp

{{-- ===================== BANNER ===================== --}}
<section class="bg-[url({{ $assetBase  }}/images/committee-banner.png)] bg-cover lg:bg-right bg-center bg-no-repeat">
  <div class="w-full py-10 h-full banner-grid">
    <div class="main-width h-full py-4 flex items-center lg:justify-start">
      <div class="grid md:grid-cols-[58%,1fr] gap-6 items-center">
        <div>
          <p class="text-white lg:py-3 py-2 lg:text-[25px] text-[17px] font-normal lg:leading-[25px]">
            Path to Business Growth.
          </p>
          <div class="w-full">
            <span class="heading2 bg-primary text-white py-2 px-7">Stories</span>
          </div>
          <p class="text-white lg:py-3 py-2 lg:text-[19px] text-[16px] font-normal lg:leading-[30px]">
            Have a question or need more information? Whether you're interested in membership, learning about Chapters, or exploring franchise opportunities, we're here to help.
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- ===================== MAIN SECTION ===================== --}}
<section class="py-10 text-[#232323] bg-[#f2f2f2]">
  <div class="main-width">
    <div class="grid grid-cols-[65%,1fr] gap-8">

      {{-- ================= LEFT COLUMN ================= --}}
      <div>
        @forelse($stories as $story)
        <div class="bg-white shadow border mt-10">
          <div class="relative bg-white">
            <div class="clip-design">
              <img src="{{ $story->image_url }}" class="w-full h-full" alt="{{ $story->title }}">
            </div>

            <div class="absolute bottom-2 pl-10 pt-8">
              <div class="mb-[2px]">
                <span class="text-sm">
                  {{ $story->publish_date?->format('F d, Y') }}
                </span>
              </div>
              <span class="text-[#CF2031]">
                {{ $story->author_name ?? 'TMN Editorial' }}
              </span>
            </div>
          </div>

          <div class="px-8 pb-8">
            <h2 class="text-[#232323] font-medium text-[35px]">
              {{ $story->title }}
            </h2>

            <p class="text-[16px] font-normal lg:leading-[30px]">
              {{ $story->short_description }}
            </p>

            <div class="py-4 mt-4">
              <a href="{{ route('stories.show', $story->slug) }}">
                <span class="bg-red-600 rounded shadow text-white px-4 py-2 text-[17px]">
                  Continue Reading...
                </span>
              </a>
            </div>

            <div class="flex items-center gap-2 mt-3">
              <div class="border-red-600 border flex items-center justify-center w-[40px] h-[40px] rounded-full">
                <i class="fa-brands fa-facebook-f"></i>
              </div>
              <div class="border-red-600 border flex items-center justify-center w-[40px] h-[40px] rounded-full">
                <i class="fa-brands fa-instagram"></i>
              </div>
              <div class="border-red-600 border flex items-center justify-center w-[40px] h-[40px] rounded-full">
                <i class="fa-brands fa-x-twitter"></i>
              </div>
              <div class="border-red-600 border flex items-center justify-center w-[40px] h-[40px] rounded-full">
                <i class="fa fa-envelope"></i>
              </div>
            </div>
          </div>
        </div>
        @empty
          <p class="text-center mt-10 text-gray-500">No stories found.</p>
        @endforelse

        {{-- Pagination --}}
        <div class="mt-10">
          {{ $stories->links() }}
        </div>
      </div>

      {{-- ================= RIGHT COLUMN ================= --}}
      <div>
        {{-- About --}}
        <div class="px-4">
          <h2 class="text-[#232323] font-normal text-[25px]">About TMN</h2>
          <hr class="w-[40%] border-[2px] mt-2 border-[#CF2031]">
          <p class="text-[#232323] pt-6">
            TMN is a business networking platform dedicated to helping professionals connect, collaborate, and grow.
          </p>
        </div>

        {{-- Social --}}
        <div class="px-4 mt-14">
          <h2 class="text-[#232323] font-normal text-[25px]">Social</h2>
          <hr class="w-[20%] border-[2px] mt-2 border-[#CF2031]">
          <div class="flex items-center gap-2 mt-3">
            <div class="border-red-600 border w-[40px] h-[40px] rounded-full flex items-center justify-center"><i class="fa-brands fa-facebook-f"></i></div>
            <div class="border-red-600 border w-[40px] h-[40px] rounded-full flex items-center justify-center"><i class="fa-brands fa-instagram"></i></div>
            <div class="border-red-600 border w-[40px] h-[40px] rounded-full flex items-center justify-center"><i class="fa-brands fa-twitter"></i></div>
            <div class="border-red-600 border w-[40px] h-[40px] rounded-full flex items-center justify-center"><i class="fa-regular fa-envelope"></i></div>
            <div class="border-red-600 border w-[40px] h-[40px] rounded-full flex items-center justify-center"><i class="fa-brands fa-youtube"></i></div>
          </div>
        </div>

        {{-- Latest Stories --}}
        <div class="px-4 mt-14">
          <h2 class="text-[#232323] font-normal text-[22px]">Latest Story</h2>
          <hr class="w-[20%] border-[2px] mt-2 border-[#CF2031]">

          <div class="mt-4 space-y-4">
            @foreach($latestStories as $latest)
            <div class="grid grid-cols-[100px,1fr] gap-4">
              <img src="{{ $latest->image_url }}" class="h-[90px] w-full object-cover" alt="">
              <div>
                <h4 class="text-[#232323] font-medium">
                  {{ $latest->title }}
                </h4>
                <p class="text-gray-600 py-1">
                  {{ $latest->publish_date?->format('F d, Y') }}
                </p>
              </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- ================= PREVIOUS STORIES ================= --}}
<section class="py-14">
  <div class="main-width">
    <h2 class="text-[#232323] font-semibold text-[30px] mb-6">Previous Story</h2>
    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-10">
      @foreach($previousStories as $prev)
      <div class="h-[380px] border overflow-hidden rounded-xl shadow-xl w-[340px] relative cursor-pointer group">
        <img class="w-full h-full transition-all duration-700 group-hover:scale-110"
             src="{{ $prev->image_url }}" alt="">
        <div class="absolute bottom-0 bg-white w-full h-[120px] group-hover:h-[300px] duration-700 p-6">
          <h2 class="font-semibold py-4 text-[20px]">
            {{ $prev->title }}
          </h2>
          <p class="text-sm">
            {{ Str::limit($prev->short_description, 90) }}
          </p>
          <div class="mt-3">
            <a href="{{ route('stories.show', $prev->slug) }}">
              <span class="bg-red-600 text-white px-4 py-2 text-[13px]">
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

@include("user.components.footer")
