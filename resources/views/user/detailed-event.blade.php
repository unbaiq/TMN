@include("user.components.meta")
@include("user.components.header")

@php
    $assetBase = app()->environment('local')
        ? ''
        : config('app.url') . '/tmn/public';
@endphp

{{-- =========================
   HERO / BANNER
========================= --}}
<section class="bg-[url({{ $assetBase }}/images/committee-banner.png)] bg-cover bg-center bg-no-repeat">
    <div class="w-full py-14 bg-black/40">
        <div class="main-width">
            <p class="text-white text-lg">Path to Business Growth.</p>

            <span class="inline-block bg-primary text-white px-6 py-2 mt-3 rounded">
                Event Details
            </span>

            <h1 class="text-white text-4xl font-bold mt-5">
                {{ $event->title }}
            </h1>

            <p class="text-white/80 mt-2">
                {{ $event->city }}, {{ $event->state }}
            </p>
        </div>
    </div>
</section>

{{-- =========================
   EVENT DETAILS + FORM
========================= --}}
<section class="py-12">
    <div class="main-width grid lg:grid-cols-2 gap-10">

        {{-- LEFT : EVENT INFO --}}
        <div>
            <span class="inline-block bg-red-600/10 text-red-600 px-4 py-2 rounded text-sm font-medium">
                {{ $event->event_date->format('l, d F Y') }}
            </span>

            <h2 class="text-3xl font-bold mt-4 text-[#232323]">
                {{ $event->title }}
            </h2>

            <p class="mt-4 text-gray-700 leading-7">
                {!! nl2br(e($event->description)) !!}
            </p>

            {{-- AGENDA --}}
            @if($event->agenda)
                <div class="mt-6">
                    <h3 class="text-xl font-semibold mb-3">Event Agenda</h3>
                    <ul class="list-decimal pl-6 text-gray-700 space-y-2">
                        @foreach(json_decode($event->agenda) as $agenda)
                            <li>{{ $agenda }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- META --}}
            <div class="mt-8 grid grid-cols-2 gap-6 text-sm">
                <div>
                    <p class="text-gray-500">Venue</p>
                    <p class="font-medium">{{ $event->city }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Time</p>
                    <p class="font-medium">{{ $event->start_time }} - {{ $event->end_time }}</p>
                </div>
            </div>
        </div>

        {{-- RIGHT : JOIN FORM --}}
        <div class="bg-gray-100 p-8 rounded-2xl shadow">
            <h3 class="text-xl font-semibold mb-6 text-center">
                Join This Event
            </h3>

            <form method="POST" action="{{ route('enquiry.submit', $event->id) }}" class="space-y-4">
                @csrf

                <div class="grid grid-cols-2 gap-4">
                    <input type="text" name="first_name" required
                           placeholder="First Name"
                           class="w-full px-4 py-3 rounded border focus:outline-none focus:ring">

                    <input type="text" name="last_name"
                           placeholder="Last Name"
                           class="w-full px-4 py-3 rounded border focus:outline-none focus:ring">
                </div>

                <input type="email" name="email" required
                       placeholder="Email Address"
                       class="w-full px-4 py-3 rounded border focus:outline-none focus:ring">

                <input type="text" name="phone" required
                       placeholder="Phone Number"
                       class="w-full px-4 py-3 rounded border focus:outline-none focus:ring">

                <div class="grid grid-cols-2 gap-4">
                    <input type="text" name="city"
                           placeholder="City"
                           class="w-full px-4 py-3 rounded border focus:outline-none focus:ring">

                    <input type="text" name="zip"
                           placeholder="Zip Code"
                           class="w-full px-4 py-3 rounded border focus:outline-none focus:ring">
                </div>

                <button type="submit"
                        class="w-full bg-primary text-white py-3 rounded-lg font-medium hover:bg-primary/90 transition">
                    Submit & Join Event
                </button>
            </form>
        </div>

    </div>
</section>

{{-- =========================
   OTHER EVENTS
========================= --}}
<section class="bg-[#f8f8f8] py-12">
    <div class="main-width">
        <h2 class="text-3xl font-bold mb-8">
            Other Events You May Like
        </h2>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
        @if(isset($relatedEvents) && $relatedEvents->count())
    <section class="bg-[#f8f8f8] py-12">
        <div class="main-width">
            <h2 class="text-3xl font-bold mb-8">
                Other Events You May Like
            </h2>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($relatedEvents as $item)
                    <a href="{{ route('events.show', $item->slug) }}"
                       class="bg-white rounded-xl overflow-hidden shadow hover:shadow-xl transition">

                        <img src="{{ asset('storage/'.$item->banner_image) }}"
                             class="h-48 w-full object-cover">

                        <div class="p-5">
                            <span class="text-xs bg-red-600/10 text-red-600 px-3 py-1 rounded">
                                {{ $item->event_date->format('D, d M') }}
                            </span>

                            <h3 class="font-semibold text-lg mt-3">
                                {{ $item->title }}
                            </h3>

                            <p class="text-sm text-gray-600 mt-2">
                                {{ \Illuminate\Support\Str::limit($item->description, 80) }}
                            </p>

                            <span class="inline-block mt-4 bg-red-600 text-white px-4 py-2 text-sm rounded">
                                Join Now
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
@endif
        </div>
    </div>
</section>

@include("user.components.footer")
