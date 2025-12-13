<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Top management network</title>
    <link rel="stylesheet" href="css/base.css" />
    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon" />
    <script src="css/tailwindcss.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"  />
      <link href="https://cdnjs.cloudflare.com/ajax/libs/splidejs/4.1.4/css/splide.min.css" rel="stylesheet">
  </head>
  <body>
      <section>
          <div class="w-full   py-4 px-4 flex lg:flex-row flex-col items-center justify-between">
              <div class="">
                  <a href="./">
                  <img src="images/newlogo.png" ></a>
              </div>
              <div class=" flex md:items-center gap-4">
                <ul class="lg:space-x-8 flex md:flex-row flex-col  lg:text-[18px] text-[15px] lg:pt-0 pt-2  text-[#CF2031] font-semibold lg:text-[18px] text-[15px]">
                    <li class="flex items-center gap-2">
                    <i class="fa-solid fa-phone"></i>  &nbsp;   +91-9650381012

                    </li>
                    <li class="flex items-center gap-2">
                    <i class="fa-solid fa-envelope"></i> &nbsp;    support@topmanagementnetwork.com
                    </li>
                </ul>
              </div>
          </div>
       
          
          
      </section>
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

<section class="  pb-20 mb-10">
  <div class="main-width lg:py-10 ">
      <div class="mb-16">
 
      </div>
      <div class="grid xl:grid-cols-[50%,1fr] grid-cols-1 items-start lg:gap-2 gap-9">
          <div class="xl:order-1 order-2 mb-10  ">
              <div class="h-[300px] relative p-10">
         <form class="">
             
           <div class="step   active" data-step="1">
                    <h1 class="lg:text-[50px] md:text-[40px] text-[25px] font-semibold leading-[35px] lg:mb-20"> Start your <span class="text-[#CF2031] ">TMNians Journey</span></h1>
                 <h1 class="text-[#78818A] lg:text-[45px] md:text-[25px] text-[23px]  font-medium leading-[35px] lg:pb-6 pb-4">Please type <span class="text-[#000] font-semibold">in your name</span></h1>
                 <div class="flex items-center gap-2 ">
        <input type="text" placeholder="Your Name " class="border rounded-[5px] md:w-[320px] w-[270px] lg:w-[550px]  h-[60px] px-4 bg-white outline-none shadow-[0px_4px_10px_0px_rgba(81,81,81,0.25)] " id="name" required>
        <button class="next-btn bg-black flex items-center justify-center  w-[70px] h-[60px] rounded-[5px] text-white text-[25px]" onclick="nextStep(2)">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="34" viewBox="0 0 40 34" fill="none">
  <path d="M39.0545 14.6971L25.887 1.5296C25.5907 1.21781 25.2349 0.968462 24.8408 0.796259C24.4466 0.624056 24.0219 0.532476 23.5918 0.526912C23.1617 0.521347 22.7348 0.601912 22.3363 0.763861C21.9379 0.925809 21.5758 1.16587 21.2715 1.46989C20.9672 1.77392 20.7268 2.13576 20.5645 2.53412C20.4022 2.93247 20.3213 3.35927 20.3265 3.78939C20.3317 4.2195 20.4229 4.64423 20.5947 5.03855C20.7666 5.43288 21.0156 5.78882 21.3272 6.08542L29.1109 13.8571H3.22387C2.36885 13.8571 1.54884 14.1968 0.944251 14.8014C0.339657 15.406 0 16.226 0 17.081C0 17.936 0.339657 18.756 0.944251 19.3606C1.54884 19.9652 2.36885 20.3049 3.22387 20.3049H29.0389L21.3272 28.0286C20.7477 28.6382 20.4295 29.4502 20.4404 30.2912C20.4513 31.1322 20.7904 31.9356 21.3854 32.5301C21.9804 33.1246 22.7841 33.463 23.6251 33.4731C24.4662 33.4832 25.2778 33.1643 25.887 32.5844L39.0545 19.4169C39.3549 19.1183 39.593 18.763 39.7551 18.3716C39.9171 17.9802 39.9998 17.5606 39.9984 17.137C40.0005 17.1104 40.0005 17.0836 39.9984 17.057C40.0003 17.0304 40.0003 17.0036 39.9984 16.977C39.9981 16.122 39.6586 15.302 39.0545 14.6971Z" fill="white"/>
</svg></button>

