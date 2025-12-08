<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>TMN Admin Dashboard — Responsive</title>

  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Feather icons -->
  <script src="https://unpkg.com/feather-icons"></script>

  <style>
    /* Animated Active Item */
    .nav-active {
      background: linear-gradient(to right, #ffe6e6, #ffffff);
      border-right: 4px solid #e53935;
      box-shadow: inset 0 0 10px rgba(229, 57, 53, 0.15);
    }
    /* Hover Glow Animation */
    .nav-item:hover {
      background: rgba(255, 100, 100, 0.08);
      transition: 0.25s ease-in-out;
      transform: translateX(4px);
    }

    /* Dropdown helper classes */
    .dropdown-hidden { display: none; }
    .dropdown-visible {
      display: block !important;
      opacity: 1 !important;
      transform: scale(1) !important;
    }

    /* Sidebar scrollbar nicety */
    .sidebar-scrollbar::-webkit-scrollbar { width: 8px; }
    .sidebar-scrollbar::-webkit-scrollbar-thumb {
      background: rgba(0,0,0,0.12);
      border-radius: 9999px;
    }

    /* Small improvement: smooth slide for mobile sidebar */
    .mobile-slide {
      transform: translateX(-100%);
      transition: transform 240ms ease-in-out;
    }
    .mobile-open {
      transform: translateX(0);
    }
  </style>
</head>
<body class="bg-gray-100 font-sans antialiased">

  <!-- PAGE WRAPPER -->
  <div class="min-h-screen flex">

    <!-- ========== DESKTOP SIDEBAR (visible md+) ========== -->
    <aside id="desktopSidebar"
           class="hidden md:flex flex-col w-64 bg-white h-screen fixed top-0 left-0 shadow-xl sidebar-scrollbar"
           aria-label="Main sidebar">
      <!-- Logo -->
      <div class="flex items-center gap-3 px-6 py-5 border-b">
        <img  src="{{ asset('images/logo1.png') }}"  alt="TMN Logo" class="h-10 a">
       
      </div>

      <!-- Nav -->
 <nav class="flex-1 overflow-y-auto px-2 py-4 space-y-1">

  <!-- Dashboard -->
  <a href="{{ route('admin.dashboard') }}"
     class="flex items-center gap-4 px-4 py-3 rounded-lg nav-item nav-active">
    <span class="nav-icon"><i data-feather="home" class="w-5 h-5"></i></span>
    <span class="hidden md:inline">Dashboard</span>
  </a>

  <!-- Enquiry -->
  <a href="{{ route('admin.member.enquiry') }}"
     class="flex items-center gap-4 px-4 py-3 rounded-lg nav-item">
    <span class="nav-icon"><i data-feather="message-square" class="w-5 h-5"></i></span>
    <span class="hidden md:inline">Enquiry</span>
  </a>

  <!-- Members -->
  <a href="{{ route('admin.member.memberlist') }}"
     class="flex items-center gap-4 px-4 py-3 rounded-lg nav-item">
    <span class="nav-icon"><i data-feather="users" class="w-5 h-5"></i></span>
    <span class="hidden md:inline">Members</span>
  </a>

  <!-- Assigned Members -->
  <a href="{{ route('admin.member.list') }}"
     class="flex items-center gap-4 px-4 py-3 rounded-lg nav-item">
    <span class="nav-icon"><i data-feather="user-check" class="w-5 h-5"></i></span>
    <span class="hidden md:inline">Assigned Members</span>
  </a>

  <!-- Chapters -->
  <a href="{{ route('admin.chapter.index') }}"
     class="flex items-center gap-4 px-4 py-3 rounded-lg nav-item">
    <span class="nav-icon"><i data-feather="map" class="w-5 h-5"></i></span>
    <span class="hidden md:inline">Chapters</span>
  </a>

  <!-- Events (Not created yet) -->
  <a href="{{ route('admin.dashboard.events') }}" class="flex items-center gap-4 px-4 py-3 rounded-lg nav-item">
    <span class="nav-icon"><i data-feather="calendar" class="w-5 h-5"></i></span>
    <span class="hidden md:inline">Events</span>
  </a>

  <!-- Awards -->
  <a href="{{ route('admin.awards.index') }}"
     class="flex items-center gap-4 px-4 py-3 rounded-lg nav-item">
    <span class="nav-icon"><i data-feather="award" class="w-5 h-5"></i></span>
    <span class="hidden md:inline">Awards</span>
  </a>

  <!-- Settings -->
  <a href="{{ route('admin.settings.index') }}"
     class="flex items-center gap-4 px-4 py-3 rounded-lg nav-item">
    <span class="nav-icon"><i data-feather="settings" class="w-5 h-5"></i></span>
    <span class="hidden md:inline">Settings</span>
  </a>

</nav>


      <!-- Logout -->
      <div class="p-4 border-t">
      <a href="#" 
         class="w-full flex bg-red-500 hover:bg-red-600 text-white py-2 rounded-lg items-center justify-center gap-2 shadow-md text-center"
         aria-label="Logout">
        <i data-feather="log-out" class="w-4"></i>
        <span class="hidden md:inline">Logout</span>
      </a>
    </div>

    </aside>

    
   

    <!-- ========== MOBILE SIDEBAR SLIDE-OVER ========== -->
   <div id="mobileSidebar" class="fixed inset-0 z-40 hidden" aria-hidden="true">
  <!-- overlay -->
  <div id="mobileSidebarOverlay" class="absolute inset-0 bg-black/40" aria-hidden="true"></div>

  <!-- panel -->
  <aside id="mobilePanel"
         class="absolute left-0 top-0 bottom-0 w-72 bg-white border-r shadow-lg p-4 mobile-slide sidebar-scrollbar flex flex-col h-full"
         role="dialog" aria-modal="true" aria-label="Mobile menu">

    <!-- header -->
    <div class="flex items-center justify-between mb-4">
      <div class="flex items-center gap-3">
        <img src="logo1.png" alt="TMN Logo" class="h-10">
      </div>
      <button id="closeMobileSidebar" class="p-2 rounded-md hover:bg-gray-100" aria-label="Close menu">✕</button>
    </div>

    <!-- navigation (scrollable) -->
    <nav class="flex-1 overflow-y-auto space-y-1 pr-1" aria-label="Main navigation">
      <a href="dashboard.html" class="flex items-center gap-4 px-4 py-3 rounded-lg nav-item nav-active">
        <i data-feather="home" class="w-5"></i> <span>Dashboard</span>
      </a>

      <a href="enquiry.html" class="flex items-center gap-4 px-4 py-3 rounded-lg nav-item">
        <i data-feather="calendar" class="w-5"></i> <span>Enquiry</span>
      </a>

      <a href="" class="flex items-center gap-4 px-4 py-3 rounded-lg nav-item">
        <i data-feather="check-circle" class="w-5"></i> <span>Members</span>
      </a>

      <a href="" class="flex items-center gap-4 px-4 py-3 rounded-lg nav-item">
        <i data-feather="share-2" class="w-5"></i> <span>Assigned Members</span>
      </a>

      <a href="" class="flex items-center gap-4 px-4 py-3 rounded-lg nav-item">
        <i data-feather="send" class="w-5"></i> <span>Chapters</span>
      </a>

      <a href="" class="flex items-center gap-4 px-4 py-3 rounded-lg nav-item">
        <i data-feather="download" class="w-5"></i> <span>Events</span>
      </a>

      <a href="" class="flex items-center gap-4 px-4 py-3 rounded-lg nav-item">
        <i data-feather="briefcase" class="w-5"></i> <span>Awards</span>
      </a>

      

      <a href="settings.html" class="flex items-center gap-4 px-4 py-3 rounded-lg nav-item">
        <i data-feather="settings" class="w-5"></i> <span>Settings</span>
      </a>

      <div class="h-6"></div>
    </nav>

    <!-- logout (fixed at bottom) -->
    <div class="pt-4 border-t mt-4">
      <a href="login.html"
         class="w-full bg-red-500 hover:bg-red-600 text-white py-2 rounded-lg flex items-center justify-center gap-2 shadow-md text-center"
         aria-label="Logout">
        <i data-feather="log-out" class="w-4"></i> Logout
      </a>
    </div>
  </aside>
</div>

    <!-- ========== MAIN CONTENT ========== -->
    <main id="mainContent" class="flex-1 md:ml-64 ml-0">
      <!-- Header -->
      <header class="bg-white shadow-md px-4 sm:px-6 py-3 flex justify-between items-center sticky top-0 z-30">
        <div class="flex items-center gap-4">
          <!-- Hamburger (mobile) -->
          <button id="openMobileSidebar" class="md:hidden p-2 rounded-md hover:bg-gray-100" aria-label="Open menu">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
          </button>
@php
    // safe route name (string)
    $routeName = optional(request()->route())->getName() ?? '';
    $routeNameLower = strtolower($routeName);
    // helper boolean: any route name that looks like events
    $isEvents = str_contains($routeNameLower, 'events') ||
                request()->routeIs('admin.events.*') ||
                request()->routeIs('events.*') ||
                request()->routeIs('admin.dashboard.events') ||
                request()->routeIs('dashboard.events');
@endphp

<h1 class="text-lg sm:text-xl font-semibold text-red-600 flex items-center gap-2">
  {{-- ICON --}}
  @if(request()->routeIs('admin.dashboard') || request()->routeIs('dashboard'))
    <i data-feather="home" class="w-4"></i>

  @elseif($isEvents)
    <i data-feather="calendar" class="w-4"></i>

  @elseif(request()->routeIs('admin.awards.*') || request()->routeIs('awards.*') || str_contains($routeNameLower, 'award'))
    <i data-feather="award" class="w-4"></i>

  @elseif(request()->routeIs('admin.member.enquiry') || request()->routeIs('member.enquiry') || str_contains($routeNameLower, 'enquiry'))
    <i data-feather="message-square" class="w-4"></i>

  @elseif(request()->routeIs('admin.member.*') || request()->routeIs('member.*'))
    <i data-feather="users" class="w-4"></i>

  @elseif(request()->routeIs('admin.chapter.*') || request()->routeIs('chapter.*'))
    <i data-feather="map" class="w-4"></i>

  @elseif(request()->routeIs('admin.settings.*') || request()->routeIs('settings.*'))
    <i data-feather="settings" class="w-4"></i>

  @else
    <i data-feather="file-text" class="w-4"></i>
  @endif

  {{-- PAGE TITLE (desktop) --}}
  <span class="hidden sm:inline">
    @if(request()->routeIs('admin.dashboard') || request()->routeIs('dashboard'))
      Dashboard Overview

    @elseif($isEvents)
      Events

    @elseif(request()->routeIs('admin.awards.*') || request()->routeIs('awards.*') || str_contains($routeNameLower, 'award'))
      Awards

    @elseif(request()->routeIs('admin.member.enquiry') || request()->routeIs('member.enquiry') || str_contains($routeNameLower, 'enquiry'))
      Enquiry

    @elseif(
        request()->routeIs('admin.member.list') ||
        request()->routeIs('admin.member.memberlist') ||
        request()->routeIs('member.list') ||
        request()->routeIs('member.memberlist') ||
        str_contains($routeNameLower, 'assigned')
    )
      Assigned Members

    @elseif(request()->routeIs('admin.member.*') || request()->routeIs('member.*'))
      Members

    @elseif(request()->routeIs('admin.chapter.*') || request()->routeIs('chapter.*'))
      Chapters

    @elseif(request()->routeIs('admin.settings.*') || request()->routeIs('settings.*'))
      Settings

    @else
      Admin Panel
    @endif
  </span>

  {{-- PAGE TITLE (mobile) --}}
  <span class="inline sm:hidden text-sm text-gray-600">
    @if(request()->routeIs('admin.dashboard') || request()->routeIs('dashboard'))
      Overview
    @elseif($isEvents)
      Events
    @elseif(request()->routeIs('admin.awards.*') || request()->routeIs('awards.*') || str_contains($routeNameLower, 'award'))
      Awards
    @elseif(request()->routeIs('admin.member.*') || request()->routeIs('member.*') || str_contains($routeNameLower, 'enquiry'))
      Members
    @elseif(request()->routeIs('admin.chapter.*') || request()->routeIs('chapter.*'))
      Chapters
    @elseif(request()->routeIs('admin.settings.*') || request()->routeIs('settings.*'))
      Settings
    @else
      Admin
    @endif
  </span>
</h1>

{{-- ensure icons render --}}
@if (isset($feather) || true)
  @pushonce('feather-replace')
  <script> if (typeof feather !== 'undefined') feather.replace(); </script>
  @endpushonce
@endif


        </div>

        <!-- Profile -->
        <div class="relative">
          <div id="profileBtn" class="flex items-center gap-3 cursor-pointer hover:opacity-80 transition">
            <div class="relative">
              <div class="w-10 h-10 bg-red-500 text-white flex items-center justify-center rounded-xl text-lg font-bold shadow">M</div>
              <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></span>
            </div>

            <div class="hidden sm:block">
              <p class="font-medium text-gray-800">Admin</p>
              <p class="text-xs text-gray-500">Admin</p>
            </div>

            <i id="dropdownArrow" data-feather="chevron-down" class="w-5 h-5 text-gray-600 transition-transform"></i>
          </div>

          <div id="profileDropdown" class="absolute right-0 mt-3 w-64 bg-white shadow-xl rounded-2xl border border-gray-100 p-4 dropdown-hidden transform scale-95 opacity-0 transition-all duration-200 z-50">
            <div class="flex items-center gap-4 p-4 rounded-xl bg-red-50 nav-item">
              <div class="relative">
                <div class="w-12 h-12 bg-red-500 text-white flex items-center justify-center rounded-xl text-xl font-bold shadow">M</div>
                <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-red-50 rounded-full"></span>
              </div>
              <div>
                <h3 class="font-semibold text-gray-900 text-sm">Admin</h3>
                <p class="text-xs text-gray-500">Admin</p>
                <div class="flex items-center gap-1 mt-1">
                  <span class="w-2 h-2 rounded-full bg-green-500"></span>
                  <span class="text-xs font-medium text-green-600">Online</span>
                </div>
              </div>
            </div>

            <button class="mt-4 flex items-center gap-2 text-red-600 font-medium px-4 py-2 rounded-lg hover:bg-red-50 transition w-full nav-item">
              <i data-feather="user" class="w-4"></i> Profile
            </button>
          </div>
        </div>
      </header>
