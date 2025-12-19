@include("user.components.meta")

@php
  $assetBase = app()->environment('local')
    ? ''
    : config('app.url') . '/tmn/public';

@endphp

<section>
  <style>
    @font-face {
      font-family: JuneBug;
      src: url('font/neuropolitical rg.otf');
    }

    .logoFont1 {
      font-family: JuneBug;
      letter-spacing: 10px;
    }
  </style>
  <div id="preloader">
    <div class="flex items-center gap-2">
      <div>
        <svg xmlns="http://www.w3.org/2000/svg" width="134" height="152" viewBox="0 0 134 152" fill="none">
          <path
            d="M62.0802 24.9376C62.525 22.1791 61.7064 19.4785 59.1155 16.7909C55.4159 12.9238 56.2731 6.78156 60.2691 3.11425C64.0589 -0.353251 70.5363 -0.308134 74.1907 3.21093C78.1416 7.02003 78.8248 13.491 74.8352 17.2614C70.5943 21.3025 72.8243 26.0011 72.3409 30.4289C72.212 31.6084 73.3271 31.647 74.2229 31.8146C85.2442 33.8384 94.5059 38.9043 101.589 47.7149C102.079 48.3594 102.607 49.5646 103.652 48.7912C107.306 46.0778 112.675 45.7684 114.106 39.9226C115.44 34.4056 121.64 31.8082 126.951 33.6966C129.44 34.5479 131.504 36.3282 132.711 38.6656C133.918 41.003 134.175 43.7165 133.428 46.2389C131.785 51.5948 126.216 54.8432 120.867 52.987C116.838 51.5884 114.937 54.9657 112.005 55.9776C108.64 57.1377 108.286 59.0841 109.426 62.3776C112.791 71.794 112.462 81.3458 109.091 90.7364C108.279 93.0051 108.524 94.2361 110.735 95.19C111.991 95.8034 113.2 96.51 114.351 97.304C116.613 98.7091 118.546 99.6565 121.64 98.4964C126.403 96.7111 132.017 100.707 133.499 106.05C134.898 111.103 132.036 116.311 126.848 118.128C121.659 119.946 115.491 117.542 114.228 112.212C112.836 106.347 107.596 105.876 103.916 103.188C102.627 102.254 102.098 103.562 101.512 104.258C94.7332 112.468 85.2539 117.997 74.7708 119.856C72.8372 120.23 72.038 121.08 72.154 123.143C72.3861 127.448 71.6707 131.554 75.3766 135.389C79.276 139.404 77.684 145.92 73.0693 149.458C71.0687 150.964 68.5737 151.66 66.0826 151.407C63.5915 151.153 61.2876 149.97 59.6311 148.092C57.7693 146.13 56.7563 143.513 56.8118 140.809C56.8673 138.105 57.9869 135.532 59.9276 133.648C61.5775 131.973 62.9955 122.692 61.8611 120.874C61.2166 119.869 60.05 120.036 59.1348 119.849C48.6807 117.742 39.8702 112.83 33.0512 104.581C31.7621 103.002 30.7116 102.647 29.01 103.885C27.7672 104.768 26.4368 105.522 25.0398 106.134C23.8428 106.63 22.7798 107.401 21.9375 108.386C21.0953 109.37 20.4975 110.54 20.193 111.799C18.556 117.465 12.8842 120.055 7.4896 118.193C1.9532 116.259 -0.811779 110.884 0.967089 105.47C2.80396 99.8756 8.43704 96.8271 13.9477 98.9282C16.7642 99.9981 18.2531 98.187 20.0899 97.1558C25.781 93.9332 25.7166 93.8945 24.073 87.7587C21.6819 78.7935 21.9075 69.9056 25.2138 61.1982C26.0195 59.0841 25.9421 57.75 23.6477 56.7703C21.9111 55.9802 20.2646 55.0057 18.7364 53.8636C16.9382 52.5745 15.2689 52.4327 13.0969 53.1095C7.94077 54.7208 2.44304 51.524 0.88975 46.3356C0.101552 43.7604 0.364835 40.9779 1.62207 38.5963C2.87931 36.2147 5.02825 34.4276 7.59918 33.6257C12.852 31.9435 18.8331 34.5216 20.0964 39.8969C21.4821 45.7749 26.8767 46.0907 30.5633 48.7461C31.8975 49.7129 32.4969 47.9404 33.1027 47.1928C39.5051 39.3272 48.5229 34.0268 58.5096 32.2593C61.339 31.7308 62.5185 30.764 62.0609 27.9282C61.9999 26.932 62.0063 25.9329 62.0802 24.9376ZM26.1226 75.4678C26.1226 98.5544 44.6138 117.258 67.2944 117.11C89.5367 116.968 108.105 98.5093 108.337 76.3121C108.569 53.7862 89.8718 34.8438 67.3524 34.7858C44.7105 34.7214 26.1226 53.0708 26.1226 75.4678ZM10.7895 36.468C9.00079 36.4863 7.29001 37.2028 6.02211 38.4647C4.75421 39.7266 4.02957 41.4339 4.00276 43.2226C3.91897 47.167 6.58083 50.0029 10.4479 50.1125C11.3662 50.1562 12.2837 50.0127 13.1447 49.6907C14.0058 49.3688 14.7924 48.8751 15.4567 48.2397C16.1211 47.6043 16.6493 46.8405 17.0092 45.9946C17.3691 45.1488 17.5533 44.2385 17.5505 43.3192C17.4836 41.539 16.7524 39.8483 15.501 38.5802C14.2496 37.3121 12.5688 36.5586 10.7895 36.468ZM60.4496 141.118C60.4203 142.003 60.5721 142.884 60.8958 143.707C61.2194 144.531 61.708 145.279 62.3315 145.907C62.9551 146.535 63.7004 147.028 64.5217 147.358C65.343 147.687 66.223 147.845 67.1075 147.821C68.8905 147.831 70.6079 147.149 71.8978 145.918C73.1878 144.687 73.9497 143.003 74.0231 141.221C74.0683 137.457 70.7297 134.087 67.0495 134.19C65.2634 134.257 63.5741 135.019 62.3414 136.313C61.1086 137.607 60.4299 139.331 60.4496 141.118ZM130.38 43.2548C130.323 41.4693 129.589 39.7724 128.326 38.5093C127.062 37.2461 125.366 36.5116 123.58 36.4551C119.881 36.4551 116.787 39.8066 116.896 43.6995C117 47.4893 119.945 50.2091 123.825 50.1447C124.713 50.1386 125.59 49.9537 126.404 49.601C127.219 49.2483 127.954 48.7351 128.566 48.092C129.178 47.449 129.654 46.6892 129.965 45.8581C130.277 45.027 130.418 44.1416 130.38 43.2548ZM3.97699 108.203C3.91942 109.085 4.0407 109.971 4.33358 110.805C4.62645 111.64 5.08488 112.406 5.68136 113.06C6.27784 113.713 7.00008 114.238 7.80476 114.606C8.60944 114.973 9.47997 115.173 10.3641 115.196C11.2712 115.265 12.1827 115.149 13.0441 114.857C13.9055 114.565 14.699 114.102 15.3771 113.495C16.0551 112.889 16.6036 112.152 16.9898 111.328C17.376 110.505 17.5918 109.611 17.6244 108.702C17.657 107.793 17.5056 106.887 17.1794 106.038C16.8531 105.189 16.3587 104.414 15.7259 103.761C15.093 103.108 14.3347 102.589 13.4964 102.236C12.6581 101.883 11.7571 101.702 10.8475 101.706C9.96476 101.661 9.08196 101.795 8.25255 102.101C7.42313 102.406 6.66436 102.877 6.02209 103.484C5.37982 104.092 4.86743 104.823 4.51591 105.634C4.16439 106.445 3.98106 107.319 3.97699 108.203ZM60.4367 10.7518C60.4071 11.6434 60.5609 12.5316 60.8886 13.3614C61.2162 14.1912 61.7108 14.9448 62.3416 15.5756C62.9725 16.2064 63.7261 16.701 64.5559 17.0287C65.3856 17.3564 66.2738 17.5102 67.1655 17.4805C70.8521 17.4805 74.0618 14.3095 74.0167 10.7324C73.9539 8.94229 73.2047 7.24492 71.9244 5.99219C70.6441 4.73945 68.9308 4.02742 67.1397 4.00369C66.251 3.98685 65.3681 4.15024 64.5443 4.48398C63.7204 4.81772 62.9728 5.31491 62.3464 5.94553C61.72 6.57615 61.2278 7.32715 60.8996 8.15319C60.5714 8.97924 60.4139 9.86322 60.4367 10.7518ZM123.657 115.209C124.546 115.202 125.425 115.019 126.243 114.673C127.061 114.326 127.803 113.821 128.427 113.188C129.05 112.554 129.542 111.804 129.876 110.98C130.209 110.157 130.377 109.275 130.37 108.386C130.363 107.498 130.181 106.619 129.834 105.801C129.487 104.983 128.983 104.241 128.349 103.617C127.716 102.994 126.966 102.501 126.142 102.168C125.318 101.835 124.437 101.667 123.548 101.674C122.656 101.665 121.771 101.836 120.947 102.179C120.123 102.522 119.377 103.028 118.755 103.667C118.132 104.307 117.646 105.066 117.325 105.899C117.005 106.731 116.857 107.62 116.89 108.512C116.863 109.405 117.02 110.294 117.351 111.123C117.682 111.953 118.181 112.705 118.816 113.334C119.451 113.962 120.208 114.453 121.041 114.775C121.874 115.098 122.765 115.245 123.657 115.209ZM68.9443 125.727V122.692C68.9443 121.525 69.0152 120.378 67.2686 120.384C65.6831 120.384 65.3737 121.299 65.3866 122.582C65.3866 124.735 65.3866 126.881 65.3866 129.027C65.3866 130.258 65.8507 130.851 67.159 130.877C68.4674 130.903 69.0023 130.419 68.9443 129.13C68.8992 128.002 68.9379 126.862 68.9443 125.727ZM68.9443 26.1171V23.4746C68.9443 22.1855 69.1055 20.9352 67.1139 21.0189C65.1224 21.1027 65.3995 22.4433 65.3802 23.655C65.3802 25.2921 65.3802 26.9292 65.3802 28.5662C65.3802 29.8553 65.2448 31.2088 67.1203 31.2861C69.4019 31.3763 68.867 29.6684 68.9379 28.3793C68.983 27.6317 68.9443 26.8712 68.9443 26.1171ZM28.9843 99.186C28.3397 98.2063 28.1593 96.537 26.3289 97.5618C24.2342 98.7349 22.1782 99.9788 20.077 101.132C19.078 101.674 18.8782 102.28 19.4776 103.266C20.077 104.252 20.7667 104.658 21.9268 103.949C23.8603 102.757 25.8648 101.674 27.837 100.546C28.3913 100.237 28.9907 99.9723 29.0036 99.186H28.9843ZM21.192 47.4442C19.8708 47.2959 19.903 48.34 19.4325 48.8234C18.7042 49.5968 19.1747 50.1576 19.903 50.5765C22.0815 51.8269 24.2728 53.045 26.4384 54.3083C26.5843 54.4276 26.7558 54.5117 26.9395 54.554C27.1232 54.5962 27.3142 54.5955 27.4976 54.5518C27.6809 54.5082 27.8518 54.4227 27.9967 54.3022C28.1417 54.1818 28.2569 54.0294 28.3333 53.8571C28.662 53.2706 29.5901 52.4907 28.7265 51.9236C26.2128 50.2865 23.5445 48.8428 21.192 47.4442ZM107.248 97.072C106.868 97.1904 106.52 97.3926 106.229 97.6637C105.938 97.9347 105.711 98.2678 105.566 98.6382C105.082 99.5469 105.566 100.024 106.32 100.43C108.402 101.616 110.49 102.795 112.565 103.994C113.532 104.555 114.247 104.336 114.724 103.35C114.969 102.834 115.73 102.196 114.982 101.719C112.443 100.133 109.82 98.6382 107.248 97.1042V97.072ZM115.569 49.6033C114.473 48.7783 114.615 46.5161 112.449 47.818C110.516 48.9846 108.524 50.1125 106.533 51.2017C105.411 51.8462 105.166 52.5616 105.856 53.6638C106.545 54.7659 107.351 54.6176 108.363 53.986C110.187 52.8517 112.101 51.8784 113.957 50.8021C114.515 50.4417 115.052 50.0523 115.569 49.6355V49.6033Z"
            fill="#CF2031" />
          <path
            d="M0.278296 76.2347C0.236097 70.2381 1.01459 64.2639 2.59211 58.4783C2.90792 57.2473 3.17862 55.7198 4.88659 56.0936C6.89748 56.5318 6.27875 58.0271 5.91782 59.4515C3.00787 70.261 3.00787 81.6478 5.91782 92.4572C6.31098 93.9138 6.73637 95.3705 4.80282 95.7894C3.01106 96.1825 2.90149 94.539 2.59856 93.3596C1.1484 87.5718 0.117167 81.726 0.278296 76.2347Z"
            fill="#CF2031" />
          <path
            d="M133.899 75.9576C134.111 81.9774 133.08 87.8361 131.617 93.6496C131.32 94.8097 131.108 96.0666 129.561 95.8087C127.789 95.5058 127.988 94.2103 128.343 92.8633C131.343 81.7772 131.343 70.0929 128.343 59.0068C128.027 57.8144 127.743 56.5963 129.194 56.1516C130.876 55.6489 131.288 56.9315 131.656 58.2656C133.284 64.0175 134.041 69.9813 133.899 75.9576Z"
            fill="#CF2031" />
          <path
            d="M53.4768 139.468C52.916 141.157 51.7108 140.983 50.3895 140.635C38.8857 137.682 28.3888 131.686 20.0005 123.278C19.0273 122.311 17.5514 121.164 18.95 119.804C20.3486 118.444 21.47 119.92 22.4497 120.887C29.6433 128.127 38.4917 133.507 48.2304 136.562C49.4421 136.935 50.6667 137.251 51.8784 137.619C52.7936 137.902 53.4574 138.418 53.4768 139.468Z"
            fill="#CF2031" />
          <path
            d="M53.4632 12.4727C53.3601 13.62 52.5158 14.0518 51.4652 14.3225C39.909 17.3001 30.0801 23.2619 21.6434 31.6149C20.8828 32.369 19.8967 33.0264 18.9815 32.2078C17.9245 31.2668 18.4079 30.1389 19.2973 29.2302C27.8805 20.3661 38.7954 14.1099 50.782 11.1837C52.3675 10.7647 53.373 11.377 53.4632 12.4727Z"
            fill="#CF2031" />
          <path
            d="M83.1313 11.0934C91.9676 13.1638 100.262 17.0923 107.462 22.6174C109.866 24.4607 112.096 26.5489 114.307 28.6243C115.235 29.4879 116.949 30.4805 115.473 31.9951C113.997 33.5097 112.998 31.9178 112.038 30.9961C106.252 25.3119 99.4825 20.7258 92.0578 17.4613C89.0544 16.1722 85.8769 15.2828 82.751 14.2967C81.6424 13.9486 80.8174 13.433 81.0172 12.2213C81.1977 10.8356 82.2934 10.913 83.1313 11.0934Z"
            fill="#CF2031" />
          <path
            d="M115.995 121.1C115.67 121.692 115.288 122.251 114.854 122.769C106.264 131.507 95.4405 137.72 83.5629 140.732C82.5639 140.996 81.436 141.157 81.0557 139.804C80.6497 138.315 81.7002 137.741 82.8732 137.451C94.3972 134.602 104.084 128.57 112.521 120.371C113.166 119.727 113.862 119.127 114.861 119.43C115.505 119.63 115.86 120.159 115.995 121.1Z"
            fill="#CF2031" />
          <path
            d="M32.9806 75.7126C32.8323 57.2085 48.1718 41.7788 66.8242 41.6757C85.8245 41.5661 101.112 56.6607 101.461 75.8802C101.796 94.0943 85.8245 110.13 67.2367 110.246C48.4425 110.349 33.1352 94.9321 32.9806 75.7126ZM55.6031 85.606C54.4172 83.84 53.3086 82.4414 52.4772 80.8946C48.7068 73.85 50.6339 65.1361 56.9888 60.0057C62.8475 55.2943 71.903 55.4941 77.7487 60.3989C84.4646 66.0642 85.5216 75.5128 80.0561 83.3502C78.7284 85.2515 78.8251 85.8831 80.9197 86.7983C83.9893 88.0631 86.7166 90.0352 88.8795 92.5539C90.9162 95.0482 91.8637 94.5519 93.3332 92.1092C101.222 79.0126 98.7858 62.6998 87.3391 52.7227C81.7709 47.9081 74.6706 45.233 67.3097 45.1763C59.9488 45.1196 52.8081 47.6851 47.1664 52.4133C35.333 62.2873 32.7356 80.1276 41.2562 92.6763C42.2423 94.1265 42.9319 95.1577 44.5948 93.2757C47.5918 89.892 51.4331 87.6427 55.6031 85.606ZM66.9917 106.637C74.7259 106.637 80.8617 104.426 86.3981 100.153C88.8731 98.2192 88.8022 96.7884 86.5979 94.8935C83.5043 92.2381 80.2752 89.8727 76.3308 88.5385C71.9545 87.0626 71.8707 86.2634 75.4156 83.247C81.1067 78.4067 81.9445 70.5114 77.3491 64.9041C73.9783 60.7985 69.5827 59.1743 64.4588 60.2764C59.1931 61.4108 55.7384 64.7301 54.4559 70.0731C53.1733 75.4162 54.6234 79.8118 58.8773 83.3115C62.4286 86.244 62.3125 87.0819 57.9169 88.5836C53.85 89.9758 50.505 92.367 47.4113 95.248C45.5357 96.9882 45.4197 98.245 47.682 99.9336C53.4311 104.245 59.6378 106.998 66.9917 106.637Z"
            fill="#CF2031" />
        </svg>
      </div>
      <div class="text-container logoFont1"> TMN</div>
    </div>
    <div class="progress-bar"></div>

  </div>