</div>
<div class="p- py-4 flex items-center gap-4 text-sm">
    <input type="checkbox" class="w-[20px] h-[20px]" /><span>
        I agree to be contacted by <span class="font-semibold">TMN</span> according to the <span class="text-[#CF2031] font-bold">Privacy Policy</span> and <span class="text-[#CF2031] font-bold">Terms and Conditions</span>
    </span>
</div>
      </div>
           <div class="step" data-step="2">
                <h1 class="text-[#78818A] lg:text-[45px] md:text-[25px] text-[23px]  font-medium leading-[35px] lg:pb-6 pb-4">Enter your  <span class="text-[#000] font-semibold">email address</span></h1>
                <div class="flex items-center gap-2 ">
        <input type="email" class="border rounded-[5px] md:w-[320px] w-[270px] lg:w-[550px] py-4 px-4 bg-white outline-none shadow-[0px_4px_10px_0px_rgba(81,81,81,0.25)] "  placeholder="Your Email address" id="email" required>
        <button class="next-btn bg-black flex items-center justify-center  w-[70px] h-[60px] rounded-[5px] text-white text-[25px]" onclick="nextStep(3)">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="34" viewBox="0 0 40 34" fill="none">
  <path d="M39.0545 14.6971L25.887 1.5296C25.5907 1.21781 25.2349 0.968462 24.8408 0.796259C24.4466 0.624056 24.0219 0.532476 23.5918 0.526912C23.1617 0.521347 22.7348 0.601912 22.3363 0.763861C21.9379 0.925809 21.5758 1.16587 21.2715 1.46989C20.9672 1.77392 20.7268 2.13576 20.5645 2.53412C20.4022 2.93247 20.3213 3.35927 20.3265 3.78939C20.3317 4.2195 20.4229 4.64423 20.5947 5.03855C20.7666 5.43288 21.0156 5.78882 21.3272 6.08542L29.1109 13.8571H3.22387C2.36885 13.8571 1.54884 14.1968 0.944251 14.8014C0.339657 15.406 0 16.226 0 17.081C0 17.936 0.339657 18.756 0.944251 19.3606C1.54884 19.9652 2.36885 20.3049 3.22387 20.3049H29.0389L21.3272 28.0286C20.7477 28.6382 20.4295 29.4502 20.4404 30.2912C20.4513 31.1322 20.7904 31.9356 21.3854 32.5301C21.9804 33.1246 22.7841 33.463 23.6251 33.4731C24.4662 33.4832 25.2778 33.1643 25.887 32.5844L39.0545 19.4169C39.3549 19.1183 39.593 18.763 39.7551 18.3716C39.9171 17.9802 39.9998 17.5606 39.9984 17.137C40.0005 17.1104 40.0005 17.0836 39.9984 17.057C40.0003 17.0304 40.0003 17.0036 39.9984 16.977C39.9981 16.122 39.6586 15.302 39.0545 14.6971Z" fill="white"/>
</svg></button>
</div>
      </div>
           <div class="step   " data-step="3">
                <h1 class="text-[#78818A] lg:text-[45px] md:text-[25px] text-[23px]  font-medium leading-[35px] lg:pb-6 pb-4">What’s your <span class="text-[#000] font-semibold">contact number?</span></h1>
                <div class="flex items-center gap-2 ">
        <input type="number" maxlength="12" pattern="\d*"   class="border rounded-[5px] md:w-[320px] w-[270px] lg:w-[550px] py-4 px-4 bg-white outline-none shadow-[0px_4px_10px_0px_rgba(81,81,81,0.25)] "  placeholder="Your  Contact Number" id="contact" required>
         <button class="next-btn bg-black flex items-center justify-center  w-[70px] h-[60px] rounded-[5px] text-white text-[25px]" onclick="nextStep(4)">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="34" viewBox="0 0 40 34" fill="none">
  <path d="M39.0545 14.6971L25.887 1.5296C25.5907 1.21781 25.2349 0.968462 24.8408 0.796259C24.4466 0.624056 24.0219 0.532476 23.5918 0.526912C23.1617 0.521347 22.7348 0.601912 22.3363 0.763861C21.9379 0.925809 21.5758 1.16587 21.2715 1.46989C20.9672 1.77392 20.7268 2.13576 20.5645 2.53412C20.4022 2.93247 20.3213 3.35927 20.3265 3.78939C20.3317 4.2195 20.4229 4.64423 20.5947 5.03855C20.7666 5.43288 21.0156 5.78882 21.3272 6.08542L29.1109 13.8571H3.22387C2.36885 13.8571 1.54884 14.1968 0.944251 14.8014C0.339657 15.406 0 16.226 0 17.081C0 17.936 0.339657 18.756 0.944251 19.3606C1.54884 19.9652 2.36885 20.3049 3.22387 20.3049H29.0389L21.3272 28.0286C20.7477 28.6382 20.4295 29.4502 20.4404 30.2912C20.4513 31.1322 20.7904 31.9356 21.3854 32.5301C21.9804 33.1246 22.7841 33.463 23.6251 33.4731C24.4662 33.4832 25.2778 33.1643 25.887 32.5844L39.0545 19.4169C39.3549 19.1183 39.593 18.763 39.7551 18.3716C39.9171 17.9802 39.9998 17.5606 39.9984 17.137C40.0005 17.1104 40.0005 17.0836 39.9984 17.057C40.0003 17.0304 40.0003 17.0036 39.9984 16.977C39.9981 16.122 39.6586 15.302 39.0545 14.6971Z" fill="white"/>
