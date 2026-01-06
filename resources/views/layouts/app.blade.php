@php
  $assetBase = app()->environment('local')
    ? ''
    : config('app.url') . '/tmn/public';
@endphp
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>{{ config('app.name', 'TMN') }} — Dashboard</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="apple-touch-icon" sizes="180x180" href="{{ $assetBase }}/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ $assetBase }}/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ $assetBase }}/favicon-16x16.png">
  <link rel="manifest" href="{{ $assetBase }}/site.webmanifest">

  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Feather icons -->
  <script src="https://unpkg.com/feather-icons"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


  <style>
    /* Shared layout styles */
    .nav-active {
      background: linear-gradient(to right, #ffe6e6, #ffffff);
      border-right: 4px solid #e53935;
      box-shadow: inset 0 0 10px rgba(229, 57, 53, 0.15);
    }

    .nav-item:hover {
      background: rgba(255, 100, 100, 0.08);
      transition: all 0.18s ease;
      transform: translateX(4px);
    }

    .dropdown-hidden {
      display: none;
    }

    .dropdown-visible {
      display: block !important;
      opacity: 1 !important;
      transform: scale(1) !important;
    }

    .sidebar-scrollbar::-webkit-scrollbar {
      width: 8px;
    }

    .sidebar-scrollbar::-webkit-scrollbar-thumb {
      background: rgba(0, 0, 0, 0.12);
      border-radius: 9999px;
    }

    .mobile-slide {
      transform: translateX(-100%);
      transition: transform 240ms ease-in-out;
    }

    .mobile-open {
      transform: translateX(0);
    }

    /* Modern Button Style */
    button {
      transition: all 0.25s ease;
    }

    button:hover {
      transform: translateY(-2px);
    }

    /* INPUTS */
    input,
    select,
    textarea {
      transition: all .2s ease-in-out;
    }

    input:focus,
    select:focus,
    textarea:focus {
      border-color: #e11d48 !important;
      box-shadow: 0 0 0 3px rgba(225, 29, 72, 0.25);
      outline: none;
    }
  </style>
</head>

<body class="bg-gray-100 font-sans antialiased">

  @php
    $user = auth()->user();
    $role = $user->role ?? null;
  @endphp
  @php
    $adminModule = null;

    if ($role === 'admin') {
      $adminModule = match (true) {
        request()->routeIs('admin.dashboard') => 'Dashboard',
        request()->routeIs('admin.enquiries.*') => 'Enquiries',
        request()->routeIs('admin.members.*') => 'Members',
        request()->routeIs('admin.chapters.*') => 'Chapters',
        request()->routeIs('admin.events.attended'),
        request()->routeIs('admin.events.attendance*') => 'Event Attendance',
        request()->routeIs('admin.events.*') => 'Events',
        request()->routeIs('admin.insights.*') => 'Insights',
        request()->routeIs('admin.stories.*') => 'Stories',
        request()->routeIs('admin.meetups.*') => 'Meetups',
        request()->routeIs('admin.articles.*') => 'Articles',
        request()->routeIs('admin.consultations.*') => 'Consultations',
        request()->routeIs('admin.advisories.*') => 'Advisory',
        request()->routeIs('admin.partners.*') => 'Partners',
        request()->routeIs('admin.sponsors.*') => 'Sponsors',
        request()->routeIs('admin.recognitions.*') => 'Recognitions',
        request()->routeIs('admin.awards.*') => 'Awards',
        request()->routeIs('admin.csrs.*') => 'CSR',
        default => 'Admin Panel',
      };
    }
  @endphp

  <div class="min-h-screen flex">

    {{-- DESKTOP SIDEBAR (role-aware) --}}
    <aside id="desktopSidebar"
      class="hidden md:flex flex-col w-64 bg-white h-screen fixed top-0 left-0 shadow-xl sidebar-scrollbar"
      aria-label="Main sidebar">
      <div class="flex items-center gap-3 px-6 py-5 border-b">
        <a href="{{ $role === 'admin' ? route('admin.dashboard') : route('member.dashboard') }}">
          <img src="{{ $assetBase }}/images/newlogo.png" alt="TMN Logo" class="h-10">
        </a>
      </div>

      <nav class="flex-1 overflow-y-auto px-2 py-4 space-y-1">
        {{-- MEMBER NAV --}}
        @if($role === 'member')
          <a href="{{ route('member.dashboard') }}"
            class="flex items-center gap-4 px-4 py-3 rounded-lg nav-item {{ request()->routeIs('member.dashboard') ? 'nav-active' : '' }}">
            <i data-feather="home" class="w-5"></i><span class="hidden md:inline">Dashboard</span>
          </a>

          <a href="{{ route('member.chapter.events') }}"
            class="flex items-center gap-4 px-4 py-3 rounded-lg nav-item {{ request()->routeIs('member.chapter.events') ? 'nav-active' : '' }}">
            <i data-feather="calendar" class="w-5"></i><span class="hidden md:inline">Events</span>
          </a>

          <a href="{{ route('member.chapter.attended') }}"
            class="flex items-center gap-4 px-4 py-3 rounded-lg nav-item {{ request()->routeIs('member.chapter.eventattended') ? 'nav-active' : '' }}">
            <i data-feather="check-circle" class="w-5"></i><span class="hidden md:inline">Attendance</span>
          </a>

          <a href="{{ route('member.invitations.index') }}"
            class="flex items-center gap-4 px-4 py-3 rounded-lg nav-item {{ request()->routeIs('member.invitations.*') ? 'nav-active' : '' }}">
            <i data-feather="user-plus" class="w-5"></i>
            <span class="hidden md:inline">Invitations</span>
          </a>
          <a href="{{ route('member.connects.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-lg nav-item
            {{ request()->routeIs('member.connects.*') ? 'nav-active' : '' }}">
            <i data-feather="globe" class="w-5"></i>
            <span class="hidden md:inline">Connects</span>
          </a>


          <a href="{{ route('member.business.index') }}"
            class="flex items-center gap-4 px-4 py-3 rounded-lg nav-item {{ request()->routeIs('member.business.*') ? 'nav-active' : '' }}">
            <i data-feather="briefcase" class="w-5"></i>
            <span class="hidden md:inline">Give &amp; Take</span>
          </a>


          <a href="{{ route('member.meetings.onetoone') }}"
            class="flex items-center gap-4 px-4 py-3 rounded-lg nav-item {{ request()->routeIs('member.meetings.onetoone') ? 'nav-active' : '' }}">
            <i data-feather="users" class="w-5"></i>
            <span class="hidden md:inline">1-1 Meetup</span>
          </a>

          <a href="{{ route('member.meetings.cluster') }}"
            class="flex items-center gap-4 px-4 py-3 rounded-lg nav-item {{ request()->routeIs('member.meetings.cluster') ? 'nav-active' : '' }}">
            <i data-feather="grid" class="w-5"></i>
            <span class="hidden md:inline">Cluster Meeting</span>
          </a>


          <a href="{{ route('member.recognitions.index') }}"
            class="flex items-center gap-4 px-4 py-3 rounded-lg nav-item {{ request()->routeIs('member.recognitions.*') ? 'nav-active' : '' }}">
            <i data-feather="award" class="w-5"></i>
            <span class="hidden md:inline">Recognitions</span>
          </a>

          <a href="{{ route('member.awards.index') }}"
            class="flex items-center gap-4 px-4 py-3 rounded-lg nav-item {{ request()->routeIs('member.awards.*') ? 'nav-active' : '' }}">
            <i data-feather="star" class="w-5"></i>
            <span class="hidden md:inline">Awards</span>
          </a>


          <a href="{{ route('member.brandings.index') }}"
            class="flex items-center gap-4 px-4 py-3 rounded-lg nav-item {{ request()->routeIs('member.brandings.*') ? 'nav-active' : '' }}">
            <i data-feather="book-open" class="w-5"></i>
            <span class="hidden md:inline">Branding & Media</span>
          </a>


          <a href="{{ route('member.investors.index') }}"
            class="flex items-center gap-4 px-4 py-3 rounded-lg nav-item {{ request()->routeIs('member.investors.*') ? 'nav-active' : '' }}">
            <i data-feather="dollar-sign" class="w-5"></i>
            <span class="hidden md:inline">My Investment</span>
          </a>


          <a href="{{ route('member.csrs.index') }}"
            class="flex items-center gap-4 px-4 py-3 rounded-lg nav-item {{ request()->routeIs('member.csrs.*') ? 'nav-active' : '' }}">
            <i data-feather="heart" class="w-5"></i>
            <span class="hidden md:inline">CSR</span>
          </a>


          <a href="{{ route('member.settings') }}"
            class="flex items-center gap-4 px-4 py-3 rounded-lg nav-item {{ request()->routeIs('member.settings') ? 'nav-active' : '' }}">
            <i data-feather="settings" class="w-5"></i><span class="hidden md:inline">Settings</span>
          </a>

          {{-- ADMIN NAV --}}
        @elseif($role === 'admin')

          <a href="{{ route('admin.dashboard') }}"
            class="flex items-center gap-4 px-4 py-3 rounded-lg nav-item {{ request()->routeIs('admin.dashboard') ? 'nav-active text-red-600 bg-red-50' : 'text-gray-700 hover:bg-red-50 hover:text-red-600' }} transition-colors">
            <i data-feather="home" class="w-5 h-5"></i>
            <span class="hidden md:inline">Dashboard</span>
          </a>

          <a href="{{ route('admin.enquiries.index') }}"
            class="flex items-center gap-4 px-4 py-3 rounded-lg nav-item {{ request()->routeIs('admin.enquiries.index') ? 'nav-active text-red-600 bg-red-50' : 'text-gray-700 hover:bg-red-50 hover:text-red-600' }} transition-colors">
            <i data-feather="message-square" class="w-5 h-5"></i>
            <span class="hidden md:inline">Enquiry</span>
          </a>

          <a href="{{ route('admin.members.index') }}"
            class="flex items-center gap-4 px-4 py-3 rounded-lg nav-item {{ request()->routeIs('admin.members.index') ? 'nav-active text-red-600 bg-red-50' : 'text-gray-700 hover:bg-red-50 hover:text-red-600' }} transition-colors">
            <i data-feather="users" class="w-5 h-5"></i>
            <span class="hidden md:inline">Members</span>
          </a>

          <a href="{{ route('admin.chapters.index') }}"
            class="flex items-center gap-4 px-4 py-3 rounded-lg nav-item {{ request()->routeIs('admin.chapters.*') ? 'nav-active text-red-600 bg-red-50' : 'text-gray-700 hover:bg-red-50 hover:text-red-600' }} transition-colors">
            <i data-feather="map" class="w-5 h-5"></i>
            <span class="hidden md:inline">Chapters</span>
          </a>

          <a href="{{ route('admin.events.index') }}"
   class="flex items-center gap-4 px-4 py-3 rounded-lg nav-item text-gray-700
   {{ request()->routeIs('admin.events.*') && !request()->routeIs('admin.events.attended*') ? 'nav-active' : '' }}">
   
   <i data-feather="calendar" class="w-5 h-5"></i>
   <span>Events</span>
</a>


<a href="{{ route('admin.events.attended') }}"
   class="flex items-center gap-4 px-4 py-3 rounded-lg nav-item text-gray-700
   {{ request()->routeIs('admin.events.attended') || request()->routeIs('admin.events.attendance*') ? 'nav-active' : '' }}">
   
   <i data-feather="check-circle" class="w-5 h-5"></i>
   <span>Event Attendance</span>
</a>



          <a href="{{ route('admin.invitations.index') }}" class="flex items-center gap-4 px-4 py-3 text-gray-700 rounded-lg nav-item 
                {{ request()->routeIs('admin.invitations.*') ? 'nav-active' : '' }}">
            <i data-feather="send" class="w-5 h-5"></i>
            <span class="hidden md:inline">Invitations</span>
          </a>

          <a href="{{ route('admin.recognitions.index') }}"
            class="flex items-center gap-4 px-4 py-3 rounded-lg text-gray-700 nav-item {{ request()->routeIs('admin.recognitions.*') ? 'nav-active' : '' }}">
            <i data-feather="award" class="w-5"></i>
            <span class="hidden md:inline">Recognitions</span>
          </a>

          <a href="{{ route('admin.awards.index') }}"
            class="flex items-center gap-4 px-4 py-3 rounded-lg text-gray-700 nav-item {{ request()->routeIs('admin.awards.*') ? 'nav-active' : '' }}">
            <i data-feather="star" class="w-5"></i>
            <span class="hidden md:inline">Awards</span>
          </a>
          <a href="{{ route('admin.csrs.index') }}"
            class="flex items-center gap-4 px-4 py-3 rounded-lg text-gray-700 nav-item {{ request()->routeIs('admin.csrs.*') ? 'nav-active' : '' }}">
            <i data-feather="heart" class="w-5"></i>
            <span class="hidden md:inline">CSR</span>
          </a>

          {{-- PROGRAM --}}
          <div class="pt-4">
            <p class="px-4 text-xs font-semibold text-gray-400 uppercase">Program</p>

            <a href="{{ route('admin.insights.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-lg nav-item 
                                                                            {{ request()->routeIs('admin.insights.*') ? 'nav-active text-red-600 bg-red-50' : 'text-gray-700 hover:bg-red-50 hover:text-red-600' }} 
                                                                            transition-colors">
              <i data-feather="book-open" class="w-5 h-5"></i>
              <span class="md:inline">Insights</span>
            </a>

          </div>

          {{-- STORY --}}
          <div class="pt-4">
            <p class="px-4 text-xs font-semibold text-gray-400 uppercase">Story</p>

            <a href="{{ route('admin.stories.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-lg nav-item
                                                                    {{ request()->routeIs('admin.stories.*') ? 'nav-active text-red-600 bg-red-50' : 'text-gray-700 hover:bg-red-50 hover:text-red-600' }}
                                                                    transition-colors">
              <i data-feather="book" class="w-5 h-5"></i>
              <span class="md:inline">Stories</span>
            </a>
            <a href="{{ route('admin.meetups.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-lg nav-item
                                                    {{ request()->routeIs('admin.meetups.*') ? 'nav-active text-red-600 bg-red-50' : 'text-gray-700 hover:bg-red-50 hover:text-red-600' }}
                                                    transition-colors">
              <i data-feather="users" class="w-5 h-5"></i>
              <span class="md:inline">Meetups</span>
            </a>


          </div>

          {{-- ARTICLES --}}
          <div class="pt-4">
            <p class="px-4 text-xs font-semibold text-gray-400 uppercase">Articles</p>

            <a href="{{ route('admin.articles.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-lg nav-item
                                                            {{ request()->routeIs('admin.articles.*') ? 'nav-active text-red-600 bg-red-50' : 'text-gray-700 hover:bg-red-50 hover:text-red-600' }}
                                                            transition-colors">
              <i data-feather="file-text" class="w-5 h-5"></i>
              <span class="md:inline">Articles</span>
            </a>

          </div>

          {{-- BUILD YOUR BRAND --}}
          <div class="pt-4">
            <p class="px-4 text-xs font-semibold text-gray-400 uppercase">Build Your Brand</p>

            <a href="{{ route('admin.consultations.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-lg nav-item
                                            {{ request()->routeIs('admin.consultations.*') ? 'nav-active text-red-600 bg-red-50' : 'text-gray-700 hover:bg-red-50 hover:text-red-600' }}
                                            transition-colors">
              <i data-feather="briefcase" class="w-5 h-5"></i>
              <span class="md:inline">Consultations</span>
            </a>

          </div>

          {{-- ADVISORY --}}
          <div class="pt-4">
            <p class="px-4 text-xs font-semibold text-gray-400 uppercase">Advisory</p>

            <a href="{{ route('admin.advisories.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-lg nav-item
                                    {{ request()->routeIs('admin.advisories.*') ? 'nav-active text-red-600 bg-red-50' : 'text-gray-700 hover:bg-red-50 hover:text-red-600' }}
                                    transition-colors">
              <i data-feather="headphones" class="w-5 h-5"></i>
              <span class="md:inline">Advisory Connect</span>
            </a>

          </div>

          {{-- ASSOCIATION --}}
          <div class="pt-4">
            <p class="px-4 text-xs font-semibold text-gray-400 uppercase">Association</p>

            <a href="{{ route('admin.partners.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-lg nav-item
                            {{ request()->routeIs('admin.partners.*') ? 'nav-active text-red-600 bg-red-50' : 'text-gray-700 hover:bg-red-50 hover:text-red-600' }}
                            transition-colors">
              <i data-feather="users" class="w-5 h-5"></i>
              <span class="md:inline">Partners</span>
            </a>

            <a href="{{ route('admin.sponsors.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-lg nav-item
                    {{ request()->routeIs('admin.sponsors.*') ? 'nav-active text-red-600 bg-red-50' : 'text-gray-700 hover:bg-red-50 hover:text-red-600' }}
                    transition-colors">
              <i data-feather="dollar-sign" class="w-5 h-5"></i>
              <span class="md:inline">Sponsors</span>
            </a>
            

          </div>
        @else
          {{-- not logged in / role unknown --}}
          <a href="{{ url('/') }}" class="flex items-center gap-4 px-4 py-3 rounded-lg nav-item">
            <i data-feather="log-in" class="w-5"></i><span class="hidden md:inline">Login</span>
          </a>
        @endif
      </nav>

      {{-- Logout common --}}
      <div class="p-4 border-t">
        @if(auth()->check())
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button
              class="w-full flex bg-red-500 hover:bg-red-600 text-white py-2 rounded-lg items-center justify-center gap-2">
              <i data-feather="log-out" class="w-4"></i><span class="hidden md:inline">Logout</span>
            </button>
          </form>
        @endif
      </div>
    </aside>

    {{-- MOBILE SIDEBAR SLIDE-OVER --}}
    <div id="mobileSidebar" class="fixed inset-0 z-40 hidden" aria-hidden="true">
      <div id="mobileSidebarOverlay" class="absolute inset-0 bg-black/40" aria-hidden="true"></div>

      <aside id="mobilePanel"
        class="absolute left-0 top-0 bottom-0 w-72 bg-white border-r shadow-lg p-4 mobile-slide sidebar-scrollbar flex flex-col h-full"
        role="dialog" aria-modal="true" aria-label="Mobile menu">
        <div class="flex items-center justify-between mb-4">
          <div class="flex items-center gap-3">
            <img src="{{ $assetBase }}/images/newlogo.png" alt="TMN Logo" class="h-10">
          </div>
          <button id="closeMobileSidebar" class="p-2 rounded-md hover:bg-gray-100" aria-label="Close menu">✕</button>
        </div>

        <nav class="flex-1 overflow-y-auto space-y-1 pr-1" aria-label="Main navigation">
          @if($role === 'member')
            <a href=""
              class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors {{ request()->routeIs('member.dashboard') ? 'nav-active' : '' }}">
              <i data-feather="home" class="w-5 h-5"></i>
              <span>Dashboard</span>
            </a>

            <a href="{{ route('member.chapter.events') }}"
              class="flex items-center gap-4 px-4 py-3 rounded-lg nav-item {{ request()->routeIs('member.chapter.events') ? 'nav-active' : '' }}">
              <i data-feather="calendar" class="w-5"></i>
              <span>Chapter Events</span>
            </a>

            <a href="{{ route('member.chapter.attended') }}"
              class="flex items-center gap-4 px-4 py-3 rounded-lg nav-item {{ request()->routeIs('member.chapter.eventattended') ? 'nav-active' : '' }}">
              <i data-feather="check-circle" class="w-5"></i>
              <span>Chapter Attended</span>
            </a>

            <a href="{{ route('member.invitations.index') }}"
              class="flex items-center gap-4 px-4 py-3 rounded-lg nav-item {{ request()->routeIs('member.invitations.*') ? 'nav-active' : '' }}">
              <i data-feather="user-plus" class="w-5"></i>
              <span>Invitations</span>
            </a>

            <a href="{{ route('member.business.index') }}"
              class="flex items-center gap-4 px-4 py-3 rounded-lg nav-item {{ request()->routeIs('member.business.*') ? 'nav-active' : '' }}">
              <i data-feather="briefcase" class="w-5"></i>
              <span>Give &amp; Take</span>
            </a>

            <a href="{{ route('member.meetings.onetoone') }}"
              class="flex items-center gap-4 px-4 py-3 rounded-lg nav-item {{ request()->routeIs('member.meetings.onetoone') ? 'nav-active' : '' }}">
              <i data-feather="users" class="w-5"></i>
              <span>1-1 Meetup</span>
            </a>

            <a href="{{ route('member.meetings.cluster') }}"
              class="flex items-center gap-4 px-4 py-3 rounded-lg nav-item {{ request()->routeIs('member.meetings.cluster') ? 'nav-active' : '' }}">
              <i data-feather="grid" class="w-5"></i>
              <span>Cluster Meeting</span>
            </a>

            <a href="{{ route('member.recognitions.index') }}"
              class="flex items-center gap-4 px-4 py-3 rounded-lg nav-item {{ request()->routeIs('member.recognitions.*') ? 'nav-active' : '' }}">
              <i data-feather="award" class="w-5"></i>
              <span>Recognitions</span>
            </a>

            <a href="{{ route('member.awards.index') }}"
              class="flex items-center gap-4 px-4 py-3 rounded-lg nav-item {{ request()->routeIs('member.awards.*') ? 'nav-active' : '' }}">
              <i data-feather="star" class="w-5"></i>
              <span>Awards</span>
            </a>

            <a href="{{ route('member.brandings.index') }}"
              class="flex items-center gap-4 px-4 py-3 rounded-lg nav-item {{ request()->routeIs('member.brandings.*') ? 'nav-active' : '' }}">
              <i data-feather="book-open" class="w-5"></i>
              <span>Branding &amp; Media</span>
            </a>

            <a href="{{ route('member.investors.index') }}"
              class="flex items-center gap-4 px-4 py-3 rounded-lg nav-item {{ request()->routeIs('member.investors.*') ? 'nav-active' : '' }}">
              <i data-feather="dollar-sign" class="w-5"></i>
              <span>Investors</span>
            </a>

            <a href="{{ route('member.csrs.index') }}"
              class="flex items-center gap-4 px-4 py-3 rounded-lg nav-item {{ request()->routeIs('member.csrs.*') ? 'nav-active' : '' }}">
              <i data-feather="heart" class="w-5"></i>
              <span>CSR</span>
            </a>

            <a href="{{ route('member.settings') }}"
              class="flex items-center gap-4 px-4 py-3 rounded-lg nav-item {{ request()->routeIs('member.settings') ? 'nav-active' : '' }}">
              <i data-feather="settings" class="w-5"></i>
              <span>Settings</span>
            </a>


          @elseif($role === 'admin')
            <a href="{{ route('admin.dashboard') }}"
              class="flex items-center gap-4 px-4 py-3 rounded-lg nav-item {{ request()->routeIs('admin.dashboard') ? 'nav-active text-red-600 bg-red-50' : 'text-gray-700 hover:bg-red-50 hover:text-red-600' }} transition-colors">
              <i data-feather="home" class="w-5 h-5"></i>
              <span class="hidden md:inline">Dashboard</span>
            </a>


            <a href="{{ route('admin.enquiries.index') }}"
              class="flex items-center gap-4 px-4 py-3 rounded-lg nav-item {{ request()->routeIs('admin.enquiries.index') ? 'nav-active' : '' }}">
              <i data-feather="message-square" class="w-5"></i><span class="hidden md:inline">Enquiry</span>
            </a>

            <a href="{{ route('admin.members.index') }}"
              class="flex items-center gap-4 px-4 py-3 rounded-lg nav-item {{ request()->routeIs('admin.members.index') ? 'nav-active' : '' }}">
              <i data-feather="users" class="w-5"></i><span class="hidden md:inline">Members</span>
            </a>
            <a href="{{ route('admin.chapters.index') }}"
              class="flex items-center gap-4 px-4 py-3 rounded-lg nav-item {{ request()->routeIs('admin.chapters.*') ? 'nav-active' : '' }}">
              <i data-feather="map" class="w-5"></i> Chapters
            </a>

            <a href="{{ route('admin.events.index') }}"
              class="flex items-center gap-4 px-4 py-3 rounded-lg nav-item {{ request()->routeIs('admin.events.*') ? 'nav-active' : '' }}">
              <i data-feather="calendar" class="w-5"></i>
              <span class="hidden md:inline">Events</span>
            </a>


            <a href="{{ route('admin.events.attended') }}"
              class="flex items-center gap-4 px-4 py-3 rounded-lg nav-item {{ request()->routeIs('admin.events.attended') || request()->routeIs('admin.events.attendance*') ? 'nav-active' : '' }}">
              <i data-feather="check-circle" class="w-5"></i>
              <span class="hidden md:inline">Event Attendance</span>
            </a>

            <a href=""
              class="flex items-center gap-4 px-4 py-3 rounded-lg nav-item {{ request()->routeIs('admin.settings.*') ? 'nav-active' : '' }}">
              <i data-feather="settings" class="w-5"></i><span class="hidden md:inline">Settings</span>
            </a>

          @else
            <a href="{{ url('/') }}" class="flex items-center gap-4 px-4 py-3 rounded-lg nav-item">
              <i data-feather="log-in" class="w-5"></i> Login
            </a>
          @endif
        </nav>

        <div class="pt-4 border-t mt-4">
          @if(auth()->check())
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button
                class="w-full bg-red-500 hover:bg-red-600 text-white py-2 rounded-lg flex items-center justify-center gap-2"><i
                  data-feather="log-out" class="w-4"></i> Logout</button>
            </form>
          @endif
        </div>
      </aside>
    </div>

    {{-- MAIN CONTENT + HEADER --}}
    <main id="mainContent" class="flex-1 md:ml-64 ml-0">
      <header class="bg-white shadow-md px-4 sm:px-6 py-3 flex justify-between items-center sticky top-0 z-30">
        <div class="flex items-center gap-4">
          <button id="openMobileSidebar" class="md:hidden p-2 rounded-md hover:bg-gray-100" aria-label="Open menu">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>

          @if($role === 'admin')
            <h1 class="text-lg sm:text-xl font-semibold text-red-600 flex items-center gap-2">
              <i data-feather="shield" class="w-4"></i>
              <span class="hidden sm:inline">{{ $adminModule }}</span>
              <span class="inline sm:hidden">{{ $adminModule }}</span>
            </h1>

          @elseif($role === 'member')
            <h1 class="text-lg sm:text-xl font-semibold text-red-600 flex items-center gap-2"><i data-feather="user"
                class="w-4"></i><span class="hidden sm:inline">Member Panel</span><span
                class="inline sm:hidden">Member</span></h1>
          @else
            <h1 class="text-lg sm:text-xl font-semibold text-red-600 flex items-center gap-2"><i data-feather="file-text"
                class="w-4"></i><span class="hidden sm:inline">Welcome</span></h1>
          @endif
        </div>

        {{-- Profile area --}}
        <div class="relative">
          <div id="profileBtn" class="flex items-center gap-3 cursor-pointer hover:opacity-80 transition">
            <div class="relative">
              <div
                class="w-10 h-10 bg-red-500 text-white flex items-center justify-center rounded-xl text-lg font-bold shadow">
                {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
              </div>
              <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></span>
            </div>

            <div class="hidden sm:block">
              <p class="font-medium text-gray-800">{{ $user->name ?? 'Guest' }}</p>
              <p class="text-xs text-gray-500">{{ $role ? ucfirst($role) : 'Visitor' }}</p>
            </div>

            <i id="dropdownArrow" data-feather="chevron-down" class="w-5 h-5 text-gray-600 transition-transform"></i>
          </div>

          <div id="profileDropdown"
            class="absolute right-0 mt-3 w-64 bg-white shadow-xl rounded-2xl border border-gray-100 p-4 dropdown-hidden transform scale-95 opacity-0 transition-all duration-200 z-50">
            <div class="flex items-center gap-4 p-4 rounded-xl bg-red-50 nav-item">
              <div class="relative">
                <div
                  class="w-12 h-12 bg-red-500 text-white flex items-center justify-center rounded-xl text-xl font-bold shadow">
                  {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                </div>
                <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-red-50 rounded-full"></span>
              </div>
              <div>
                <h3 class="font-semibold text-gray-900 text-sm">{{ $user->name ?? 'Guest' }}</h3>
                <p class="text-xs text-gray-500">{{ $user->email ?? '-' }}</p>
              </div>
            </div>



            @if(auth()->check())
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                  class="mt-3 w-full px-4 py-2 rounded-lg bg-red-500 text-white hover:bg-red-600">Logout</button>
              </form>
            @endif
          </div>
        </div>
      </header>

      {{-- Page container --}}
      <div class="max-w-8xl mx-auto px-2 py-2">
        <div class="grid grid-cols-1 gap-6 items-start">
          <div class="container">
            @yield('content')
          </div>
        </div>
      </div>
    </main>
  </div>

  {{-- Scripts --}}
  <script>
    // Activate feather icons
    if (typeof feather !== 'undefined') feather.replace();

    // Mobile sidebar elements
    const openMobileBtn = document.getElementById('openMobileSidebar');
    const mobileSidebar = document.getElementById('mobileSidebar');
    const mobilePanel = document.getElementById('mobilePanel');
    const mobileOverlay = document.getElementById('mobileSidebarOverlay');
    const closeMobileBtn = document.getElementById('closeMobileSidebar');

    function openMobileSidebar() {
      mobileSidebar.classList.remove('hidden');
      setTimeout(() => mobilePanel.classList.add('mobile-open'), 10);
      document.documentElement.style.overflow = 'hidden';
    }
    function closeMobileSidebar() {
      mobilePanel.classList.remove('mobile-open');
      document.documentElement.style.overflow = '';
      setTimeout(() => mobileSidebar.classList.add('hidden'), 220);
    }
    if (openMobileBtn) openMobileBtn.addEventListener('click', openMobileSidebar);
    if (closeMobileBtn) closeMobileBtn.addEventListener('click', closeMobileSidebar);
    if (mobileOverlay) mobileOverlay.addEventListener('click', closeMobileSidebar);

    // Profile dropdown
    const profileBtn = document.getElementById('profileBtn');
    const profileDropdown = document.getElementById('profileDropdown');
    const dropdownArrow = document.getElementById('dropdownArrow');

    if (profileBtn) {
      profileBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        dropdownArrow.classList.toggle('rotate-180');
        profileDropdown.classList.toggle('dropdown-hidden');
        profileDropdown.classList.toggle('dropdown-visible');
      });
    }

    // Click outside to close profile dropdown
    document.addEventListener('click', (ev) => {
      if (profileBtn && profileDropdown && !profileBtn.contains(ev.target) && !profileDropdown.contains(ev.target)) {
        dropdownArrow.classList.remove('rotate-180');
        profileDropdown.classList.add('dropdown-hidden');
        profileDropdown.classList.remove('dropdown-visible');
      }
    });

    // Keep nav-active in sync (simple)
   
    
  </script>

</body>

</html>