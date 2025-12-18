   <header class="bg-white">
      <div class="main-width flex items-center justify-between pr-4 lg:pr-0">
        <div class="px-4 py-2">
            <a href="./">
          <img src="{{ config('app.url') }}/images/newlogo.png" class="xl:w-[180px] w-[120px]" /></a>
        </div>
        <div class="flex">
          <div class="py-6 lg:block hidden">
            <ul
              class="flex xl:space-x-6 lg:space-x-4   px-4 items-center xl:text-[14px] 2xl:text-[16px] lg:text-[11px]"
            >
              <li><a class="link" href="/">Home</a></li>
          
              <li><a class="link" href="/about" >Why TMN</a></li>
            
               <li class="relative group cursor-pointer">Program
     <ul
    class="absolute w-[200px] bg-white border rounded-lg shadow-md top-full left-0 p-4 opacity-0 translate-y-2 transition-all duration-300 ease-in-out group-hover:opacity-100 group-hover:translate-y-0 pointer-events-none group-hover:pointer-events-auto space-y-2"
  >
        <li class="px-4 py-1 rounded-2xl hover:bg-[#ababab]/10 inset-1"><a class="link"  href="/programs-meetup" >Meetups</a></li>
        <li class="px-4 py-1 rounded-2xl hover:bg-[#ababab]/10 inset-1"><a  class="link" href="/insightindex" >Insight</a></li>
   
    </ul>
</li>
              
            <li class="relative group cursor-pointer">
  Services
  <ul
    class="absolute w-[200px] bg-white border rounded-lg shadow-md top-full left-0 p-4 opacity-0 translate-y-2 transition-all duration-300 ease-in-out group-hover:opacity-100 group-hover:translate-y-0 pointer-events-none group-hover:pointer-events-auto space-y-2"
  >
    <li class="px-4 py-1 rounded-xl hover:bg-gray-100">
      <a class="link" href="/chapter">Chapter</a>
    </li>
    <li class="px-4 py-1 rounded-xl hover:bg-gray-100">
      <a class="link" href="/events">Events</a>
    </li>
    <li class="px-4 py-1 rounded-xl hover:bg-gray-100">
      <a class="link" href="/story">Story</a>
    </li>
    <li class="px-4 py-1 rounded-xl hover:bg-gray-100">
      <a class="link" href="/articles-new">Articles</a>
    </li>
    <li class="px-4 py-1 rounded-xl hover:bg-gray-100">
      <a class="link" href="/build-brand">Build Your Brand</a>
    </li>
  </ul>
</li>
  <li><a class="link" href="/advisory-committee">Advisory Panel</a></li>
             <li class="relative group cursor-pointer">Associations
     <ul
    class="absolute w-[200px] bg-white border rounded-lg shadow-md top-full left-0 p-4 opacity-0 translate-y-2 transition-all duration-300 ease-in-out group-hover:opacity-100 group-hover:translate-y-0 pointer-events-none group-hover:pointer-events-auto space-y-2"
  >
        <li class="px-4 py-1 rounded-2xl hover:bg-[#ababab]/10 inset-1"><a class="link"  href="/partners" >Partners</a></li>
        <li class="px-4 py-1 rounded-2xl hover:bg-[#ababab]/10 inset-1"><a  class="link" href="/sponsors" >Sponsors</a></li>
   
    </ul>
