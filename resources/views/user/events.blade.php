@include("user.components.meta")
@include("user.components.header")
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
              Events
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
        <section class="py-10 text-[#232323]">
        <div class="main-width ">
            <div class="pb-10">
              <p class=" font-light leading-[25px]">
                    Get ready for an exciting lineup of events designed to inspire, connect, and engage! Whether you're looking to expand your knowledge, network with industry professionals, or simply have a great time, our upcoming events offer something for everyone.
                    <br>
                    <br>
                   <span class="font-semibold"> Innovation & Technology Conference</span><br>
Join us for a cutting-edge conference where experts from various fields discuss the latest advancements in technology, AI, and digital transformation. Expect keynote speeches, panel discussions, and interactive workshops that will leave you with valuable insights.
<br><br>
 <span class="font-semibold"> Community Fundraiser Gala</span><br>
Support a great cause while enjoying an elegant evening of entertainment, networking, and philanthropy. This annual gala brings together community leaders, businesses, and donors to make a positive impact.

                    
                </p>
            </div>
            
                          <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-10" id="articles">

@forelse($events as $event)
<div class="h-[380px] group border overflow-hidden rounded-xl shadow-xl w-[340px] relative cursor-pointer">

    {{-- Banner --}}
    <img
        class="w-full h-full transition-all duration-700 transform group-hover:scale-110"
        src="{{ $event->banner_image 
                ? asset('storage/'.$event->banner_image) 
                : asset('images/upcoming-event.png') }}"
        alt="{{ $event->title }}"
    >

    {{-- Content --}}
    <div class="absolute duration-700 ease-in group-hover:h-[300px] bg-white bottom-0 w-full h-[120px] p-6">

        <div class="flex items-center justify-between">
            <span class="px-4 py-2 bg-red-600/10 text-red-600 text-sm rounded font-medium">
                {{ ucfirst($event->event_type ?? 'Event') }}
            </span>

            <span class="font-medium text-sm">
                {{ \Carbon\Carbon::parse($event->event_date)->format('M d, h:i A') }}
            </span>
        </div>

        <h2 class="font-semibold py-4 text-[20px]">
            {{ $event->title }}
        </h2>

        <p class="text-sm line-clamp-3">
            {{ \Illuminate\Support\Str::limit(strip_tags($event->description), 120) }}
        </p>

        <div class="mt-3">
            <a href="{{ route('events.show', $event->slug) }}">
                <span class="bg-red-600 text-white px-4 py-2 text-[13px]">
                    Join Now
                </span>
            </a>
        </div>

    </div>
</div>
@empty
    <p class="text-gray-500">No upcoming events.</p>
@endforelse

</div>

            
            
            
           
       
        </div>
    
    </section>
    @include("user.components.footer")