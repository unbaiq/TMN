@include("user.components.meta")
@include("user.components.header")

@php
  $assetBase = app()->environment('local')
    ? ''
    : config('app.url') . '/tmn/public';

  // ===== TITLE COLOR SPLIT (SAME LOGIC AS LISTING) =====
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

{{-- ================= BANNER ================= --}}

<section class="bg-[url({{ $assetBase }}/images/insight-banner.png)] bg-cover lg:bg-right bg-center bg-no-repeat">
  <div class="w-full py-10 h-full ">
    <div class="main-width h-full py-4 flex items-center lg:justify-start">
      <div class="w-full grid md:grid-cols-[58%,1fr] gap-6 items-center">
        <div h-full>
          <p class="text-white lg:py-3 py-2 lg:text-[25px] text-[17px] font-normal lg:leading-[25px]">
            Path to Business Growth
          </p>
          <div class="w-full ">
            <span class="heading2 bg-primary text-white py-2 px-7">
              Insights
            </span>
          </div>
          <p class="text-white lg:py-3 py-2 lg:text-[19px] text-[16px] font-normal lg:leading-[30px]">
            Have a question or need more information? Whether you're interested in membership, learning about Chapters,
            or exploring franchise opportunities, we're here to help. Reach out, and our team will connect you with the
            right resources.
          </p>
        </div>

      </div>
    </div>
  </div>
</section>

{{-- ================= CONTENT ================= --}}
<section class="py-14">
  <div class="main-width grid lg:grid-cols-[65%,1fr] gap-10">

    {{-- MAIN CONTENT --}}
    <div>

      {{-- IMAGE --}}
      @if($insight->image_url)
        <img src="{{ $insight->image_url }}"
             class="w-full rounded-xl mb-8"
             alt="{{ $insight->title }}">
      @endif

      {{-- SHORT DESCRIPTION --}}
      @if($insight->short_description)
        <p class="text-primary font-bold text-lg mb-4">
          {{ $insight->short_description }}
        </p>
      @endif

      {{-- FULL DESCRIPTION --}}
      <div class="text-[17px] font-normal leading-[30px] text-[#232323]">
        {!! nl2br(e($insight->description)) !!}
      </div>

    </div>

    {{-- SIDEBAR --}}
    <aside class="bg-[#F8F8F8] p-6 rounded-xl h-fit">

      <p class="font-semibold text-lg mb-4">
        Insight Details
      </p>

      <p class="text-sm mb-2">
        <strong>Category:</strong>
        {{ $insight->category ?? 'General' }}
      </p>

      <p class="text-sm mb-2">
        <strong>Author:</strong>
        {{ $insight->author_name ?? 'TMN Team' }}
      </p>

      <p class="text-sm">
        <strong>Published:</strong>
        {{ optional($insight->publish_date)->format('d M Y') }}
      </p>

    </aside>

  </div>
</section>

<script src="https://unpkg.com/feather-icons"></script>
<script>
  feather.replace();
</script>

@include("user.components.footer")
