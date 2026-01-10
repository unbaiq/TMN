@include("user.components.meta")
@include("user.components.header")

@php
  $assetBase = app()->environment('local')
    ? ''
    : config('app.url') . '/tmn/public';
@endphp
     <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <section
      class="bg-[url(images/committee-banner.png)] bg-cover lg:bg-right bg-center bg-no-repeat"
    > <div class="w-full py-10 h-full banner-grid"> 
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
              Build Your Brand
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
    
    <section class="mt-10 ">
        <div class="main-width grid grid-cols-2 items-center py-2 ">
            <div>
                <h2 class="text-[30px] leading-[40px] font-semibold text-[#232323]">
                    Do You Need Best Help For Business Corporating Related Issues !
                </h2>
                <p class="lg:py-3 py-2 lg:text-[19px] text-[16px] font-normal lg:leading-[30px]">
                    Welcome to TMN and be a part of TMNIAN Family. TMN is a platform of CXO's where we all come together to form a network of like minded professionals to support / help each other to grow. A Platform where competition can be dealt with sheer competence and work as a mentor for others to follow. 
                </p>
                
                <hr class="mt-4 border border-[#CF2031]">
              
    <div x-data="{ open: false }">

    {{-- FREE CONSULTATION BUTTON --}}
    <div class="mt-4">
        <span
            @click="open = true"
            class="font-medium text-[20px] border text-white bg-primary rounded
                   transition-all duration-300 hover:bg-white hover:border-[#CF2031]
                   hover:text-[#CF2031] cursor-pointer px-4 py-3 inline-block">
            FREE CONSULTATION
        </span>
    </div>

    {{-- MODAL OVERLAY --}}
    <div
        x-show="open"
        x-transition.opacity
        class="fixed inset-0 z-50 bg-black/60 flex items-center justify-center"
        style="display: none;"
    >

        {{-- MODAL CARD --}}
        <div
            @click.away="open = false"
            x-transition.scale
            class="bg-white w-full max-w-lg rounded-2xl shadow-2xl overflow-hidden"
        >

            {{-- HEADER --}}
            <div class="bg-red-600 text-white px-6 py-4 flex justify-between items-center">
                <div>
                    <h3 class="text-xl font-semibold">Free Consultation Inquiry</h3>
                    <p class="text-sm text-red-100">
                        Get expert guidance for your business growth journey
                    </p>
                </div>

                <button
                    @click="open = false"
                    class="w-8 h-8 bg-white text-red-600 rounded-full
                           flex items-center justify-center font-bold">
                    ✕
                </button>
            </div>

            {{-- FORM --}}
           <form method="POST"
      action="{{ route('consultation.request.store') }}"
      class="p-6 space-y-4">

    @csrf

    {{-- NAME --}}
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="text-xs font-semibold">FIRST NAME</label>
            <input
                type="text"
                name="first_name"
                value="{{ old('first_name') }}"
                placeholder="Jane"
                required
                class="w-full mt-1 border rounded px-3 py-2 bg-gray-50
                       focus:ring-1 focus:ring-red-600 focus:border-red-600">
            @error('first_name')
                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="text-xs font-semibold">LAST NAME</label>
            <input
                type="text"
                name="last_name"
                value="{{ old('last_name') }}"
                placeholder="Doe"
                required
                class="w-full mt-1 border rounded px-3 py-2 bg-gray-50
                       focus:ring-1 focus:ring-red-600 focus:border-red-600">
            @error('last_name')
                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    {{-- EMAIL --}}
    <div>
        <label class="text-xs font-semibold">EMAIL</label>
        <input
            type="email"
            name="email"
            value="{{ old('email') }}"
            placeholder="Enter your email"
            required
            class="w-full mt-1 border rounded px-3 py-2 bg-gray-50
                   focus:ring-1 focus:ring-red-600 focus:border-red-600">
        <p class="text-xs text-gray-500 mt-1">
            We'll use this to send consultation details
        </p>
        @error('email')
            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- PHONE --}}
    <div>
        <label class="text-xs font-semibold">PHONE</label>
        <input
            type="text"
            name="phone"
            value="{{ old('phone') }}"
            placeholder="Enter your phone number"
            class="w-full mt-1 border rounded px-3 py-2 bg-gray-50
                   focus:ring-1 focus:ring-red-600 focus:border-red-600">
        @error('phone')
            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- CITY + ZIP --}}
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="text-xs font-semibold">CITY</label>
            <input
                type="text"
                name="city"
                value="{{ old('city') }}"
                placeholder="Your city"
                class="w-full mt-1 border rounded px-3 py-2 bg-gray-50
                       focus:ring-1 focus:ring-red-600 focus:border-red-600">
        </div>

        <div>
            <label class="text-xs font-semibold">ZIP CODE</label>
            <input
                type="text"
                name="zip_code"
                value="{{ old('zip_code') }}"
                placeholder="201301"
                class="w-full mt-1 border rounded px-3 py-2 bg-gray-50
                       focus:ring-1 focus:ring-red-600 focus:border-red-600">
        </div>
    </div>

    {{-- SUBMIT --}}
    <button
        type="submit"
        class="w-full mt-4 bg-red-600 hover:bg-red-700
               text-white py-3 rounded font-semibold transition">
        Request Free Consultation
    </button>

