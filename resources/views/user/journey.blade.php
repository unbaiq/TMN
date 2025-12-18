<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Top Management Network | Enquiry</title>
    <link rel="stylesheet" href="{{ asset('{{ config('app.url') }}/tmn/public/css/base.css') }}" />
    <link rel="shortcut icon" href="{{ asset('{{ config('app.url') }}/tmn/public/images/favicon.png') }}" type="image/x-icon" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/splidejs/4.1.4/css/splide.min.css" rel="stylesheet">
  </head>

  <body>
    @include('user.components.header')

    <div class="progress-container">
      <div class="progress-bar" id="progressBar"></div>
    </div>

    <style>
      .progress-container {
        width: 100%;
        height: 6px;
        background: #eee;
        margin-bottom: 2rem;
      }
      .progress-bar {
        height: 100%;
        background: #CF2031;
        transition: width 0.3s ease;
      }
      .step {
        opacity: 0;
        transform: translateX(20px);
        transition: opacity 0.3s ease, transform 0.3s ease;
        position: absolute;
        visibility: hidden;
      }
      .step.active {
        opacity: 1;
        transform: translateX(0);
        visibility: visible;
      }
    </style>

    <section class="pb-20 mb-10">
      <div class="main-width lg:py-10">
        <div class="grid xl:grid-cols-[50%,1fr] grid-cols-1 items-start lg:gap-10 gap-9">

          <!-- LEFT: FORM -->
          <div class="xl:order-1 order-2 relative p-10">
            @if(session('success'))
              <div class="p-3 mb-4 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
              </div>
            @endif

            <form method="POST" action="{{ route('enquiry.submit') }}" id="enquiryForm">
              @csrf

              <!-- STEP 1 -->
              <div class="step active" data-step="1">
                <h1 class="lg:text-[50px] md:text-[40px] text-[25px] font-semibold leading-[35px] lg:mb-16">
                  Start your <span class="text-[#CF2031]">TMNians Journey</span>
                </h1>
                <h2 class="text-[#78818A] lg:text-[45px] md:text-[25px] text-[23px] font-medium leading-[35px] lg:pb-6 pb-4">
                  Please type <span class="text-[#000] font-semibold">your name</span>
                </h2>

                <div class="flex items-center gap-2">
                  <input type="text" name="name" id="name" required
                         class="border rounded-[5px] md:w-[320px] w-[270px] lg:w-[550px] h-[60px] px-4 bg-white outline-none shadow-[0px_4px_10px_rgba(81,81,81,0.25)]"
                         placeholder="Your Name">
                  <button type="button"
                          class="next-btn bg-black flex items-center justify-center w-[70px] h-[60px] rounded-[5px] text-white text-[25px]"
                          onclick="nextStep(2)">
                    <i class="fa-solid fa-arrow-right"></i>
                  </button>
                </div>

                <div class="py-4 flex items-center gap-4 text-sm mt-4">
                  <input type="checkbox" name="is_agreed" id="is_agreed" required class="w-[20px] h-[20px]">
                  <span>
                    I agree to be contacted by <span class="font-semibold">TMN</span> according to the
                    <span class="text-[#CF2031] font-bold">Privacy Policy</span> and
                    <span class="text-[#CF2031] font-bold">Terms & Conditions</span>.
                  </span>
                </div>
              </div>

              <!-- STEP 2 -->
              <div class="step" data-step="2">
                <h2 class="text-[#78818A] lg:text-[45px] md:text-[25px] text-[23px] font-medium leading-[35px] lg:pb-6 pb-4">
                  Enter your <span class="text-[#000] font-semibold">email address</span>
                </h2>
                <div class="flex items-center gap-2">
                  <input type="email" name="email" id="email"
                         class="border rounded-[5px] md:w-[320px] w-[270px] lg:w-[550px] h-[60px] px-4 bg-white outline-none shadow-[0px_4px_10px_rgba(81,81,81,0.25)]"
                         placeholder="Your Email Address" required>
                  <button type="button"
                          class="next-btn bg-black flex items-center justify-center w-[70px] h-[60px] rounded-[5px] text-white text-[25px]"
                          onclick="nextStep(3)">
                    <i class="fa-solid fa-arrow-right"></i>
                  </button>
                </div>
              </div>

              <!-- STEP 3 -->
              <div class="step" data-step="3">
                <h2 class="text-[#78818A] lg:text-[45px] md:text-[25px] text-[23px] font-medium leading-[35px] lg:pb-6 pb-4">
                  What’s your <span class="text-[#000] font-semibold">contact number?</span>
                </h2>
                <div class="flex items-center gap-2">
                  <input type="text" name="contact_number" id="contact" maxlength="15"
                         class="border rounded-[5px] md:w-[320px] w-[270px] lg:w-[550px] h-[60px] px-4 bg-white outline-none shadow-[0px_4px_10px_rgba(81,81,81,0.25)]"
                         placeholder="Your Contact Number" required>
                  <button type="button"
                          class="next-btn bg-black flex items-center justify-center w-[70px] h-[60px] rounded-[5px] text-white text-[25px]"
                          onclick="nextStep(4)">
                    <i class="fa-solid fa-arrow-right"></i>
                  </button>
                </div>
              </div>

              <!-- STEP 4 -->
              <div class="step" data-step="4">
                <h2 class="text-[#78818A] lg:text-[45px] md:text-[25px] text-[23px] font-medium leading-[35px] lg:pb-6 pb-4">
                  What’s your <span class="text-[#000] font-semibold">profession?</span>
                </h2>
                <div class="flex items-center gap-2">
                  <input type="text" name="profession" id="profession"
                         class="border rounded-[5px] md:w-[320px] w-[270px] lg:w-[500px] h-[60px] px-4 bg-white outline-none shadow-[0px_4px_10px_rgba(81,81,81,0.25)]"
                         placeholder="Your Profession" required>
                  <button type="submit"
                          class="submit-btn bg-[#CF2031] py-2 px-6 h-[60px] rounded-[5px] text-white text-[20px] hover:bg-[#b81a28]">
                    Submit
                  </button>
                </div>
              </div>
            </form>
          </div>

          <!-- RIGHT: INFO PANEL -->
          <div class="xl:order-2 order-1 bg-[#f8f8f8] p-6 rounded">
            <div class="grid grid-cols-2">
              <div>
                <img src="{{ asset('images/image.png') }}" class="w-[65%] mx-auto" alt="BNI Member">
              </div>
              <div>
                <p class="leading-[25px] text-gray-700">
                  BNI is a great investment and we’ll continue our membership for years to come! 
                  Highly recommended for businesses wanting to grow and learn.
                </p>
                <p class="font-bold pt-6">Avinash Handoo</p>
                <p class="text-[#CF2031] font-medium">25+ Years Experience</p>
              </div>
            </div>

            <div class="pt-6 grid grid-cols-3 text-center mt-8 border-t border-gray-300">
              <div class="p-2 border-r">
                <h2 class="text-[30px] text-[#CF2031] font-light">1000+</h2>
                <p class="text-gray-600 text-sm">Members</p>
              </div>
              <div class="p-2 border-r">
                <h2 class="text-[30px] text-[#CF2031] font-light">28+</h2>
                <p class="text-gray-600 text-sm">Chapters</p>
              </div>
              <div class="p-2">
                <h2 class="text-[30px] text-[#CF2031] font-light">₹500CR</h2>
                <p class="text-gray-600 text-sm">Expected Business Network</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    @include('user.components.footer')

    <script>
      let currentStep = 1;
      const totalSteps = 4;

      window.onload = () => updateProgress();

      function nextStep(step) {
        if (!validateStep(currentStep)) return;
        document.querySelector(`[data-step="${currentStep}"]`).classList.remove('active');
        currentStep = step;
        updateProgress();
        document.querySelector(`[data-step="${step}"]`).classList.add('active');
      }

      function updateProgress() {
        const progress = (currentStep / totalSteps) * 100;
        document.getElementById('progressBar').style.width = `${progress}%`;
      }

      function validateStep(step) {
        const inputs = {
          1: document.getElementById('name'),
          2: document.getElementById('email'),
          3: document.getElementById('contact'),
          4: document.getElementById('profession'),
        };
        const value = inputs[step].value.trim();
        if (!value) {
          alert('Please fill this field before proceeding.');
          return false;
        }
        return true;
      }
    </script>
  </body>
</html>