</section>

<section class="page">
  @include("user.components.header")
  <section class="bg-[url({{$assetBase}}/images/banner.png)] bg-cover py-10 lg:bg-right bg-center bg-no-repeat">
    <div class="main-width h-full py-4 flex items-center lg:justify-center">
      <div class="grid md:grid-cols-2 gap-6 items-center">
        <div h-full>
          <p class="text-white lg:py-3 py-2 lg:text-[25px] text-[17px] font-normal lg:leading-[25px]">
            Path of Business networking and Growth
          </p>
          <div class="bg-primary w-full px-4 py-4">
            <h1 class="heading2 text-white py-2 px-2 leading-[60px]">
              Let us connect to disrupt and synergize
            </h1>
          </div>

        </div>
        <div class="">
          <img src="{{$assetBase}}/images/banner-i.png" class="mx-auto" alt="" />
        </div>
      </div>
    </div>
  </section>
  <section>
    <div class="main-width py-10 grid lg:grid-cols-[40%,1fr] gap-4">
      <div>
        <img src="{{$assetBase}}/images/abt-img.png" class="w-full  h-full object-cover" alt="" />
      </div>
      <div class="px-3">

        <h2 class="heading1 !text-[40px] font-semibold !leading-[50px]">
          Introduction to <br /><span class="text-primary">
            Top Management Network
          </span>
        </h2>
        <div class="leading-[25px] py-4">
          <!--<p class="para font-bold">World's Business Organization</p>-->
          <p class="para text-justify">
            <span class="text-primary underline">Top Management Network</span> (TMN) is a platform designed to connect
            CXOs, business leaders, and industry professionals, fostering strategic networking, leadership growth, and
            business expansion. Our mission is to empower Top Management and entrepreneurs by providing exclusive access
            to high-value industry insights, professional collaborations, and business opportunities. Through expert-led
            discussions, executive mentorship, and corporate partnerships, TMN helps professionals stay ahead in an
            evolving business landscape, whether you're looking to expand your network, explore new business ventures,
            or gain though leadership exposure, TMN is your gateway to success. Join us and be part of a powerful
            ecosystem that drives innovation, leadership excellence, and industry growth.
          </p>

        </div>
        <div>
          <br>
          <p class=" text-[20px]">
            Forecast <span class="text-primary font-semibold "> 2025-2026</span>
          </p>
        </div>
        <div class="pt-4 grid grid-cols-3 items-start ">
          <div class="p-2 text-center border-r-2">

            <h2 class="md:heading2 text-[30px] text-primary !font-light">
              1000+
            </h2>
            <p class="md:text-[23px] text-[11px] font-light md:leading-[27px]">
              Members
            </p>
          </div>
          <div class="flex items-center  justify-center lg:gap-6 gap-2 border-r-2">

            <div class="p-2">
              <h2 class="md:heading2 text-[30px] text-primary !font-light">
                28 +
              </h2>
              <p class="md:text-[23px] text-[11px] font-light md:leading-[27px]">
                Chapters
              </p>
            </div>
          </div>
          <div class="flex items-center lg:gap-6 gap-2 ">

            <div class="p-2 text-center">
              <h2 class="md:heading2 text-[30px] text-primary !font-light">
                ₹500CR
              </h2>
              <p class="md:text-[23px] text-[11px] font-light md:leading-[27px]">
                Expected Business Network
              </p>
            </div>
          </div>
        </div>
        <a href="/journey">
          <button class="btn bg-primary text-white py-4 lg:text-[18px] text-[16px] lg:px-16 px-10 mt-4 rounded-[5px]">
            Join Now
          </button>
        </a>

      </div>
    </div>
    <div></div>
  </section>
  <section class="bg-[#F8F8F8] py-10">
    <div class="main-width">

      {{-- Heading --}}
      <div class="flex items-center flex-col mb-8">
        <div class="mx-auto flex items-center justify-center">
          <svg width="100" height="10" viewBox="0 0 100 10" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
              d="M98.1952 0C95.1975 0 93.7264 2.31328 92.6493 4.00487C91.6228 5.62657 91.077 6.33742 90.1589 6.33742..."
              fill="#CF2031" />
          </svg>
        </div>

        <h2 class="heading2 text-center mt-2">
          <span class="text-primary">TMN</span>ians
        </h2>
      </div>

      {{-- Members --}}
      <div class="p-4 flex items-start flex-wrap gap-10 justify-center">
        @forelse($activeMembers as $member)
              <div
                class="w-[280px] py-4 border bg-white transition-all ease-in duration-300 transform hover:scale-105 cursor-pointer shadow-md rounded-tl-[20px] rounded-br-[40px]">

                <div class="w-[180px] h-[180px] flex items-center justify-center mx-auto">
                  <div class="w-[90%]">
                    <img src="{{ $member->profile_image
          ? asset('tmn/public/storage/' . $member->profile_image)
          : asset('tmn/public/images/user.png') }}"
                      class="w-full h-full rounded-full object-cover" alt="{{ $member->name }}">
                  </div>
                </div>

                <div class="text-center py-4">
                  <h4 class="text-[#232323] text-[20px] font-semibold leading-[24px]">
                    {{ $member->name }}
                  </h4>

                  <h6 class="text-[#232323] text-[15px] font-normal leading-[24px]">
                    {{ $member->designation ?? 'TMN Member' }}
                  </h6>
                </div>
              </div>
        @empty
          <p class="text-gray-500 text-center">
            No active members available.
          </p>
        @endforelse
      </div>

    </div>
  </section>

  <section class="py-10">
    <div class="main-width">
      <div class="flex items-center flex-col">
        <div class="mx-auto flex items-center justify-center">

          <path
            d="M98.1952 0C95.1975 0 93.7264 2.31328 92.6493 4.00487C91.6228 5.62657 91.077 6.33742 90.1589 6.33742C89.2372 6.33742 88.6926 5.62898 87.6673 4.00246C86.595 2.31328 85.1275 0 82.1239 0C79.1238 0 77.6564 2.31328 76.578 4.00969C75.5539 5.62898 75.0093 6.33742 74.0925 6.33742C73.1695 6.33742 72.6238 5.62417 71.5972 3.99644C70.5261 2.30967 69.0599 0.00120417 66.061 0.00120417C63.061 0.00120417 61.5923 2.31448 60.5152 4.01089C59.4911 5.63019 58.9465 6.33863 58.0296 6.33863C57.1079 6.33863 56.5633 5.62778 55.5416 4.00607C54.4705 2.31449 53.0042 0.00120417 50.0006 0.00120417C46.9994 0.00120417 45.5307 2.3169 44.4572 4.00607C43.4294 5.62778 42.8836 6.33863 41.9632 6.33863C41.0451 6.33863 40.4993 5.63019 39.4728 4.01089C38.4017 2.3193 36.9354 0.00120417 33.9281 0.00120417C30.9245 0.00120417 29.4582 2.31449 28.3859 4.00607C27.3594 5.62778 26.8136 6.33863 25.8967 6.33863C24.9798 6.33863 24.434 5.63019 23.4087 4.01089C22.3388 2.3193 20.8737 0.00120417 17.8641 0.00120417C14.858 0.00120417 13.3917 2.31931 12.3194 4.0133C11.2941 5.63019 10.7495 6.33863 9.83385 6.33863C8.91457 6.33863 8.36998 5.62778 7.34467 4.00607C6.27477 2.3169 4.8109 0.00120417 1.80725 0.00120417C0.810853 0.00120417 0 0.810852 0 1.80845C0 2.80365 0.810853 3.61571 1.80725 3.61571C2.72654 3.61571 3.27112 4.32415 4.29403 5.94344C5.36392 7.63503 6.8302 9.95313 9.83506 9.95313C12.8435 9.95313 14.3074 7.63262 15.3761 5.94103C16.4002 4.32415 16.946 3.61571 17.8653 3.61571C18.787 3.61571 19.3316 4.32415 20.3581 5.94826C21.428 7.63985 22.8943 9.95313 25.8967 9.95313C28.904 9.95313 30.3678 7.63262 31.4377 5.94103C32.4618 4.32415 33.0076 3.61571 33.9269 3.61571C34.845 3.61571 35.392 4.32415 36.4221 5.94826C37.4944 7.63744 38.9619 9.95313 41.9619 9.95313C44.9728 9.95313 46.4379 7.63262 47.5078 5.94103C48.5331 4.32415 49.0777 3.61571 49.9982 3.61571C50.9175 3.61571 51.4609 4.32415 52.4838 5.94103C53.5561 7.63262 55.0211 9.95313 58.0284 9.95313C61.0248 9.95313 62.4959 7.63744 63.5718 5.94103C64.5923 4.32415 65.1369 3.61571 66.0586 3.61571C66.9779 3.61571 67.5225 4.32415 68.5442 5.94344C69.6165 7.63503 71.084 9.95313 74.09 9.95313C77.0925 9.95313 78.5612 7.63262 79.6347 5.93863C80.6552 4.32415 81.1974 3.61571 82.1215 3.61571C83.0432 3.61571 83.589 4.32415 84.6143 5.94586C85.6854 7.63744 87.1516 9.95313 90.1565 9.95313C93.1553 9.95313 94.6252 7.63744 95.7036 5.94103C96.7253 4.32415 97.2698 3.61571 98.1927 3.61571C99.1891 3.61571 100 2.80365 100 1.80845C100 0.809648 99.1903 0 98.1952 0Z"
            fill="#CF2031" />
          </svg>
        </div>
        <h2 class="heading2 text-center">
          <span class="text-primary">TMN </span> Services
        </h2>
        <b>Empowering Leaders, Driving Growth</b>
        <br>
        <p class="para lg:w-[890px] text-center">
          At Top Management Network (TMN), we provide a wide range of services to help CXOs, entrepreneurs, and industry
          leaders connect, collaborate, and grow. Our tailored solutions are designed to foster strategic partnerships,
          professional development, and business expansion.
        </p>
      </div>

    </div>
    <div class="">
      @include("user.services-portion")
    </div>
  </section>
  <section class="bg-[url({{$assetBase}}/images/event.png)] lg:h-[550px]">
    <div class="image-grid w-full h-full">
      <div class="main-width py-10">
        <div class="flex text-white items-center flex-col">
          <div class="mx-auto flex items-center justify-center">

            <path
              d="M98.1952 0C95.1975 0 93.7264 2.31328 92.6493 4.00487C91.6228 5.62657 91.077 6.33742 90.1589 6.33742C89.2372 6.33742 88.6926 5.62898 87.6673 4.00246C86.595 2.31328 85.1275 0 82.1239 0C79.1238 0 77.6564 2.31328 76.578 4.00969C75.5539 5.62898 75.0093 6.33742 74.0925 6.33742C73.1695 6.33742 72.6238 5.62417 71.5972 3.99644C70.5261 2.30967 69.0599 0.00120417 66.061 0.00120417C63.061 0.00120417 61.5923 2.31448 60.5152 4.01089C59.4911 5.63019 58.9465 6.33863 58.0296 6.33863C57.1079 6.33863 56.5633 5.62778 55.5416 4.00607C54.4705 2.31449 53.0042 0.00120417 50.0006 0.00120417C46.9994 0.00120417 45.5307 2.3169 44.4572 4.00607C43.4294 5.62778 42.8836 6.33863 41.9632 6.33863C41.0451 6.33863 40.4993 5.63019 39.4728 4.01089C38.4017 2.3193 36.9354 0.00120417 33.9281 0.00120417C30.9245 0.00120417 29.4582 2.31449 28.3859 4.00607C27.3594 5.62778 26.8136 6.33863 25.8967 6.33863C24.9798 6.33863 24.434 5.63019 23.4087 4.01089C22.3388 2.3193 20.8737 0.00120417 17.8641 0.00120417C14.858 0.00120417 13.3917 2.31931 12.3194 4.0133C11.2941 5.63019 10.7495 6.33863 9.83385 6.33863C8.91457 6.33863 8.36998 5.62778 7.34467 4.00607C6.27477 2.3169 4.8109 0.00120417 1.80725 0.00120417C0.810853 0.00120417 0 0.810852 0 1.80845C0 2.80365 0.810853 3.61571 1.80725 3.61571C2.72654 3.61571 3.27112 4.32415 4.29403 5.94344C5.36392 7.63503 6.8302 9.95313 9.83506 9.95313C12.8435 9.95313 14.3074 7.63262 15.3761 5.94103C16.4002 4.32415 16.946 3.61571 17.8653 3.61571C18.787 3.61571 19.3316 4.32415 20.3581 5.94826C21.428 7.63985 22.8943 9.95313 25.8967 9.95313C28.904 9.95313 30.3678 7.63262 31.4377 5.94103C32.4618 4.32415 33.0076 3.61571 33.9269 3.61571C34.845 3.61571 35.392 4.32415 36.4221 5.94826C37.4944 7.63744 38.9619 9.95313 41.9619 9.95313C44.9728 9.95313 46.4379 7.63262 47.5078 5.94103C48.5331 4.32415 49.0777 3.61571 49.9982 3.61571C50.9175 3.61571 51.4609 4.32415 52.4838 5.94103C53.5561 7.63262 55.0211 9.95313 58.0284 9.95313C61.0248 9.95313 62.4959 7.63744 63.5718 5.94103C64.5923 4.32415 65.1369 3.61571 66.0586 3.61571C66.9779 3.61571 67.5225 4.32415 68.5442 5.94344C69.6165 7.63503 71.084 9.95313 74.09 9.95313C77.0925 9.95313 78.5612 7.63262 79.6347 5.93863C80.6552 4.32415 81.1974 3.61571 82.1215 3.61571C83.0432 3.61571 83.589 4.32415 84.6143 5.94586C85.6854 7.63744 87.1516 9.95313 90.1565 9.95313C93.1553 9.95313 94.6252 7.63744 95.7036 5.94103C96.7253 4.32415 97.2698 3.61571 98.1927 3.61571C99.1891 3.61571 100 2.80365 100 1.80845C100 0.809648 99.1903 0 98.1952 0Z"
              fill="white" />
            </svg>
          </div>
          <h2 class="heading2  text-center">
            Explore Our Upcoming Events
          </h2>
          <p class="para font-light lg:w-[890px] text-center">
            Experience your business in a different way.. Learn from experts that can change your way of thinking . Be a
            part of Events , Be a proud TMNIAN.
          </p>
        </div>
        <div class="grid lg:grid-cols-3 md:grid-cols-2 gap-8 pt-10">

          @foreach($latestEvents as $event)
            <div class="overflow-hidden relative">

              <img
                src="{{ $event->banner_image ? asset('tmn/public/storage/' . $event->banner_image) : asset('tmn/public/images/upcoming-event.png') }}"
                class="w-full h-full object-cover" alt="{{ $event->title }}">

              <div class="absolute w-[90%] bottom-[5%] p-4 rounded-[20px] bg-white/90 left-[5%]">
                <div class="relative">

                  <div
                    class="absolute flex flex-col w-[55px] h-[80px] flex flex-col items-center justify-center text-white -top-14 rounded-[5px] right-4 bg-red-600">
                    <p class="text-[30px] font-bold leading-[26px]">
                      {{ \Carbon\Carbon::parse($event->event_date)->format('d') }}
                    </p>
                    <p class="font-normal leading-[26px]">
                      {{ \Carbon\Carbon::parse($event->event_date)->format('M') }}
                    </p>
                  </div>

                  <p class="text-[20px] font-semibold leading-[30px]">
                    {{ $event->title }}
                  </p>

                  <p class="text-[#848484] font-normal">
                    {{ $event->city ?? 'Online' }}
                    {{ \Carbon\Carbon::parse($event->event_date)->format('d M') }}
                  </p>

                  <p class="leading-[30px] font-normal">
                    {{ \Illuminate\Support\Str::limit(strip_tags($event->description), 120) }}
                  </p>

                  <a href="{{ route('events.show', $event->slug) }}" class="text-primary font-bold leading-[30px]">
                    Read More
                  </a>

                </div>
              </div>

            </div>
          @endforeach

        </div>

      </div>
    </div>


  </section>
  <div class="hidden main-width py-10 2xl:mt-[490px] xl:mt-[140px] lg:mt-[50px] lg:flex items-center justify-center ">
    <button
      class="  text-white px-6 rounded-[5px] xl:text-[18px] text-[16px] lg:font-bold xl:leading-[32px] py-4"></button>
  </div>
  <section class="bg-[#F8F8F8] py-14 2xl:pt-40">

    <div class="main-width">
      <div class="flex items-center flex-col">
        <div class="mx-auto flex items-center justify-center">

        </div>
        <h2 class="heading2 text-center">
          <span class="text-primary">Advisory </span>Committee
        </h2>
        <p class="para lg:w-[890px] text-center">
          Glimpse of our esteemed advisory panel
        </p>
      </div>
      <style>
        /* From Uiverse.io by KSAplay */
        .card {
          display: flex;
          flex-direction: column;
          align-items: center;
          position: relative;
          width: 240px;
          height: 380px;
          border-radius: 20px;
          overflow: hidden;
          box-shadow: 12px 12px 0px rgba(0, 0, 0, 0.1);
          background-color: white;
        }

        /* Landscape section */
        .landscape-section {
          position: relative;
          width: 100%;
          height: 70%;
          overflow: hidden;
        }

        .landscape-section * {
          position: absolute;
        }





        .filter {
          height: 100%;
          width: 100%;
          background: linear-gradient(0deg,
              rgba(255, 255, 255, 1) 0%,
              rgba(255, 255, 255, 0) 40%);
          z-index: 5;
          opacity: 0.2;
        }

        /* Content section */
        .content-section {
          width: 100%;
          height: 30%;
          display: flex;
          flex-direction: column;
          align-items: center;
        }

        .weather-info {
          display: flex;
          align-items: center;
          justify-content: space-around;
          position: absolute;
          text-align: center;
          top: 0;
          right: 0%;
          width: 100%;
          padding-top: 15px;
          color: white;
          z-index: 10;
        }

        .weather-info .left-side:not(.icon) {
          width: 20%;
          font-size: 11pt;
          font-weight: 600;
          align-self: baseline;
        }

        .icon {
          display: flex;
          align-items: center;
          justify-content: center;
        }

        .icon svg {
          width: 40px;
        }

        .weather-info .right-side {
          display: flex;
          flex-direction: column;
          align-items: flex-end;
        }

        .weather-info .right-side p:nth-child(2) {
          font-size: 9pt;
          margin: 0;
          padding: 0;
        }

        .weather-info .location span {
          font-size: 11pt;
          font-weight: 700;
          text-transform: uppercase;
        }

        .location {
          display: flex;
          align-items: center;
          justify-content: flex-end;
          width: 100%;
          padding: 0;
          margin: 0;
        }

        .location svg {
          width: 14px;
          height: auto;
        }

        .temperature {
          font-size: 20pt;
          font-weight: 700;
          line-height: 30px;
        }

        .forecast {
          display: flex;
          flex-direction: column;
          align-items: center;
          justify-content: space-evenly;
          height: 100%;
          width: 100%;
          padding: 10px 25px;
        }

        .forecast>div {
          width: 100%;
          display: flex;
          align-items: center;
          justify-content: space-between;
          color: lightslategray;
          font-size: 9pt;
        }

        .separator {
          width: 100%;
          height: 2px;
          background-color: rgb(233, 233, 233);
          border-radius: 1px;
        }
      </style>
      <div class="p-4 py-8 grid  md:grid-cols-2 lg:grid-cols-4  xl:grid-cols-5 gap-6 items-center justify-center"
        id="committee-containerr">


        @foreach($advisories as $advisory)
          <div class="card border mx-auto">

            <section class="landscape-section">
              <img src="{{ $advisory->thumbnail_url }}" class="mx-auto w-full h-full object-cover object-top"
                alt="{{ $advisory->advisor_name }}">
            </section>

            <section class="content-section">
              <div class="weather-info">
                <div class="left-side"></div>
                <div class="right-side">
                  <div class="location"></div>
                </div>
              </div>

              <div class="forecast">
                <div>
                  <p class="text-[22px] font-semibold text-[#000]">
                    {{ $advisory->advisor_name }}
                  </p>
                </div>

                <div class="separator"></div>

                <div>
                  <p class="text-[15px] font-medium">
                    {{ $advisory->advisor_designation ?? 'Senior Advisor' }}
                  </p>
                </div>

                <div class="separator"></div>
              </div>
            </section>

          </div>
        @endforeach

      </div>


    </div>
    </div>
    </div>
  </section>
  @include("user.easy-to-joinsection")
  <section class="bg-[#F8F8F8] py-10">
    <div class=" main-width flex items-center flex-col lg:mt-[280px]">
      <div class="mx-auto flex items-center justify-center">


      </div>
      <h2 class="heading2 text-center">
        Stories Behind <span class="text-primary">TMNians</span>
      </h2>
      <p class="para lg:w-[890px] text-center">
        Every entrepreneur goes through a series of failures and some structured success . This section helps TMNions to
        inspire others with there story that encompasses sheer grid and dedication to conquer there feat
      </p>
    </div>
    <div class="main-width py-8">

      <div id="splide" class="splide">
        <div class="splide__track">
          <ul class="splide__list" id="behindImagess">

            @foreach($stories as $story)
                        <li class="splide__slide h-[420px]">

                          <div class="h-[400px] border rounded-br-[40px]
                                      shadow-[0px_4px_20px_0px_rgba(129,129,129,0.25)]
                                      bg-white">

                            {{-- Image --}}
                            <div class="w-full h-[200px] overflow-hidden">
                              <img src="{{ asset($story->image_url) }}" class="w-full h-full object-contain"
                                alt="{{ $story->title }}">
                              loading="lazy">
                            </div>

                            {{-- Content --}}
                            <div class="p-4 h-full text-center">

                              {{-- Description --}}
                              <p class="font-medium leading-[25px] text-[17px]">
                                {{ \Illuminate\Support\Str::limit(
                $story->short_description ?: $story->description,
                120
              ) }}
                              </p>

                              {{-- Separator --}}
                              <hr class="w-[30%] my-4 border-[#CF2031] border-2 mx-auto">

                              {{-- Author --}}
                              <p class="font-semibold leading-[30px] text-[16px]">
                                {{ $story->author_name }}
                              </p>

                              {{-- Company --}}
                              @if($story->author_company)
                                <p class="text-[15px] text-gray-700">
                                  {{ $story->author_company }}
                                </p>
                              @endif

                              {{-- Category & Industry --}}
                              @if($story->category || $story->industry)
                                <p class="text-[14px] text-gray-600 mt-2">
                                  {{ collect([$story->category, $story->industry])->filter()->implode(' • ') }}
                                </p>
                              @endif

                            </div>

                          </div>

                        </li>
            @endforeach

          </ul>

        </div>
      </div>

    </div>
  </section>
  <script>
    document.addEventListener("DOMContentLoaded", () => {
      console.log("HTML is fully loaded and parsed!");
      const lastVisit = localStorage.getItem("lastVisit");
      const currentTime = Date.now();
      const oneHourInMilliseconds = 60 * 60 * 1000;
      if (lastVisit && currentTime - lastVisit < oneHourInMilliseconds) {
        document.getElementById("preloader").style.display = "none";
        document.querySelector(".page").style.display = "block";
      } else {
        let progressBar = document.querySelector(".progress-bar");
        let loadPercentage = 0;
        let fakeLoading = setInterval(() => {
          loadPercentage += 10;
          progressBar.style.width = loadPercentage + "%";
          if (loadPercentage >= 100) {
            clearInterval(fakeLoading);
            setTimeout(() => {
              document.getElementById("preloader").style.display = "none";
              document.querySelector(".page").style.display = "block";
            }, 500);
          }
        }, 300);
        localStorage.setItem("lastVisit", currentTime);
      }
    });
  </script>
  @include("user.components.footer")
</section>




</body>

</html>