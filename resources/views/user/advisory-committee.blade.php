@include("user.components.meta")
@include("user.components.header")
    <section
      class="bg-[url({{ config('app.url') }}/tmn/public/images/committee-banner.png)] bg-cover lg:bg-right bg-center bg-no-repeat"
    > <div class="w-full py-10 h-full banner-grid"> 
      <div class="main-width h-full py-4 flex items-center lg:justify-start">
        <div class="grid w-full md:grid-cols-[68%,1fr] gap-6 items-center">
          <div h-full>
            <p
              class="text-white lg:py-3 py-2 lg:text-[25px] text-[17px] font-normal lg:leading-[25px]"
            >
             Path of Business networking and Growth
            </p>
            <div class="w-full ">
              <span class="heading2 bg-primary text-white py-2 px-7">
              Advisory Committee
              </span>
            </div>
            <p
              class="text-white lg:py-3 py-2 lg:text-[19px] text-[16px] font-normal lg:leading-[30px]"
            >
             Meet the Experts Behind TMN’s Success
            </p>
          </div>
          
        </div>
      </div>
      </div>
    </section>
        <section class="pt-10 text-[#232323] bg-[#f2f2f2]">
        <div class="main-width">
        <p class="leading-[25px] text-[16px]">
            <span class="font-bold">Top Management Network</span> (TMN), we believe that great leadership thrives on expert guidance and strategic insights. Our Advisory Panel is composed of highly accomplished business leaders, industry veterans, and subject matter experts who bring unparalleled experience and wisdom to our network. These advisors play a pivotal role in mentoring entrepreneurs, executives, and professionals, helping them navigate challenges and achieve long-term growth.
           
            <br> <br>
<b><p>Meet Our Esteemed Advisors</p></b><br>
Our advisory board consists of renowned business leaders, successful entrepreneurs, corporate strategists, and financial experts. These professionals contribute their expertise to empower TMN members and guide them towards growth, profitability, and leadership excellence.
<br> <br>
Each advisor brings unique strengths, ranging from business development and financial planning to marketing strategies and operational efficiency. With their mentorship, TMN members can confidently make decisions that drive sustainable business success.
        </p>
        </div>
    
    </section>
    
   <section class="py-10 bg-[#f2f2f2]">
    <div class="main-width grid lg:grid-cols-2 gap-4 mt-4">

        @forelse($advisories as $advisory)

        <div class="grid xl:grid-cols-[30%,1fr] md:grid-cols-[50%,1fr] gap-2 transition-all duration-700 hover:shadow-md bg-white p-4">

            {{-- Image --}}
            <div class="w-full pt-4 text-center">
                <img
                    src="{{ $advisory->thumbnail_url }}"
                    alt="{{ $advisory->advisor_display }}"
                    class="w-[160px] h-[160px] rounded-full mx-auto object-cover"
                >

                <div class="w-[60%] mx-auto flex items-center justify-around py-2">
                    <span class="border-red-600 border flex items-center justify-center w-[40px] h-[40px] rounded-full text-[#CF2031] hover:bg-[#CF2031] hover:text-white transition">
                        <i class="fa-brands fa-linkedin-in"></i>
                    </span>
                    <span class="border-red-600 border flex items-center justify-center w-[40px] h-[40px] rounded-full text-[#CF2031] hover:bg-[#CF2031] hover:text-white transition">
                        <i class="fa-solid fa-share"></i>
                    </span>
                </div>
            </div>

            {{-- Content --}}
            <div class="p-2">
                <h2 class="text-[21px] font-bold leading-[25px]">
                    {{ $advisory->advisor_name }}
                </h2>

                <h4 class="text-[16px] font-normal leading-[25px]">
                    {{ $advisory->advisor_designation }}
                </h4>

                <p class="pt-4">
                    {{ Str::limit(strip_tags($advisory->short_description ?? $advisory->description), 180) }}
                </p>

                <a href="">
                    <p class="flex pt-4 items-center font-bold leading-[24px] text-primary">
                        Read More
                        <svg xmlns="http://www.w3.org/2000/svg" width="34" height="33" viewBox="0 0 34 33" fill="none">
                            <path d="M17.2123 16.7654H5.95288V18.6404H17.2123V21.4529L20.9529 17.7029L17.2123 13.9529V16.7654Z" fill="#CF2031"/>
                        </svg>
                    </p>
                </a>
            </div>

        </div>

        @empty
            <p class="col-span-2 text-center text-gray-500">
                No advisory committee members found.
            </p>
        @endforelse

    </div>
</section>


   @include("user.components.footer")