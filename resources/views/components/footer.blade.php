<script src="https://cdnjs.cloudflare.com/ajax/libs/splidejs/4.1.4/js/splide.min.js" ></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        new Splide('#splide', {
            type: 'loop',
            perPage: 3,               
            focus: 'center',         
            autoplay: true,           
            interval: 3000,          
            flickMaxPages: 3,         
            updateOnMove: true,       
            pagination: false,        
            padding: '10%',             
            throttle: 300,            
            gap: '20px',               
            breakpoints: {
                1240: {
                    perPage: 2,        
                    padding: '0%',    
                    gap: '30px',       
                },
                1024: {
                    perPage: 1,   
                    padding: '20%',    
                    gap: '10px',       
                },
                768: {
                    perPage: 1,      
                    padding: '%',    
                    gap: '10px',       
                }
            }
        }).mount();
    });
</script>

<footer class="bg-[url(images/world-wallpaper.jpg)] bg-cover">
    <div class="bg-[rgba(35,35,35,0.90)]  w-full h-full">
    <div class="mx-auto main-width p-4 py-6 lg:py-8">
        <div>
            <div class="grid  grid-cols-1 gap-8 sm:gap-6 lg:grid-cols-[30%,1fr,1fr,1fr] md:grid-cols-2 items-start ">
                <div class="mb-6 md:mb-0">
                    <a href="./" class="flex items-center">
                       <img src="images/newlogo.png" class="w-1/2" alt="">
                    </a>
                    <p class="text-[#CFD3D7] mt-6 w-[70%]">
                       Welcome to TMN and be a part of TMNIAN Family. TMN is a platform of CXO's where we all come together to form a network of like minded professionals to support / help each other to grow. A Platform where competition can be dealt with sheer competence and work as a mentor for others to follow. 
                    </p>
                </div>
                <div class="">
                    <h2 class="mb-6 lg:mt-10 text-sm font-semibold text-[#fff] uppercase ">
                        Quick Links
                    </h2>
                    <ul class="text-[#CFD3D7] font-medium">
                        <li class="mb-4">
                            <a href="./" class="hover:underline">Home</a>
                        </li>
                        <li class="mb-4">
                            <a href="about.php " class="hover:underline">About Us</a>
                        </li>
                        <li class="mb-4">
                            <a href="carrers.php" class="hover:underline">Careers</a>
                        </li>
                        <li class="mb-4">
                            <a href="certificate.php" class="hover:underline">Certificate</a>
                        </li>
                        <li class="mb-4">
                            <a href="contact.php" class="hover:underline">Contact Us</a>
                        </li>
                    </ul>
                </div>
                 <div>
                    <h2 class="mb-6 lg:mt-10 text-sm font-semibold text-[#fff] uppercase">
                        Support Links
                    </h2>
                    <ul class=" text-[#CFD3D7] font-medium">
                        <li class="mb-4">
                            <a href="" class="hover:underline">Feedback </a>
                        </li>
                        <li class="mb-4">
                            <a href=" " class="hover:underline">About Us</a>
                        </li>
                        <li class="mb-4">
                            <a href="" class="hover:underline">Vigilance</a>
                        </li>
                        <li class="mb-4">
                            <a href=" " class="hover:underline">Website Policies </a>
                        </li>
                        <li class="mb-4">
                            <a href=" " class="hover:underline">Disclaimer</a>
                        </li>
                        <li class="mb-4">
                            <a href=" " class="hover:underline">FAQs</a>
                        </li>
                    </ul>
                </div> 
<style>
    /* Toast Message Style */
.toast {
    display: none;
    opacity: 0;
    transition: opacity 0.5s ease-in-out;
}

.toast.show {
    display: block;
    opacity: 1;
}

.toast {
    padding: 10px 20px;
    background-color: #28a745;
    color: #fff;
    border-radius: 5px;
    position: fixed;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 9999;
    font-size: 16px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}

