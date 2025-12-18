@include("user.components.meta")
@include("user.components.header")

@php
  $assetBase = app()->environment('local')
    ? ''
    : config('app.url') . '/tmn/public';
@endphp

<section class="bg-[url({{ $assetBase }}/images/about-us-banner.png)] bg-cover lg:bg-right bg-center bg-no-repeat">
  <div class="w-full py-10 h-full banner-grid">
    <div class="main-width h-full py-4 flex items-center lg:justify-start">
      <div class="w-full grid md:grid-cols-[58%,1fr] gap-6 items-center">
        <div h-full>
          <p class="text-white lg:py-3 py-2 lg:text-[25px] text-[17px] font-normal lg:leading-[25px]">
            Path of Business networking and Growth
          </p>
          <div class="w-full ">
            <span class="heading2 bg-primary text-white py-2 px-7">
              About Us
            </span>
          </div>
          <!--<p-->
          <!--  class="text-white lg:py-3 py-2 lg:text-[19px] text-[16px] font-normal lg:leading-[30px]"-->
          <!---->
          <!-- Have a question or need more information? Whether you're interested in membership, learning about Chapters, or exploring franchise opportunities, we're here to help. Reach out, and our team will connect you with the right resources. -->
          <!--</p>-->
        </div>

      </div>
    </div>
  </div>
</section>
<section class="pt-10 text-[#232323]">
  <div class="main-width">
    <p class="leading-[25px] text-[16px]">
      <span class="font-bold">Top Management Network</span> (TMN) is a premier business networking platform designed for
      top executives, entrepreneurs, and industry leaders. Our mission is to connect, empower, and inspire professionals
      by providing exclusive networking opportunities, strategic mentorship, and business growth solutions.



      <!--TMN is founded with a vision to enhance business, develop skills and create an environment for interactions among the top management of similar or diverse fields.-->
      <!--<br> <br>-->
      <!--One of the main aims of TMN is to contribute towards mentoring the budding entrepreneurs /startups and enable them to handle business challenges in a better way.-->
    </p>
  </div>
  <div class="main-width py-10">
    <div class="">

      <h2 class="heading2 ">
        What is <span class="text-primary">TMN?</span>
      </h2>
      <p class="para t">
        TMN is more than just a networking platform – it’s a community of visionaries, decision-makers, and
        change-makers who drive innovation and success across industries. We facilitate high-impact connections, expert
        advisory support, and leadership events to help businesses scale and professionals excel in their careers.
      </p>
    </div>

  </div>
  <div class="main-width pb-10">
    <div class="">

      <h2 class="heading2 ">
        Business <span class="text-primary">Network</span>
      </h2>
      <p class="para t">
        In today’s competitive world, success isn’t just about what you know—it’s about who you know. A powerful
        business network opens doors to new opportunities, strategic partnerships, industry insights, and long-term
        success. Whether you are an entrepreneur, business leader, or professional, building the right connections can
        elevate your career and expand your business.

      </p>
    </div>

  </div>
</section>
<section class="bg-[#F8F8F8] py-10">
  <div class="grid lg:grid-cols-[40%,1fr] lg:gap-1 gap-4 grid-cols-1 items-center main-width">
    <div>
      <div class="">
        <div class=" ">

        </div>
        <h2 class="heading2 ">
          Why <span class="text-primary">TMN</span>
        </h2>
        <p class="para t">
        <ul class="list-decimal pl-6 space-y-2 font-normal leading-[30px]">

          <li>
            Opportunity to interact with various CEO’s, Top Management people.
          </li>
          <li>
            Business Growth Prospect
          </li>
          <li>
            Great opportunity for entrepreneurs and startup industries
          </li>
          <li>
            Continuous interactions help to create out of box approach
          </li>
          <li>
            Skill sharing and growth
          </li>
          <li>
            Social Interactions among the Top management
          </li>
          <li>
            Open environment to build up a strong relation
          </li>
        </ul>
        </p>
      </div>
    </div>
    <div>
      <img src="{{ $assetBase }}/images/abt1.png" class="w-full object-cover h-[200px] lg:h-full">
    </div>
  </div>
</section>
<div class="grid  py-10 lg:grid-cols-[1fr,40%] lg:gap-1 gap-4 grid-cols-1 items-center main-width">

  <div class="lg:order-1 order-2">
    <img src="{{ $assetBase }}/images/abt2.png" class="w-full object-cover h-[200px] lg:h-full">
  </div>
  <div class="lg:order-2 order-1 lg:pl-6">
    <div class="">
      <div class=" ">

      </div>
      <h2 class="heading2 ">
        Who Can <span class="text-primary">Join</span>
      </h2>
      <p class="para t">
      <ul class="list-decimal pl-6 space-y-2 font-normal leading-[30px]">

        <li>
          CEO’s
        </li>
        <li>
          CMD’s
        </li>
        <li>
          CXO’s
        </li>
        <li>
          Top Management peoples
        </li>
        <li>
          Decision Makers
        </li>
        <li>
          Entrepreneurs
        </li>

      </ul>
      </p>
    </div>
  </div>
</div>

<section class="bg-[#F8F8F8] py-10">
  <div class="grid lg:grid-cols-[40%,1fr] lg:gap-1 gap-4 grid-cols-1 items-center main-width">
    <div>
      <div class="">
        <div class=" ">

        </div>
        <h2 class="heading2 ">
          What We <span class="text-primary">Offer</span>
        </h2>
        <p class="para t">
        <ul class="list-decimal pl-6 space-y-2 font-normal leading-[30px]">

          <li>
            Business networking
          </li>
          <li>

            Top panel under one roof
          </li>
          <li>
            Cross business interaction within city
          </li>
          <li>
            Intra city business interactions
          </li>
          <li>
            Cross country Interactions
          </li>
          <li>
            Leadership seminar
          </li>
          <li>
            Business leadership mentors
          </li>


          <li>
            Business conference
          </li>
          <li>
            Industry / sector interactions
          </li>

          <li>
            Annual Conference and awards
          </li>
          <li>
            Development program for business growth
          </li>
          <li>
            Investor and VC world
          </li>
        </ul>
        </p>
      </div>
    </div>
    <div>
      <img src="{{ $assetBase }}/images/abt3.png" class="w-full object-cover h-[200px] lg:h-full">
    </div>
  </div>
</section>
<div class="main-width py-10">
  <div class="">
    <div class=" ">

    </div>
    <h2 class="heading2 ">
      Manifesto
    </h2>
    <p class="para t">
      TMN has a devoted yet continuous progressive agenda. However imperative to all our major focus is how we can
      contribute towards a better society, workshops in educational institutions for enhancing management and
      entrepreneurship skills, creating and advocating opportunities for unemployed , out of box idea generation ,
      Business interactions , consultancy , seed funding opportunities etc. are few of endless tasks manifested by TMN
    </p>
  </div>

</div>
@include("user.components.footer")