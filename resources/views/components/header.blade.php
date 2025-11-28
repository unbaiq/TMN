<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Sticky Sidebar + Sticky Topbar Example</title>

  <!-- Tailwind CDN for quick demo (replace with your build setup in production) -->
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    /* small visual niceties */
    .sidebar-scrollbar::-webkit-scrollbar { width: 8px; }
    .sidebar-scrollbar::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.12); border-radius: 9999px;}
  </style>
</head>
<body class="bg-gray-50 text-gray-800">

  <!-- Page wrapper -->
  <div class="min-h-screen flex">

    <!-- LEFT SIDEBAR -->
    <aside
      id="sidebar"
      class="hidden md:flex md:flex-col w-72 bg-white border-r border-gray-200 h-screen sticky top-0 sidebar-scrollbar overflow-y-auto"
      aria-label="Sidebar">
      <!-- logo -->
      <div class="px-6 pt-6 pb-4 flex items-center gap-3 border-b border-gray-100">
        <div class="w-10 h-10 rounded-lg bg-red-600 flex items-center justify-center text-white font-bold">TMN</div>
        <div>
          <div class="text-sm font-semibold">Top management network</div>
          <div class="text-xs text-gray-500">Super Admin</div>
        </div>
      </div>

      <!-- nav -->
      <nav class="px-2 py-6 space-y-1">
        <a href="#" class="flex items-center gap-3 px-3 py-3 rounded-md hover:bg-gray-50 active-nav">
          <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12h18M3 6h18M3 18h18"/></svg>
          <span class="font-medium">Dashboard</span>
        </a>

        <a href="#" class="flex items-center gap-3 px-3 py-3 rounded-md hover:bg-gray-50">
          <svg class="w-5 h-5 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3M3 11h18M5 21h14a2 2 0 002-2V11H3v8a2 2 0 002 2z"></path></svg>
          <span>Insights</span>
        </a>

        <a href="#" class="flex items-center gap-3 px-3 py-3 rounded-md hover:bg-gray-50">
          <svg class="w-5 h-5 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18"/></svg>
          <span>Chapters</span>
        </a>

        <!-- long list to demonstrate scrollbar -->
        <div class="mt-4 border-t border-gray-100 pt-4">
          <a href="#" class="flex items-center gap-3 px-3 py-3 rounded-md hover:bg-gray-50">Events</a>
          <a href="#" class="flex items-center gap-3 px-3 py-3 rounded-md hover:bg-gray-50">Stories</a>
          <a href="#" class="flex items-center gap-3 px-3 py-3 rounded-md hover:bg-gray-50">CMS Articles</a>
          <a href="#" class="flex items-center gap-3 px-3 py-3 rounded-md hover:bg-gray-50">Partners</a>
          <a href="#" class="flex items-center gap-3 px-3 py-3 rounded-md hover:bg-gray-50">Sponsors</a>
          <a href="#" class="flex items-center gap-3 px-3 py-3 rounded-md hover:bg-gray-50">Logout</a>
        </div>
      </nav>

      <div class="mt-auto px-6 py-6 text-xs text-gray-400">© TMN</div>
    </aside>

    <!-- MAIN CONTENT -->
    <div class="flex-1 min-h-screen flex flex-col">

      <!-- topbar for mobile (and toggle) -->
      <header class="md:hidden bg-white border-b border-gray-200 px-4 py-3 flex items-center justify-between sticky top-0 z-50">
        <div class="flex items-center gap-3">
          <button id="mobileToggle" class="p-2 rounded-md bg-gray-100">
            <!-- hamburger -->
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
          </button>
          <div class="text-lg font-semibold">Insights</div>
        </div>
        <div class="flex items-center gap-3">
          <button class="px-3 py-2 bg-blue-600 text-white rounded-md">Add New</button>
        </div>
      </header>

      <!-- content topbar (sticky) -->
      <div class="bg-white border-b border-gray-200 px-6 py-4 sticky top-0 z-40">
        <div class="flex items-center justify-between gap-4">
          <div class="flex items-center gap-3">
            <h1 class="text-2xl font-semibold">Insights</h1>
            <span class="px-2 py-1 text-sm bg-green-50 text-green-700 rounded-md">13 Total</span>
            <span class="text-sm text-gray-500">Page 1 of 2</span>
          </div>
          <div class="flex items-center gap-3">
            <input type="text" placeholder="Search by Title 1" class="hidden sm:inline-block border rounded-md px-3 py-2 w-64">
            <button class="px-3 py-2 bg-blue-600 text-white rounded-md">Search</button>
          </div>
        </div>
      </div>

      <!-- actual scrollable page content -->
      <main class="p-6 overflow-auto">
        <!-- a wide card to simulate table & many rows -->
        <div class="bg-white border rounded-lg shadow-sm">
          <div class="p-4 border-b">
            <div class="flex items-center justify-between">
              <div class="text-sm text-gray-600">Search & Filters</div>
              <div class="text-xs text-gray-400">13 total records</div>
            </div>
          </div>

          <div class="p-4 space-y-4">
            <!-- fake table header -->
            <div class="grid grid-cols-12 gap-4 items-center text-sm text-gray-500 px-2">
              <div class="col-span-1">Image</div>
              <div class="col-span-3">Title 1</div>
              <div class="col-span-4">Title 2</div>
              <div class="col-span-2">Description</div>
              <div class="col-span-1">Status</div>
              <div class="col-span-1">Actions</div>
            </div>

            <!-- many rows to demonstrate scrolling under sticky topbar -->
            <div class="divide-y">
              <!-- Repeat these rows to create lots of scrollable content -->
              <template id="row-template">
                <div class="grid grid-cols-12 gap-4 items-center px-2 py-4">
                  <div class="col-span-1"><div class="w-10 h-10 bg-gray-100 rounded-md"></div></div>
                  <div class="col-span-3 font-medium">Generate business and</div>
                  <div class="col-span-4 text-gray-600">Reach new heights</div>
                  <div class="col-span-2 text-gray-600">It is very important to...</div>
                  <div class="col-span-1">
                    <span class="inline-flex items-center px-2 py-1 rounded-full bg-green-50 text-green-700 text-xs">Active</span>
                  </div>
                  <div class="col-span-1 text-right">
                    <button class="text-blue-600 text-sm">Edit</button>
                    <button class="text-red-500 text-sm ml-2">Del</button>
                  </div>
                </div>
              </template>

              <!-- script will clone many rows -->
              <div id="rows-container"></div>

            </div>
          </div>
        </div>

        <!-- footer spacing so content is long -->
        <div class="h-40"></div>
      </main>
    </div>
  </div>

  <!-- Mobile sidebar slide-over -->
  <div id="mobileSidebar" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/30" id="mobileOverlay"></div>
    <div class="absolute left-0 top-0 bottom-0 w-72 bg-white border-r shadow-lg overflow-y-auto p-4">
      <div class="flex items-center justify-between mb-4">
        <div class="text-lg font-semibold">Menu</div>
        <button id="mobileClose" class="p-2 rounded-md bg-gray-100">
          ✕
        </button>
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
    for (let i = 0; i < 30; i++) {
      const node = template.cloneNode(true);
      // optional: change some text
      node.querySelector('.font-medium').textContent = `Insight title ${i+1}`;
      node.querySelector('.text-gray-600').textContent = `Subtitle or short description ${i+1}`;
      rowsContainer.appendChild(node);
    }

    // mobile sidebar toggles
    const mobileToggle = document.getElementById('mobileToggle');
    const mobileSidebar = document.getElementById('mobileSidebar');
    const mobileClose = document.getElementById('mobileClose');
    const mobileOverlay = document.getElementById('mobileOverlay');
    function openMobile() { mobileSidebar.classList.remove('hidden'); }
    function closeMobile() { mobileSidebar.classList.add('hidden'); }
    if (mobileToggle) mobileToggle.addEventListener('click', openMobile);
    if (mobileClose) mobileClose.addEventListener('click', closeMobile);
    if (mobileOverlay) mobileOverlay.addEventListener('click', closeMobile);

    // highlight active nav (just demo)
    document.querySelectorAll('aside nav a').forEach(a => {
      a.addEventListener('click', e => {
        document.querySelectorAll('aside nav a').forEach(x => x.classList.remove('bg-gray-50', 'text-blue-600'));
        e.currentTarget.classList.add('bg-gray-50', 'text-blue-600');
      });
    });
  </script>

</body>
</html>
