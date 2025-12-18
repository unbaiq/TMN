@include("user.components.meta")
@include("user.components.header")

    @php
        $assetBase = app()->environment('local')
            ? ''
            : config('app.url') . '/tmn/public';
    @endphp

<section class="bg-[url({{ config('app.url') }}/images/committee-banner.png)] bg-cover lg:bg-right bg-center bg-no-repeat">
  <div class="w-full py-10 h-full banner-grid">
    <div class="main-width h-full py-4 flex items-center lg:justify-start">
      <div class="w-full md:grid md:grid-cols-[58%,1fr] gap-6 items-center">
        <div>
          <p class="text-white lg:py-3 py-2 lg:text-[25px] text-[17px]">
            Path of Business networking and Growth
          </p>

          <div class="w-full">
            <span class="heading2 bg-primary text-white py-2 px-7">
              Our Partners
            </span>
          </div>

          <p class="text-white lg:py-3 py-2 lg:text-[19px] text-[16px] leading-[30px]">
            Building Stronger Networks Through Strategic Partnerships
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="bg-[#f2f2f2] py-10">
  <div class="main-width py-10 md:py-4">

    <div class="text-[#232323]">
      <p class="lg:text-[19px] text-[16px] leading-[30px]">
        At Top Management Network (TMN), we believe in the power of collaboration.
        Our partners play a crucial role in creating an ecosystem that fosters
        innovation, leadership, and professional growth.
      </p>

      <br>

      <span class="bg-primary text-white py-2 px-7 inline-block">
        Our Partners
      </span>

      <br><br>

      <p class="lg:text-[19px] text-[16px] leading-[30px]">
        If you’re looking to expand your influence, drive industry innovation,
        and connect with top professionals, TMN is the right platform for you.
      </p>
    </div>

    {{-- ================= PARTNERS GRID ================= --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6 items-center mt-10">

      @forelse($partners as $partner)
        <div
          class="rounded cursor-pointer hover:shadow h-[100px]
                 flex items-center justify-center transition-all duration-300
                 hover:bg-[#fff] transform hover:scale-105">

<<<<<<< HEAD
          <img src="{{ asset('storage/partners/' . $partner->logo) }}" alt="{{ $partner->name }}">
=======
          <img
  src="{{ $partner->logo
      ? asset('storage/' . $partner->logo)
      : asset('images/default-partner.png') }}"
  class="object-contain w-[60%] mx-auto"
  alt="{{ $partner->company_name ?? $partner->name }}">
>>>>>>> 1caa59e245dfda52e8d16d77c81c7da63fcaef0b

        </div>
      @empty
        <p class="col-span-full text-center text-gray-500">
          No partners available.
        </p>
      @endforelse

    </div>
  </div>
</section>

@include("user.components.footer")
