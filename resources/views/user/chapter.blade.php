@include("user.components.meta")
@include("user.components.header")

@php
  $assetBase = app()->environment('local')
    ? ''
    : config('app.url') . '/tmn/public';
@endphp

<section class="bg-[url({{ $assetBase }}/images/committee-banner.png)] bg-cover lg:bg-right bg-center bg-no-repeat">
  <div class="w-full py-10 h-full banner-grid">
    <div class="main-width h-full py-4 flex items-center lg:justify-start">
      <div class="grid md:grid-cols-[58%,1fr] gap-6 items-center">
        <div h-full>
          <p class="text-white lg:py-3 py-2 lg:text-[25px] text-[17px] font-normal lg:leading-[25px]">
            Path to Business Growth.
          </p>
          <div class="w-full ">
            <span class="heading2 bg-primary text-white py-2 px-7">
              Chapter
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
<section class="py-10">
  <div class="main-width">

    <h2 class="text-center text-[30px] font-medium pb-6">
      Search for Your State and City and join the chapter
    </h2>

    {{-- SEARCH FORM --}}
    <form method="GET" class="mb-6">
      <div class="grid md:grid-cols-2 gap-4">
        <input type="text" name="state" value="{{ request('state') }}" class="border rounded px-4 py-3 w-full"
          placeholder="Enter State" />

        <div class="flex gap-4">
          <input type="text" name="city" value="{{ request('city') }}" class="border rounded px-4 py-3 w-full"
            placeholder="Enter City" />

          <button class="bg-primary px-6 py-3 text-white rounded">
            Go
          </button>
        </div>
      </div>
    </form>

    {{-- TABLE --}}
    <div class="overflow-x-auto">
      <table class="w-full border border-collapse">
        <thead>
          <tr class="text-left">
            <th class="p-4 border">S.No.</th>
            <th class="p-4 border">State</th>
            <th class="p-4 border">City</th>
            <th class="p-4 border">Chapter Name</th>
            <th class="p-4 border">Action</th>
          </tr>
        </thead>

        <tbody>
          @forelse($chapters as $index => $chapter)
            <tr>
              <td class="p-4 border">
                {{ $chapters->firstItem() + $index }}
              </td>
              <td class="p-4 border">{{ $chapter->state }}</td>
              <td class="p-4 border">{{ $chapter->city }}</td>
              <td class="p-4 border">{{ $chapter->name }}</td>
              <td class="p-4 border">
                <a href="#">
                  <span class="px-6 py-2 bg-red-600 text-white rounded">
                    Apply
                  </span>
                </a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="p-6 text-center text-gray-500">
                No chapters found.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{-- PAGINATION --}}
    <div class="mt-6">
      {{ $chapters->links() }}
    </div>

  </div>
</section>
@include("user.components.footer")