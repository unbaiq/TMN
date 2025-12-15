@include("user.components.meta")
@include("user.components.header")

<section class="bg-[url(images/committee-banner.png)] bg-cover lg:bg-right bg-center bg-no-repeat">
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
            Have a question or need more information? Whether you're interested in membership, learning about Chapters, or exploring franchise opportunities, we're here to help. Reach out, and our team will connect you with the right resources.
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="py-10 text-[#232323] bg-[#f2f2f2]">
  <div class="main-width">
    <div class="grid grid-cols-[65%,1fr] gap-8">
      <!-- LEFT COLUMN -->
      <div>
        <!-- Static Story Cards -->
        <div class="bg-white shadow border mt-10">
          <div class="relative bg-white">
            <div class="clip-design">
              <img src="https://goodmockups.com/wp-content/uploads/2021/02/Free-Corporate-Building-3D-Logo-Mockup-PSD.jpg" class="w-full h-full" alt="">
            </div>
            <div class="absolute bottom-2 pl-10 pt-8">
              <div class="mb-[2px]">
                <span class="text-sm">December 10th, 2025</span>
              </div>
              <span class="text-[#CF2031]">John Doe</span>
            </div>
          </div>
          <div class="px-8 pb-8">
            <h2 class="text-[#232323] font-medium text-[35px]">The Future of Business Networking</h2>
            <p class="text-[16px] font-normal lg:leading-[30px]">
              Discover how modern entrepreneurs are leveraging networks like BNI to accelerate business growth and unlock new opportunities globally.
            </p>
            <div class="py-4 mt-4">
              <a href="#"><span class="bg-red-600 rounded shadow text-white px-4 py-2 text-[17px]">Continue Reading...</span></a>
            </div>
            <div class="flex items-center gap-2 mt-3">
              <div class="border-red-600 border flex items-center justify-center w-[40px] h-[40px] rounded-full text-[#CF2031] hover:bg-[#CF2031] hover:text-white transition-all cursor-pointer"><i class="fa-brands fa-facebook-f"></i></div>
              <div class="border-red-600 border flex items-center justify-center w-[40px] h-[40px] rounded-full text-[#CF2031] hover:bg-[#CF2031] hover:text-white transition-all cursor-pointer"><i class="fa-brands fa-instagram"></i></div>
              <div class="border-red-600 border flex items-center justify-center w-[40px] h-[40px] rounded-full text-[#CF2031] hover:bg-[#CF2031] hover:text-white transition-all cursor-pointer"><i class="fa-brands fa-x-twitter"></i></div>
              <div class="border-red-600 border flex items-center justify-center w-[40px] h-[40px] rounded-full text-[#CF2031] hover:bg-[#CF2031] hover:text-white transition-all cursor-pointer"><i class="fa fa-envelope"></i></div>
            </div>
          </div>
        </div>

        <!-- Second Static Story -->
        <div class="bg-white shadow border mt-10">
          <div class="relative bg-white">
            <div class="clip-design">
              <img src="https://static.vecteezy.com/system/resources/thumbnails/044/825/424/small/pattern-of-office-buildings-windows-illuminated-at-night-glass-architecture-corporate-building-at-night-business-concept-photo.JPG" class="w-full h-full" alt="">
            </div>
            <div class="absolute bottom-2 pl-10 pt-8">
              <div class="mb-[2px]">
                <span class="text-sm">December 5th, 2025</span>
              </div>
              <span class="text-[#CF2031]">Jane Smith</span>
            </div>
          </div>
          <div class="px-8 pb-8">
            <h2 class="text-[#232323] font-medium text-[35px]">Empowering Local Entrepreneurs</h2>
            <p class="text-[16px] font-normal lg:leading-[30px]">
              How small businesses are collaborating within communities to scale and grow together through structured referral systems.
            </p>
            <div class="py-4 mt-4">
              <a href="#"><span class="bg-red-600 rounded shadow text-white px-4 py-2 text-[17px]">Continue Reading...</span></a>
            </div>
            <div class="flex items-center gap-2 mt-3">
              <div class="border-red-600 border flex items-center justify-center w-[40px] h-[40px] rounded-full text-[#CF2031] hover:bg-[#CF2031] hover:text-white transition-all cursor-pointer"><i class="fa-brands fa-facebook-f"></i></div>
              <div class="border-red-600 border flex items-center justify-center w-[40px] h-[40px] rounded-full text-[#CF2031] hover:bg-[#CF2031] hover:text-white transition-all cursor-pointer"><i class="fa-brands fa-instagram"></i></div>
              <div class="border-red-600 border flex items-center justify-center w-[40px] h-[40px] rounded-full text-[#CF2031] hover:bg-[#CF2031] hover:text-white transition-all cursor-pointer"><i class="fa-brands fa-x-twitter"></i></div>
              <div class="border-red-600 border flex items-center justify-center w-[40px] h-[40px] rounded-full text-[#CF2031] hover:bg-[#CF2031] hover:text-white transition-all cursor-pointer"><i class="fa fa-envelope"></i></div>
            </div>
          </div>
        </div>

        <!-- Pagination (Static) -->
        <div class="pagination mt-8 text-center">
          <span>Page 1 of 3</span><br>
          <button class="bg-black text-white px-4 py-2 m-1">1</button>
          <button class="bg-red-400 text-white px-4 py-2 m-1">2</button>
          <button class="bg-black text-white px-4 py-2 m-1">3</button>
        </div>
      </div>

      <!-- RIGHT COLUMN -->
      <div>
        <div class="px-4">
          <h2 class="text-[#232323] font-normal text-[25px]">About TMN</h2>
          <hr class="w-[40%] border-[2px] mt-2 border-[#CF2031]">
          <p class="text-[#232323] pt-6">
            TMN is a business networking platform dedicated to helping professionals connect, collaborate, and grow. With decades of combined experience, we empower businesses to achieve sustainable success through meaningful connections.
          </p>
        </div>

        <!-- Social -->
        <div class="px-4 mt-14">
          <h2 class="text-[#232323] font-normal text-[25px]">Social</h2>
          <hr class="w-[20%] border-[2px] mt-2 border-[#CF2031]">
          <div class="flex items-center gap-2 mt-3">
            <div class="border-red-600 border flex items-center justify-center w-[40px] h-[40px] rounded-full text-[#CF2031] hover:bg-[#CF2031] hover:text-white transition-all cursor-pointer"><i class="fa-brands fa-facebook-f"></i></div>
            <div class="border-red-600 border flex items-center justify-center w-[40px] h-[40px] rounded-full text-[#CF2031] hover:bg-[#CF2031] hover:text-white transition-all cursor-pointer"><i class="fa-brands fa-instagram"></i></div>
            <div class="border-red-600 border flex items-center justify-center w-[40px] h-[40px] rounded-full text-[#CF2031] hover:bg-[#CF2031] hover:text-white transition-all cursor-pointer"><i class="fa-brands fa-twitter"></i></div>
            <div class="border-red-600 border flex items-center justify-center w-[40px] h-[40px] rounded-full text-[#CF2031] hover:bg-[#CF2031] hover:text-white transition-all cursor-pointer"><i class="fa-regular fa-envelope"></i></div>
            <div class="border-red-600 border flex items-center justify-center w-[40px] h-[40px] rounded-full text-[#CF2031] hover:bg-[#CF2031] hover:text-white transition-all cursor-pointer"><i class="fa-brands fa-youtube"></i></div>
          </div>
        </div>

        <!-- Latest Story -->
        <div class="px-4 mt-14">
          <h2 class="text-[#232323] font-normal text-[22px]">Latest Story</h2>
          <hr class="w-[20%] border-[2px] mt-2 border-[#CF2031]">
          <div class="mt-4 space-y-4">
            <div class="grid grid-cols-[100px,1fr] gap-4">
              <img src="https://goodmockups.com/wp-content/uploads/2021/02/Free-Corporate-Building-3D-Logo-Mockup-PSD.jpg" class="h-[90px] w-full object-cover" alt="">
              <div>
                <h4 class="text-[#232323] font-medium">The Rise of AI in Business Networking</h4>
                <p class="text-gray-600 py-1">December 12th, 2025</p>
              </div>
            </div>

            <div class="grid grid-cols-[100px,1fr] gap-4">
              <img src="https://static.vecteezy.com/system/resources/thumbnails/044/825/424/small/pattern-of-office-buildings-windows-illuminated-at-night.jpg" class="h-[90px] w-full object-cover" alt="">
              <div>
                <h4 class="text-[#232323] font-medium">Building Trust Through Referrals</h4>
                <p class="text-gray-600 py-1">December 10th, 2025</p>
              </div>
            </div>
          </div>
        </div>
      </div> <!-- RIGHT COLUMN END -->
    </div>
  </div>
</section>

<section class="py-14">
  <div class="main-width">
    <div class="mb-6">
      <h2 class="text-[#232323] font-semibold text-[30px]">Previous Story</h2>
    </div>
    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-10">
      <div class="h-[380px] border overflow-hidden rounded-xl shadow-xl w-[340px] relative cursor-pointer group">
        <img class="w-full h-full transition-all duration-700 transform group-hover:scale-110" src="https://img.evbuc.com/images/945485643/original.jpg" alt="">
        <div class="absolute bottom-0 bg-white w-full h-[120px] group-hover:h-[300px] duration-700 p-6">
          <div class="flex items-center justify-between">
            <span class="px-4 py-2 bg-red-600/10 text-red-600 text-sm rounded font-medium">Sunday</span>
            <span class="font-medium">Feb 09, 9:30 PM</span>
          </div>
          <h2 class="font-semibold py-4 text-[20px]">Live The Night</h2>
          <p class="text-sm">Join us for an unforgettable evening filled with energy, music, and connections.</p>
          <div class="mt-3">
            <a href="#"><span class="bg-red-600 text-white px-4 py-2 text-[13px]">Join Now</span></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@include("user.components.footer")
