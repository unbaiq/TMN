@php use Illuminate\Support\Str; @endphp

@include("user.components.meta")
@include("user.components.header")

<section
  class="bg-[url(images/committee-banner.png)] bg-cover lg:bg-right bg-center bg-no-repeat"
>
  <div class="w-full py-10 h-full banner-grid">
    <div class="main-width h-full py-4 flex items-center lg:justify-start">
      <div class="grid md:grid-cols-[58%,1fr] gap-6 items-center">
        <div>
          <p class="text-white py-2 text-[17px] lg:text-[25px] font-normal leading-[25px]">
            Path to Business Growth.
          </p>

          <div class="w-full">
            <span class="heading2 bg-primary text-white py-2 px-7 inline-block">
              Build Your Brand
            </span>
          </div>

          <p class="text-white py-2 text-[16px] lg:text-[19px] font-normal leading-[28px] lg:leading-[30px]">
            Have a question or need more information? Whether you're interested in membership,
            learning about Chapters, or exploring franchise opportunities, we're here to help.
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="py-10">
  <div class="main-width grid grid-cols-1 lg:grid-cols-2 items-center gap-10 py-2">

    {{-- LEFT CONTENT --}}
    <div>
      <h2 class="text-[24px] lg:text-[30px] leading-[34px] lg:leading-[40px] font-semibold text-[#232323]">
        Do You Need Best Help For Business Corporating Related Issues !
      </h2>

      <p class="py-2 text-[16px] lg:text-[19px] font-normal leading-[28px] lg:leading-[30px]">
        Welcome to TMN and be a part of TMNIAN Family. TMN is a platform of CXO's where we all
        come together to form a network of like minded professionals.
      </p>

      <hr class="mt-4 border border-[#CF2031]">

      <div class="mt-6">
        <span
          class="inline-block font-medium text-[16px] lg:text-[20px]
                 border text-white bg-primary rounded
                 transition-all duration-700 hover:bg-white hover:border-[#CF2031]
                 hover:text-[#CF2031] cursor-pointer px-4 py-3">
          FREE CONSULTATION
        </span>
      </div>
    </div>

    {{-- ================= TESTIMONIAL SLIDER ================= --}}
    <style>
      .testimonial-container {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        overflow-y: clip;
      }
      .testimonial-slider {
        display: flex;
        flex-direction: column;
        align-items: center;
        transition: transform 0.5s ease-in-out;
      }
      .testimonial {
        flex: 0 0 130px;
        width: 100%;
        padding: 16px;
        background: #fff;
        text-align: center;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        margin: 6px 0;
        transition: all 0.5s ease;
      }
      .center {
        background: #d32f2f !important;
        color: white;
        transform: translateX(-30px);
      }

      @media (max-width: 768px) {
        .center {
          transform: translateX(0);
        }
      }
    </style>

    <div class="testimonial-container overflow-y-hidden w-full sm:w-[90%] lg:w-[70%] h-[380px] lg:h-[440px] mx-auto">
      <div class="testimonial-slider" id="slider">

        @forelse($testimonials as $consultation)
          <div class="testimonial grid grid-cols-[70px,1fr] sm:grid-cols-[90px,1fr] gap-3 items-center">

            <div class="flex justify-center">
              <div class="w-[60px] h-[60px] sm:w-[80px] sm:h-[80px] rounded-full overflow-hidden">
                <img
                  src="{{ $consultation->consultant?->profile_photo_url ?? asset('images/default-user.png') }}"
                  class="h-full w-full rounded-full object-cover"
                  alt="{{ $consultation->consultant_display }}">
              </div>
            </div>

            <div>
              <p class="text-left text-[14px] sm:text-[16px]">
                {{ Str::limit($consultation->description, 120) }}
              </p>

              <p class="text-left mt-1 text-sm font-medium">
                {{ $consultation->consultant_display }}
              </p>
            </div>

          </div>
        @empty
          <div class="testimonial">
            <p>No testimonials available.</p>
          </div>
        @endforelse

      </div>
    </div>

    <script>
      const slider = document.getElementById("slider");
      let index = 0;

      function updateSlider() {
        let allTestimonials = document.querySelectorAll(".testimonial");
        let total = allTestimonials.length;

        allTestimonials.forEach(t => {
          t.classList.remove("center");
          t.style.transform = "translateX(0)";
        });

        if (total === 0) return;

        let activeIndex = index % total;
        allTestimonials[activeIndex].classList.add("center");
        slider.style.transform = `translateY(-${activeIndex * 140}px)`;
      }

      setInterval(() => {
        index++;
        updateSlider();
      }, 3000);

      updateSlider();
    </script>

  </div>
</section>

@include("user.components.footer")
