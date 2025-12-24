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
        <div class="bg-white rounded-2xl shadow p-8">

    {{-- DATE --}}
    <span class="inline-flex items-center gap-2 bg-red-600/10 text-red-600 px-4 py-2 rounded text-sm font-medium">
        <i data-feather="calendar" class="w-4 h-4"></i>
        {{ optional($event->event_date)->format('l, d F Y') ?? 'Date not announced' }}
    </span>

    {{-- TITLE --}}
    <h2 class="text-3xl font-bold mt-4 text-[#232323]">
        {{ $event->title }}
    </h2>

    {{-- LOCATION --}}
    <div class="flex items-start gap-2 mt-2 text-gray-500">
        <i data-feather="map-pin" class="w-4 h-4 mt-1"></i>
        <p>
            {{ $event->city }}{{ $event->state ? ', '.$event->state : '' }}{{ $event->country ? ', '.$event->country : '' }}
        </p>
    </div>

    {{-- DESCRIPTION --}}
    <div class="mt-6 text-gray-700 leading-7">
        {!! nl2br(e($event->description)) !!}
    </div>

    {{-- AGENDA --}}
    @if($event->agenda)
        <div class="mt-8">
            <h3 class="text-xl font-semibold mb-3 text-[#232323] flex items-center gap-2">
                <i data-feather="list" class="w-5 h-5"></i>
                Event Agenda
            </h3>

            <ul class="list-decimal pl-6 space-y-2 text-gray-700">
                @foreach(json_decode($event->agenda, true) as $agenda)
                    <li>{{ $agenda }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- META INFO --}}
    <div class="mt-10 grid sm:grid-cols-2 lg:grid-cols-3 gap-6 text-sm">

        {{-- VENUE --}}
        <div class="flex gap-3">
            <i data-feather="home" class="w-5 h-5 text-gray-600"></i>
            <div>
                <p class="text-gray-500">Venue</p>
                <p class="font-medium text-gray-900">
                    {{ $event->venue_name ?? $event->city ?? 'TBA' }}
                </p>
            </div>
        </div>

        {{-- ADDRESS --}}
        <div class="flex gap-3">
            <i data-feather="navigation" class="w-5 h-5 text-gray-600"></i>
            <div>
                <p class="text-gray-500">Address</p>
                <p class="font-medium text-gray-900">
                    {{ $event->address_line1 }}
                    {{ $event->address_line2 ? ', '.$event->address_line2 : '' }}
                </p>
            </div>
        </div>

        {{-- TIME --}}
        <div class="flex gap-3">
            <i data-feather="clock" class="w-5 h-5 text-gray-600"></i>
            <div>
                <p class="text-gray-500">Time</p>
                <p class="font-medium text-gray-900">
                    {{ $event->start_time ? \Carbon\Carbon::parse($event->start_time)->format('h:i A') : '—' }}
                    –
                    {{ $event->end_time ? \Carbon\Carbon::parse($event->end_time)->format('h:i A') : '—' }}
                </p>
            </div>
        </div>

        {{-- EVENT TYPE --}}
        <div class="flex gap-3">
            <i data-feather="tag" class="w-5 h-5 text-gray-600"></i>
            <div>
                <p class="text-gray-500">Event Type</p>
                <p class="font-medium text-gray-900 capitalize">
                    {{ $event->event_type ?? 'General' }}
                </p>
            </div>
        </div>

        {{-- HOST --}}
        <div class="flex gap-3">
            <i data-feather="user" class="w-5 h-5 text-gray-600"></i>
            <div>
                <p class="text-gray-500">Hosted By</p>
                <p class="font-medium text-gray-900">
                    {{ $event->host_name ?? 'TMN Team' }}
                </p>
            </div>
        </div>

        {{-- CONTACT --}}
        <div class="flex gap-3">
            <i data-feather="phone" class="w-5 h-5 text-gray-600"></i>
            <div>
                <p class="text-gray-500">Contact</p>
                <p class="font-medium text-gray-900">
                    {{ $event->host_contact ?? '—' }}
                </p>
            </div>
        </div>

    </div>

    {{-- ONLINE EVENT --}}
    @if($event->is_online)
        <div class="mt-8 p-5 bg-green-50 border border-green-200 rounded-xl">
            <h4 class="font-semibold text-green-700 mb-2 flex items-center gap-2">
                <i data-feather="video" class="w-5 h-5"></i>
                Online Event
            </h4>

            <p class="text-sm text-gray-700 flex items-center gap-2">
                <i data-feather="link" class="w-4 h-4"></i>
                <a href="{{ $event->meeting_link }}" target="_blank" class="text-blue-600 underline">
                    Join Meeting
                </a>
            </p>

            @if($event->meeting_password)
                <p class="text-sm text-gray-700 mt-1 flex items-center gap-2">
                    <i data-feather="lock" class="w-4 h-4"></i>
                    Password: <strong>{{ $event->meeting_password }}</strong>
                </p>
            @endif
        </div>
    @endif

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
                                {{ optional($item->event_date)->format('D, d M') ?? 'TBA' }}
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
<script src="https://unpkg.com/feather-icons"></script>
<script>
    feather.replace();
</script>

@include("user.components.footer")