</form>

        </div>
    </div>
</div>
            </div>
        <style>
    .testimonial-container {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        overflow-y:clip;

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
        padding: 20px;
        background: #fff;
        text-align: center;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin: 5px 0;
        transition: all 0.5s ease;
        transform: translateX(0);
    }
    .center {
        background: #d32f2f !important;
        color: white;
        transform: translateX(-50px);
    }
</style>

<div class="testimonial-container overflow-y-hidden w-[70%] h-[440px]  mx-auto ">
    <div class="testimonial-slider" id="slider">
        <div class="testimonial p-2 grid grid-cols-[90px,1fr] items-center">
            <div>
                <div class="w-[80px] h-[80px] rounded-full">
                    <img src="https://images.ctfassets.net/lh3zuq09vnm2/yBDals8aU8RWtb0xLnPkI/19b391bda8f43e16e64d40b55561e5cd/How_tracking_user_behavior_on_your_website_can_improve_customer_experience.png" class="h-full w-full rounded-full bg-cover">
                </div>
            </div>
            <div>
                <p class="text-left">
                    Welcome to TMN and be a part of TMNIAN Family. TMN is a platform of CXOs.
                </p>
            </div>
        </div>
        <div class="testimonial p-2 grid grid-cols-[90px,1fr] items-center">
            <div>
                <div class="w-[80px] h-[80px] rounded-full">
                    <img src="https://images.ctfassets.net/lh3zuq09vnm2/yBDals8aU8RWtb0xLnPkI/19b391bda8f43e16e64d40b55561e5cd/How_tracking_user_behavior_on_your_website_can_improve_customer_experience.png" class="h-full w-full rounded-full bg-cover">
                </div>
            </div>
            <div>
                <p class="text-left">
                    TMN is a powerful networking platform connecting professionals across industries for mutual growth and opportunities.
                </p>
            </div>
        </div>
        <div class="testimonial p-2 grid grid-cols-[90px,1fr] items-center">
            <div>
                <div class="w-[80px] h-[80px] rounded-full">
                    <img src="https://images.ctfassets.net/lh3zuq09vnm2/yBDals8aU8RWtb0xLnPkI/19b391bda8f43e16e64d40b55561e5cd/How_tracking_user_behavior_on_your_website_can_improve_customer_experience.png" class="h-full w-full rounded-full bg-cover">
                </div>
            </div>
            <div>
                <p class="text-left">
                    Join TMN today and leverage the power of a strong professional network to elevate your career!
                </p>
            </div>
        </div>
           <div class="testimonial p-2 grid grid-cols-[90px,1fr] items-center">
            <div>
                <div class="w-[80px] h-[80px] rounded-full">
                    <img src="https://images.ctfassets.net/lh3zuq09vnm2/yBDals8aU8RWtb0xLnPkI/19b391bda8f43e16e64d40b55561e5cd/How_tracking_user_behavior_on_your_website_can_improve_customer_experience.png" class="h-full w-full rounded-full bg-cover">
                </div>
            </div>
            <div>
                <p class="text-left">
                    Welcome to TMN and be a part of TMNIAN Family. TMN is a platform of CXOs.
                </p>
            </div>
        </div>
        <div class="testimonial p-2 grid grid-cols-[90px,1fr] items-center">
            <div>
                <div class="w-[80px] h-[80px] rounded-full">
                    <img src="https://images.ctfassets.net/lh3zuq09vnm2/yBDals8aU8RWtb0xLnPkI/19b391bda8f43e16e64d40b55561e5cd/How_tracking_user_behavior_on_your_website_can_improve_customer_experience.png" class="h-full w-full rounded-full bg-cover">
                </div>
            </div>
            <div>
                <p class="text-left">
                    TMN is a powerful networking platform connecting professionals across industries for mutual growth and opportunities.
                </p>
            </div>
        </div>
        <div class="testimonial p-2 grid grid-cols-[90px,1fr] items-center">
            <div>
                <div class="w-[80px] h-[80px] rounded-full">
                    <img src="https://images.ctfassets.net/lh3zuq09vnm2/yBDals8aU8RWtb0xLnPkI/19b391bda8f43e16e64d40b55561e5cd/How_tracking_user_behavior_on_your_website_can_improve_customer_experience.png" class="h-full w-full rounded-full bg-cover">
                </div>
            </div>
            <div>
                <p class="text-left">
                    Join TMN today and leverage the power of a strong professional network to elevate your career!
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    const slider = document.getElementById("slider");
    let index = 0;

    function updateSlider() {
        let allTestimonials = document.querySelectorAll(".testimonial");
        let total = allTestimonials.length;

        allTestimonials.forEach((t, i) => {
            t.classList.remove("center");
            t.style.transform = "translateX(0)";
        });

        let activeIndex = index % total;
        allTestimonials[activeIndex].classList.add("center");
        allTestimonials[activeIndex].style.transform = "translateX(-50px)";

        slider.style.transform = `translateY(-${activeIndex * 140}px)`;
    }

    function autoScroll() {
        index++;
        updateSlider();
    }

    setInterval(autoScroll, 3000);
    updateSlider(); 
</script>


        </div>
        
    </section>

  
    @include("user.components.footer")    
    
    