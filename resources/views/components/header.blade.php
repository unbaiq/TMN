<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>TMN — Dashboard (topbar + sidebar)</title>

  <!-- Inter font -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">

  <!-- Tailwind CDN for quick demo -->
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    :root{
      --tmn-red: #e53935;
      --muted: #6b7280;
    }
    html,body { font-family: "Inter", ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial; }

    /* scrollbar nicety for sidebar */
    .sidebar-scrollbar::-webkit-scrollbar { width: 8px; }
    .sidebar-scrollbar::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.12); border-radius: 9999px;}

    /* little avatar badge */
    .online-dot { width:10px; height:10px; border-radius:9999px; border:2px solid white; background:#22c55e; display:inline-block; box-shadow:0 0 0 2px rgba(34,197,94,0.08); }

    /* active link */
    .nav-active { background: rgba(229,57,53,0.06); color: var(--tmn-red); }
    .icon { color: #4b5563; }
  </style>
</head>
<body class="bg-gray-50 text-gray-800 min-h-screen">

  <div class="min-h-screen flex">

    <!-- LEFT SIDEBAR -->
    <aside id="sidebar"
      class="hidden md:flex md:flex-col w-72 bg-white border-r border-gray-200 h-screen sticky top-0 sidebar-scrollbar overflow-y-auto"
      aria-label="Sidebar">

      <!-- logo -->
      <div class="px-6 pt-6 pb-4 flex items-center gap-3 border-b border-gray-100">
        <div class="w-10 h-10 rounded-lg bg-[color:var(--tmn-red)] flex items-center justify-center text-white font-bold shadow-sm">TMN</div>
        <div>
          <div class="text-sm font-semibold">Top management network</div>
          <div class="text-xs text-gray-500">Super Admin</div>
        </div>
      </div>

      <!-- nav -->
      <nav class="px-2 py-6 space-y-1">

        <!-- Dashboard -->
        <a href="#" class="flex items-center gap-3 px-3 py-3 rounded-md hover:bg-gray-50 nav-active">
          <!-- heroicon: home -->
          <svg class="w-5 h-5 icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 12l9-7 9 7v7a2 2 0 0 1-2 2h-4a2 2 0 0 1-2-2v-4H9v4a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-7z"/>
          </svg>
          <span class="font-medium">Dashboard</span>
        </a>

        <!-- Enquiry -->
        <a href="#" class="flex items-center gap-3 px-3 py-3 rounded-md hover:bg-gray-50">
          <!-- heroicon: chat-alt-2 -->
          <svg class="w-5 h-5 icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 8h10M7 12h6M3 5.5A2.5 2.5 0 015.5 3h13A2.5 2.5 0 0121 5.5v8A2.5 2.5 0 0118.5 16H9l-5 4V5.5z"/>
          </svg>
          <span>Enquiry</span>
        </a>

        <!-- ================= MEMBERS DROPDOWN ================= -->
        <div x-data="{ open:false }" class="px-0">
          <button @click="open=!open" class="w-full flex items-center justify-between px-3 py-3 hover:bg-gray-50 rounded-md">
            <span class="flex items-center gap-3">
              <!-- heroicon: users -->
              <svg class="w-5 h-5 icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20v-1a4 4 0 00-3-3.87M9 20v-1a4 4 0 013-3.87M12 12a4 4 0 100-8 4 4 0 000 8zM3 20a4 4 0 014-4h.5"/>
              </svg>
              Members
            </span>
            <svg class="w-4 h-4 transform transition" :class="{'rotate-180':open}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
          </button>

          <div x-show="open" x-collapse class="ml-10 mt-2 space-y-2">
            <a href="#" class="block px-3 py-2 text-sm hover:bg-gray-100 rounded-md">Member List</a>
            <a href="#" class="block px-3 py-2 text-sm hover:bg-gray-100 rounded-md">Assigned Members</a>
          </div>
        </div>

        <!-- ================= CHAPTERS DROPDOWN ================= -->
        <div x-data="{ open:false }" class="px-0">
          <button @click="open=!open" class="w-full flex items-center justify-between px-3 py-3 hover:bg-gray-50 rounded-md">
            <span class="flex items-center gap-3">
              <!-- heroicon: collection -->
              <svg class="w-5 h-5 icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 7h18M3 12h18M3 17h18"/>
              </svg>
              Chapters
            </span>
            <svg class="w-4 h-4 transform transition" :class="{'rotate-180':open}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
          </button>

          <div x-show="open" x-collapse class="ml-10 mt-2 space-y-2">
            <a href="#" class="block px-3 py-2 text-sm hover:bg-gray-100 rounded-md">Chapters</a>
            <a href="#" class="block px-3 py-2 text-sm hover:bg-gray-100 rounded-md">Chapter Events</a>
            <a href="#" class="block px-3 py-2 text-sm hover:bg-gray-100 rounded-md">Chapter Activity</a>
            <a href="#" class="block px-3 py-2 text-sm hover:bg-gray-100 rounded-md">Cluster Meeting</a>
            <a href="#" class="block px-3 py-2 text-sm hover:bg-gray-100 rounded-md">Seminars</a>
          </div>
        </div>

        <!-- ================= EVENTS DROPDOWN ================= -->
        <div x-data="{ open:false }" class="px-0">
          <button @click="open=!open" class="w-full flex items-center justify-between px-3 py-3 hover:bg-gray-50 rounded-md">
            <span class="flex items-center gap-3">
              <!-- heroicon: calendar -->
              <svg class="w-5 h-5 icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3M3 11h18M5 21h14a2 2 0 002-2V7H3v12a2 2 0 002 2z"/>
              </svg>
              Events
            </span>
            <svg class="w-4 h-4 transform transition" :class="{'rotate-180':open}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
          </button>

          <div x-show="open" x-collapse class="ml-10 mt-2 space-y-2">
            <a href="#" class="block px-3 py-2 text-sm hover:bg-gray-100 rounded-md">Events</a>
            <a href="#" class="block px-3 py-2 text-sm hover:bg-gray-100 rounded-md">Registrations</a>
          </div>
        </div>

        <!-- Awards (separate) -->
        <a href="#" class="flex items-center gap-3 px-3 py-3 rounded-md hover:bg-gray-50">
          <!-- heroicon: award (medal) -->
          <svg class="w-5 h-5 icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8c1.657 0 3-1.343 3-3S13.657 2 12 2 9 3.343 9 5s1.343 3 3 3zM6 20l3-3 3 3 3-3 3 3"/>
          </svg>
          Awards
        </a>

        <!-- CSR (separate) -->
        <a href="#" class="flex items-center gap-3 px-3 py-3 rounded-md hover:bg-gray-50">
          <!-- heroicon: check-circle -->
          <svg class="w-5 h-5 icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/>
          </svg>
          CSR
        </a>
       

      </nav>

      <div class="mt-auto p-4">
    <form >
        
        <button type="submit"
            class="w-full flex items-center gap-3 px-4 py-3 bg-red-600 hover:bg-red-700 text-white font-medium rounded-xl shadow-sm transition">
            
            <!-- logout icon -->
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 11-6 0V7a3 3 0 016 0v1" />
            </svg>

            Logout
        </button>
    </form>
</div>
    </aside>

    <!-- MAIN CONTENT (note min-h-0 to allow inner scrolling) -->
    <div class="flex-1 flex flex-col min-h-0">

      <!-- TOP BAR -->
      <div class="bg-white border-b border-gray-200 px-6 py-3 sticky top-0 z-40 flex items-center justify-between">
        <div class="flex items-center gap-4">
          <button id="sidebarToggle" class="md:hidden p-2 rounded-md bg-gray-100" aria-label="Open menu">
            <svg class="w-5 h-5 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
          </button>
          
        </div>

        <div class="flex items-center gap-4">
       

          <!-- avatar card -->
          <div class="flex items-center gap-3 bg-white rounded-xl px-3 py-2 shadow-sm border border-transparent hover:border-gray-100">
            <div class="relative">
              <img src="https://i.pravatar.cc/100?u=superadmin" alt="avatar" class="w-10 h-10 rounded-lg object-cover shadow-md">
              <span class="absolute -bottom-0.5 -right-0.5 online-dot" title="online"></span>
            </div>

            <div class="text-right">
              <div class="text-sm font-semibold">Super Admin</div>
              <div class="text-xs text-gray-400">Super Admin</div>
            </div>

            <button class="ml-2 p-1 rounded-md text-gray-400 hover:text-gray-600" aria-label="Open profile menu">
              <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
              </svg>
            </button>
          </div>
        </div>
      </div>

    
    

  <!-- Mobile sidebar -->
  <div id="mobileSidebar" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/30" id="mobileOverlay"></div>
    <div class="absolute left-0 top-0 bottom-0 w-72 bg-white border-r shadow-lg overflow-y-auto p-4">
      <div class="flex items-center justify-between mb-4">
        <div class="text-lg font-semibold">Menu</div>
        <button id="mobileClose" class="p-2 rounded-md bg-gray-100">✕</button>
      </div>
      <nav class="space-y-2">
        <a class="block px-3 py-2 rounded-md hover:bg-gray-50">Dashboard</a>
        <a class="block px-3 py-2 rounded-md hover:bg-gray-50">Insights</a>
        <a class="block px-3 py-2 rounded-md hover:bg-gray-50">Chapters</a>
        <a class="block px-3 py-2 rounded-md hover:bg-gray-50">Events</a>
      </nav>
    </div>
  </div>

  <script>
    // create many demo rows
    const rowsContainer = document.getElementById('rows-container');
    const template = document.getElementById('row-template').content;
    for (let i = 0; i < 20; i++) {
      const node = template.cloneNode(true);
      node.querySelector('.font-medium').textContent = `Insight title ${i+1}`;
      node.querySelector('.text-gray-600').textContent = `Subtitle or short description ${i+1}`;
      rowsContainer.appendChild(node);
    }

    // mobile sidebar toggles
    const sidebarToggle = document.getElementById('sidebarToggle');
    const mobileSidebar = document.getElementById('mobileSidebar');
    const mobileClose = document.getElementById('mobileClose');
    const mobileOverlay = document.getElementById('mobileOverlay');
    function openMobile() { mobileSidebar.classList.remove('hidden'); }
    function closeMobile() { mobileSidebar.classList.add('hidden'); }
    if (sidebarToggle) sidebarToggle.addEventListener('click', openMobile);
    if (mobileClose) mobileClose.addEventListener('click', closeMobile);
    if (mobileOverlay) mobileOverlay.addEventListener('click', closeMobile);

    // highlight active nav (just demo)
    document.querySelectorAll('aside nav a').forEach(a => {
      a.addEventListener('click', e => {
        document.querySelectorAll('aside nav a').forEach(x => x.classList.remove('bg-gray-50', 'text-[color:var(--tmn-red)]','nav-active'));
        e.currentTarget.classList.add('bg-gray-50','nav-active');
      });
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