</li>
          
           
            
              <!-- <li>News</li>-->
              <!--<li>Associations</li>-->
              <!--<li>Careers</li>-->
             
              <li><a class="link" href="/contact">Contact Us</a></li>
            </ul>
          </div>
           <div class="menu-container lg:hidden block">
                      <button class="hamburger bg-transparent hover:bg-transparent" id="hamburger">
                          <span class="line"></span>
                          <span class="line"></span>
                          <span class="line"></span>
                      </button>
                  </div>
        <a href="/journey" class="bg-secondary w-[150px] lg:flex hidden items-center justify-center text-white xl:text-[16px] lg:text-[11px]" >  <div
            class="bg-secondary w-[150px] lg:flex hidden items-center justify-center text-white xl:text-[16px] lg:text-[11px]"
          >
            Join Now
          </div></a>
              <nav class="mobile-nav h-full py-4" id="mobileNav">
                  <!-- Close Hamburger in mobile menu -->
                  <button class="close-hamburger bg-white hover:bg-white" id="closeHamburger">
                      <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
                          <circle cx="20" cy="20" r="20" fill="white" />
                          <path
                              d="M24.2242 25.6414L19.8774 20.9285L15.7505 25.6414H13.8457L18.9983 19.9601L13.8457 14.3594H15.7505L20.0728 19.0562L24.2486 14.3594H26.1534L20.9519 20.0085L26.129 25.6414H24.2242Z"
                              fill="#313039" />
                      </svg>
                  </button>

                  <div class=" ml-4">
                      <a href="./">
                          <div class="">
                              <img src="{{ config('app.url') }}/tmn/public/images/logo.svg" class="w-1/3 object-cover" alt="Logo" />
                          </div>
                      </a>
                  </div>
                  <ul class="ml-2 mt-8 text-white">
                      <li class="border-b text-[16px] leading-[28px] font-medium px-3">
                          <a href="./">Home</a>
                      </li>
                      <li class="border-b text-[16px] leading-[28px] font-medium px-3">
                          <a href="#">Why TMN</a>
                      </li>
                      <li class="border-b text-[16px] leading-[28px] font-medium px-3">
                          <a href="about.php">About Us</a>
                      </li>
                      <li class="border-b text-[16px] leading-[28px] font-medium px-3">
                          <a href="#">Countries</a>
                      </li>
                      <li class="border-b text-[16px] leading-[28px] font-medium px-3">
                          <a href="#">Membership services</a>
                      </li>
                      <li class="border-b text-[16px] leading-[28px] font-medium px-3">
                          <a href="advisory-committee.php">Advisory Panel</a>
                      </li>
                      
                       <li class="border-b text-[16px] leading-[28px] font-medium px-3">
                          <a href="#">Partners</a>
                      </li>
                       <li class="border-b text-[16px] leading-[28px] font-medium px-3">
                          <a href="#">
Careers</a>
                      </li>
                       <li class="border-b text-[16px] leading-[28px] font-medium px-3">
                          <a href="#">News</a>
                      </li>
                      <li class="bg-white mt-10 text-center text-[#313039] text-[18px] font-medium">
                          <a href="contact.php" class="text-[#313039]">Contact Us</a>
                      </li>
                  </ul>

                  <div class="w-[88%] mx-auto mt-8 flex items-start flex-col gap-8">
                

                      <div class="flex items-center gap-4">
                          <p><i class="fa-solid fa-phone text-[25px]"></i></p>
                          <p class="flex flex-col">
                              <span>Call Us</span> <span>+91-00000000</span>
                          </p>
                      </div>
                  </div>
                  <div class="w-[86%] mx-auto mt-6">
                      <div>
                          <p class="font-semibold">Follow us on</p>
                          <p class="flex items-center gap-4 pt-2">
                              <span><i class="fa-brands fa-facebook text-xl"></i></span>
                              <span><i class="fa-brands fa-pinterest text-xl"></i></span>
                              <span><i class="fa-brands fa-instagram text-xl"></i></span>
                              <span><i class="fa-brands fa-x-twitter text-xl"></i></span>
                          </p>
                      </div>
                  </div>
              </nav>
              <script>
              const hamburger = document.getElementById("hamburger");
              const mobileNav = document.getElementById("mobileNav");
              const closeHamburger = document.getElementById("closeHamburger");

              // Toggle mobile menu open and close
              hamburger.addEventListener("click", () => {
                  hamburger.classList.toggle("active");
                  mobileNav.classList.toggle("active");
                  document.body.classList.toggle("nav-open"); // Disable body scroll
              });

              // Close mobile menu with close button
              closeHamburger.addEventListener("click", () => {
                  hamburger.classList.remove("active");
                  mobileNav.classList.remove("active");
                  document.body.classList.remove("nav-open"); // Enable body scroll
              });
              </script>
        </div>
      </div>
    </header>