</svg></button>
</div>
      </div>
           <div class="step  " data-step="4">
               <h1 class="text-[#78818A] lg:text-[45px] md:text-[25px] text-[23px] font-medium leading-[35px] lg:pb-6 pb-4">What’s your <span class="text-[#000] font-semibold"> profession?</span></h1>
               <div class="flex items-center gap-2 ">
           <input type="text" class="border  h-[60px] rounded-[5px] md:w-[320px] w-[270px] lg:w-[500px] py-4 px-4 bg-white outline-none shadow-[0px_4px_10px_0px_rgba(81,81,81,0.25)] "  placeholder="Your Profession" id="profession" required>
           <button class="submit-btn bg-black py-2  px-4 h-[60px] md:w-[110px] w-[83px] rounded-[5px] text-white lg:text-[20px]" onclick="submitForm()">Submit</button></div>
        </form>
      </div>
          </form>
          </div>
        </div>
         <div class="xl:order-2 order-1 bg-[#f8f8f8] p-6 rounded">
             <div class="grid grid-cols-2">
                 <div>
                     <img src="images/image.png" class="w-[65%] mx-auto">
                 </div>
                  <div>
                      <p class="leading-[25px]">
                          BNI is certainly a great investment, and we will continue our membership for many years to come! I would certainly recommend BNI to any business that wants to grow and learn lots of stuff along the way!
                      </p>
                      <p class="font-bold pt-6">
                          Avinash Handoo
                      </p>
                      <p class="text-[#CF2031] font-medium">
                          25+ Years Experience
                      </p>
                  </div>
             </div>
              <div class="pt-4 grid grid-cols-3 items-start mt-8">
            <div class="p-2 text-center border-r-2">
           
              <h2 class="md:heading2 text-[30px] text-primary !font-light">
               1000+
              </h2>
              <p
                class="md:text-[23px] text-[11px] font-light md:leading-[27px]"
              >
                Members
              </p>
            </div>
            <div class="flex items-center  justify-center lg:gap-6 gap-2 border-r-2">
          
              <div class="p-2">
                <h2 class="md:heading2 text-[30px] text-primary !font-light">
                 28 +
                </h2>
                <p
                  class="md:text-[23px] text-[11px] font-light md:leading-[27px]"
                >
                  Chapters 
                </p>
              </div>
            </div>
            <div class="flex items-center lg:gap-6 gap-2 ">
          
              <div class="p-2 text-center">
                <h2 class="md:heading2 text-[30px] text-primary !font-light">
                  ₹500CR
                </h2>
                <p
                  class="md:text-[23px] text-[11px] font-light md:leading-[27px]"
                >
                   Expected Business Network
                </p>
              </div>
            </div>
          </div>
         </div>
      </div>
  </div>
</section>
  <script>
    let currentStep = 1;
    const totalSteps = 4;
    window.onload = function() {
      updateProgress(); 
    };
    function nextStep(step) {
      if (!validateStep(currentStep)) return;
      const currentStepElement = document.querySelector(`[data-step="${currentStep}"]`);
      currentStepElement.classList.remove('active');
      currentStep = step;
      updateProgress();
      const nextStepElement = document.querySelector(`[data-step="${step}"]`);
      nextStepElement.classList.add('active');
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
        4: document.getElementById('profession')
      };
      const value = inputs[step].value.trim();
      if (!value) {
        alert('Please fill this field');
        return false;
      }
      return true;
    }
    function submitForm() {
      if (validateStep(4)) {
        alert('Form submitted successfully!');
      }
    }
  </script>


