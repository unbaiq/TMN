@include("user.components.meta")
@include("user.components.header")
    <section
      class="bg-[url({{ config('app.url') }}/tmn/public/images/insight-banner.png)] bg-cover lg:bg-right bg-center bg-no-repeat"
    >
         <div class="w-full py-10 h-full "> 
      <div class="main-width h-full py-4 flex items-center lg:justify-start">
        <div class="w-full grid md:grid-cols-[58%,1fr] gap-6 items-center">
          <div h-full>
            <p
              class="text-white lg:py-3 py-2 lg:text-[25px] text-[17px] font-normal lg:leading-[25px]"
            >
            Path to Business Growth
            </p>
            <div class="w-full ">
              <span class="heading2 bg-primary text-white py-2 px-7">
               Insights
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
    <section class="py-10">
  <div class="main-width">

    @foreach($insights as $index => $insight)

      @php
        // ----- TITLE COLOR SPLIT LOGIC -----
        if (str_contains($insight->title, ' to ')) {
            [$left, $right] = explode(' to ', $insight->title, 2);
            $right = 'to ' . $right;
        } elseif (str_contains($insight->title, ':')) {
            [$left, $right] = explode(':', $insight->title, 2);
            $right = ': ' . $right;
        } else {
            $left = $insight->title;
            $right = null;
        }
      @endphp

      {{-- EVEN INDEX → IMAGE RIGHT --}}
      @if($index % 2 === 0)
      <div class="grid bg-[#F8F8F8] p-8 lg:grid-cols-[1fr,35%] items-center gap-10 pt-10">

        {{-- TEXT --}}
        <div>
          <p class="font-semibold lg:text-[35px] leading-[normal]">
            <span class="text-[#232323]">{{ $left }}</span>
            @if($right)
              <span class="text-primary">{{ $right }}</span>
            @endif
          </p>

          @if($insight->short_description)
          <p class="pt-4 text-primary font-bold">
            {{ $insight->short_description }}
          </p>
          @endif

          <div class="text-[16px] font-normal leading-[25px] text-[#232323] mt-3">
            {!! nl2br(e(Str::limit($insight->description, 420))) !!}
          </div>

          <div class="mt-6">
            <a href="">
              <span class="text-white bg-primary px-6 text-[17px] font-medium py-3 inline-block">
                Read more
              </span>
            </a>
          </div>
        </div>

        {{-- IMAGE --}}
        <div class="lg:order-2 order-1">
          <img
            src="{{ $insight->image_url }}"
            class="w-full h-full object-cover rounded-lg"
            loading="lazy"
            alt="{{ $insight->title }}"
          >
        </div>

      </div>

      {{-- ODD INDEX → IMAGE LEFT --}}
      @else
      <div class="grid lg:grid-cols-[35%,1fr] p-8 items-center gap-10 pt-14">

        {{-- IMAGE --}}
        <div>
          <img
            src="{{ $insight->image_url }}"
            class="w-full h-full object-cover rounded-lg"
            loading="lazy"
            alt="{{ $insight->title }}"
          >
        </div>

        {{-- TEXT --}}
        <div>
          <p class="font-semibold lg:text-[35px] leading-[normal]">
            <span class="text-[#232323]">{{ $left }}</span>
            @if($right)
              <span class="text-primary">{{ $right }}</span>
            @endif
          </p>

          @if($insight->short_description)
          <p class="pt-4 lg:text-[20px] text-[18px] text-primary font-semibold">
            {{ $insight->short_description }}
          </p>
          @endif

          <div class="text-[16px] font-normal leading-[25px] text-[#232323] mt-3">
            {!! nl2br(e(Str::limit($insight->description, 420))) !!}
          </div>

          <div class="mt-6">
            <a href="">
              <span class="text-white bg-primary px-6 text-[17px] font-medium py-3 inline-block">
                Read more
              </span>
            </a>
          </div>
        </div>

      </div>
      @endif

    @endforeach

  </div>
</section>


   @include('user.components.footer')