</style>
                <div>
                    <h2 class="mb-6 lg:mt-10 text-sm font-semibold text-[#fff] uppercase ">
                        Social Media
                    </h2>
                    <ul class=" text-[#CFD3D7] font-medium">
    <!--                    <li class="mb-4">Your Email</a>-->
    <!--                    </li>-->
    <!--                    <li>-->
    <!--                        <div class="flex lg:items-center  w-full    mx-auto  gap-2 overflow-hidden ">-->
    <!--                             <form method="POST" action="" class="space-x-2 flex">-->
        <!-- Email Field -->
    <!--    <div class="w-full">-->
    <!--        <input type="email" required name="email_name" placeholder="Enter Your Email"-->
    <!--            class="flex-1 px-4 py-2 text-gray-300 lg:w-[300px] sm:w-[200px] w-[200px] bg-gray-700 outline-none placeholder-gray-400"-->
    <!--            value="<?php echo htmlspecialchars($emaila); ?>" />-->
     
    <!--    </div>-->

        <!-- Subscribe Button -->
    <!--    <button type="submit" name="subscribe_form"-->
    <!--        class="lg:px-6 px-3 py-2 bg-primary text-white font-semibold hover:bg-teal-700 transition-colors w-full">-->
    <!--        Subscribe-->
    <!--    </button>-->
    <!--</form>-->



    <!--                        </div>-->
    <!--                    </li>-->
                        <li class="flex  gap-4 mt-4 items-center ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <g clip-path="url(#clip0_33_954)">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M11.9623 0.36377C14.1257 0.388457 16.0802 0.920165 17.8256 1.95889C19.5503 2.97688 20.985 4.42031 21.9924 6.15114C23.0248 7.90712 23.5533 9.87341 23.5779 12.05C23.5166 15.0281 22.5773 17.5718 20.76 19.6808C18.9426 21.7899 16.615 23.0948 14.2055 23.595V15.2452H16.4835L16.9987 11.964H13.5493V9.81485C13.5301 9.36932 13.671 8.93164 13.9465 8.58095C14.2224 8.2293 14.7081 8.04448 15.4038 8.02648H17.4868V5.15218C17.4569 5.14256 17.1733 5.10454 16.636 5.0381C16.0267 4.96681 15.4139 4.92873 14.8004 4.92403C13.4119 4.93043 12.3137 5.32211 11.506 6.09906C10.6982 6.87579 10.2856 7.99956 10.2681 9.47035V11.964H7.64306V15.2452H10.2681V23.595C7.30955 23.0948 4.98197 21.7899 3.16463 19.6808C1.34728 17.5718 0.408002 15.0281 0.34668 12.05C0.371214 9.87331 0.899708 7.90702 1.93216 6.15114C2.93963 4.42031 4.3743 2.97689 6.09896 1.95889C7.84438 0.920365 9.79882 0.388657 11.9623 0.36377Z"
                                        fill="#CFD3D7" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_33_954">
                                        <rect width="24" height="24" fill="white" />
                                    </clipPath>
                                </defs>
                            </svg>
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30"
                                    fill="none">
                                    <path
                                        d="M27.0005 15.3596C27.1805 8.48961 21.6605 2.90961 14.8205 2.99961C8.2505 3.08961 2.9405 8.51961 3.0005 15.0896C3.0305 19.7996 5.7905 23.8496 9.7505 25.7996C9.9905 25.9196 10.2605 25.7396 10.2305 25.4696C10.2005 24.6896 10.2305 23.8796 10.3805 23.2196C10.5305 22.5596 11.1305 20.0396 11.5205 18.3896C11.7005 17.5796 11.7305 16.7396 11.5805 15.9296C11.5205 15.6596 11.4905 15.3596 11.4905 14.9996C11.4905 13.2296 12.5105 11.9096 13.8005 11.9096C14.8805 11.9096 15.4205 12.7196 15.4205 13.7096C15.4205 14.7896 14.7305 16.4396 14.3705 17.9696C14.0705 19.2296 15.0005 20.2796 16.2605 20.2796C18.5405 20.2796 20.2805 17.8796 20.2805 14.4296C20.2805 11.3696 18.0905 9.23961 14.9405 9.23961C11.3105 9.23961 9.1805 11.9696 9.1805 14.7896C9.1805 15.8996 9.6005 17.0696 10.1405 17.6996C10.2305 17.8196 10.2605 17.9396 10.2305 18.0596C10.1405 18.4496 9.9305 19.3196 9.8705 19.4996C9.8105 19.7396 9.6905 19.7696 9.4505 19.6796C7.8605 18.8996 6.8405 16.5596 6.8405 14.6996C6.8405 10.6796 9.7505 6.98961 15.2705 6.98961C19.6805 6.98961 23.1305 10.1396 23.1305 14.3696C23.1305 18.7796 20.3705 22.2896 16.5005 22.2896C15.4805 22.2896 14.5205 21.8696 13.9505 21.2996C13.7705 21.1196 13.4705 21.2096 13.4105 21.4496C13.2005 22.1996 12.9005 23.4596 12.7805 23.8496C12.6005 24.5696 12.2105 25.4096 11.7905 26.1596C11.6705 26.3396 11.7905 26.6096 12.0005 26.6396C12.9905 26.8796 14.0105 27.0296 15.0605 26.9996C21.4205 26.9396 26.8205 21.6596 27.0005 15.3596Z"
                                        fill="#CFD3D7" />
                                </svg>
                            </span>
                            <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
                                    <g clip-path="url(#clip0_33_961)">
                                        <path
                                            d="M12.2362 24.0001C12.1567 24.0001 12.0773 24.0001 11.9973 23.9998C10.116 24.0043 8.37781 23.9565 6.68738 23.8536C5.13757 23.7593 3.7229 23.2238 2.59607 22.3049C1.50879 21.4183 0.766296 20.2195 0.389282 18.7423C0.0611573 17.4561 0.0437622 16.1936 0.0270996 14.9725C0.0150146 14.0963 0.00256348 13.0581 0 12.0023C0.00256348 10.9421 0.0150146 9.90394 0.0270996 9.02778C0.0437622 7.80683 0.0611573 6.54432 0.389282 5.258C0.766296 3.78071 1.50879 2.58192 2.59607 1.69532C3.7229 0.776498 5.13757 0.240915 6.68756 0.146615C8.37799 0.0438932 10.1166 -0.00408039 12.0018 0.000497245C13.8836 -0.00353107 15.6213 0.0438932 17.3117 0.146615C18.8615 0.240915 20.2762 0.776498 21.403 1.69532C22.4905 2.58192 23.2328 3.78071 23.6098 5.258C23.9379 6.54414 23.9553 7.80683 23.972 9.02778C23.9841 9.90394 23.9967 10.9421 23.9991 11.9979V12.0023C23.9967 13.0581 23.9841 14.0963 23.972 14.9725C23.9553 16.1934 23.9381 17.4559 23.6098 18.7423C23.2328 20.2195 22.4905 21.4183 21.403 22.3049C20.2762 23.2238 18.8615 23.7593 17.3117 23.8536C15.6929 23.9522 14.0299 24.0001 12.2362 24.0001ZM11.9973 22.1248C13.8479 22.1292 15.5471 22.0825 17.1978 21.9821C18.3697 21.9109 19.3857 21.5306 20.2181 20.8518C20.9875 20.2243 21.5175 19.3586 21.793 18.2786C22.0662 17.208 22.082 16.0585 22.0972 14.9468C22.1091 14.0765 22.1215 13.0457 22.1241 12.0001C22.1215 10.9544 22.1091 9.92371 22.0972 9.05341C22.082 7.94178 22.0662 6.79224 21.793 5.72144C21.5175 4.64149 20.9875 3.77577 20.2181 3.14826C19.3857 2.46967 18.3697 2.08936 17.1978 2.01814C15.5471 1.91761 13.8479 1.87129 12.0016 1.87531C10.1514 1.87092 8.45196 1.91761 6.80127 2.01814C5.62939 2.08936 4.61334 2.46967 3.78094 3.14826C3.01154 3.77577 2.48163 4.64149 2.20605 5.72144C1.93286 6.79224 1.91711 7.9416 1.90192 9.05341C1.89001 9.92445 1.87756 10.9559 1.875 12.0023C1.87756 13.0442 1.89001 14.0758 1.90192 14.9468C1.91711 16.0585 1.93286 17.208 2.20605 18.2786C2.48163 19.3586 3.01154 20.2243 3.78094 20.8518C4.61334 21.5304 5.62939 21.9107 6.80127 21.9819C8.45196 22.0825 10.1517 22.1293 11.9973 22.1248ZM11.9526 17.8595C8.72186 17.8595 6.0932 15.231 6.0932 12.0001C6.0932 8.76923 8.72186 6.14076 11.9526 6.14076C15.1835 6.14076 17.8119 8.76923 17.8119 12.0001C17.8119 15.231 15.1835 17.8595 11.9526 17.8595ZM11.9526 8.01575C9.75567 8.01575 7.9682 9.80323 7.9682 12.0001C7.9682 14.197 9.75567 15.9845 11.9526 15.9845C14.1497 15.9845 15.9369 14.197 15.9369 12.0001C15.9369 9.80323 14.1497 8.01575 11.9526 8.01575ZM18.4682 4.26576C17.6916 4.26576 17.0619 4.89527 17.0619 5.67201C17.0619 6.44874 17.6916 7.07826 18.4682 7.07826C19.2449 7.07826 19.8744 6.44874 19.8744 5.67201C19.8744 4.89527 19.2449 4.26576 18.4682 4.26576Z"
                                            fill="#CFD3D7" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_33_961">
                                            <rect width="24" height="24" fill="white" />
                                        </clipPath>
                                    </defs>
                                </svg>
                            </span>
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
                                    <path
                                        d="M21.576 6.04807C20.856 6.36007 20.112 6.57607 19.32 6.67207C20.136 6.19207 20.76 5.42407 21.048 4.48807C20.28 4.94407 19.44 5.25607 18.552 5.44807C17.832 4.68007 16.8 4.20007 15.672 4.20007C13.488 4.20007 11.736 5.97607 11.736 8.13607C11.736 8.44807 11.76 8.73607 11.832 9.02407C8.56798 8.88007 5.68798 7.29607 3.74398 4.92007C2.35198 7.41607 3.91198 9.48007 4.94398 10.1761C4.31998 10.1761 3.69598 9.98407 3.16798 9.69607C3.16798 11.6401 4.53598 13.2481 6.31198 13.6081C5.92798 13.7281 5.06398 13.8001 4.53598 13.6801C5.03998 15.2401 6.50398 16.3921 8.20798 16.4161C6.86398 17.4721 4.89598 18.3121 2.37598 18.0481C4.12798 19.1761 6.19198 19.8241 8.42398 19.8241C15.672 19.8241 19.608 13.8241 19.608 8.64007C19.608 8.47207 19.608 8.30407 19.584 8.13607C20.4 7.53607 21.072 6.84007 21.576 6.04807Z"
                                        fill="#CFD3D7" />
                                </svg>
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
        <div class="sm:flex sm:items-center sm:justify-between text-[#CFD3D7]">
            <div class="flex gap-2"> <span class=" text-[#CF2031]  sm:text-center lg:block hidden">TMN</span> Copyright. All rights reserved.
            </div>
            <div class="flex lg:items-center  flex-wrap lg:flex-row flex-col  mt-4 lg:mt-0 lg:gap-10 gap-4">
              
                <span class=" text-[#CFD3D7]"><i class="fa-solid fa-envelope text-sm"></i> &nbsp;<a
                        href="mailto:support@topmanagementnetwork.com"> support@topmanagementnetwork.com</a>
                </span>
                <span class="  text-[#CFD3D7]"><i class="fa-solid fa-phone text-sm"></i> &nbsp;<a
                        href="tel:00000000">+91 0000000</a>
                </span>

            </div>

        </div>
        <hr class="my-6 border-gray-200 sm:mx-auto lg:hidden block dark:border-gray-700 lg:my-8">
        <span class=" text-[#CFD3D7]  mt-3 sm:text-center lg:hidden block">TMN Copyright. All rights reserved.
        </span>
    </div>
    </div>
    <script>
        function navcall() {
  const currentPath = window.location.pathname; // Get the current URL path
  const links = document.querySelectorAll('.link'); // Select all links with class "link"

  links.forEach(link => {
    const href = link.getAttribute('href'); // Get the href attribute of each link
    if (currentPath.includes(href)) {
      link.classList.add('active'); // Add 'active' class if the href matches current URL
    } else {
      link.classList.remove('active'); // Remove 'active' class if it doesn't match
    }
  });
}

// Run navcall function when the page is loaded
document.addEventListener('DOMContentLoaded', navcall);
    </script>
    <style>
        .banner-grid{
                background: linear-gradient(90deg, rgba(0, 0, 0, 0.70) 0%, rgba(0, 0, 0, 0.50) 100%);
            }
        
    </style>
</footer>