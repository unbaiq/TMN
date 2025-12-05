@include('components.memberheader')
<style>
    .nav-active {
      background: linear-gradient(to right, #ffe6e6, #ffffff);
      border-right: 4px solid #e53935;
      box-shadow: inset 0 0 10px rgba(229, 57, 53, 0.15);
    }
    .nav-item:hover {
      background: rgba(255, 100, 100, 0.08);
      transition: 0.25s ease-in-out;
      transform: translateX(4px);
    }
    
    .dropdown-hidden { display: none; }
    .dropdown-visible {
        display: block !important;
        opacity: 1 !important;
        transform: scale(1) !important;
    }

    .sidebar-scrollbar::-webkit-scrollbar { width: 8px; }
    .sidebar-scrollbar::-webkit-scrollbar-thumb {
      background: rgba(0,0,0,0.12);
      border-radius: 9999px;
    }

    .mobile-slide { transform: translateX(-100%); transition: transform .25s ease; }
    .mobile-open { transform: translateX(0); }

    /* hide scrollbar where you used "no-scrollbar" */
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    
    /* PREMIUM SIDEBAR NAV ITEMS */
    .nav-item {
      border-radius: 0.75rem;
      transition: all 0.2s ease;
    }
    .nav-item i {
      width: 18px;
    }
    
    /* PREMIUM HEADER EFFECT */
    header.bg-white.shadow {
        box-shadow: 0 4px 20px rgba(15, 23, 42, 0.08);
        border-bottom: 1px solid rgba(148, 163, 184, 0.35);
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.9);
    }

    /* EVENTS GRID APPEAR ANIMATION */
    #eventsGrid {
      animation: fadeInGrid 0.25s ease-out;
    }
    @keyframes fadeInGrid {
      from { opacity: 0; transform: translateY(4px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    /* PREMIUM EVENT CARD STYLE (Gradient header band + elevation) */
    .event-card {
      position: relative;
      border-radius: 1rem;
      overflow: hidden;
      background: linear-gradient(to bottom right, #f4f5ff, #ffffff);
      box-shadow: 0 12px 30px rgba(15, 23, 42, 0.08);
      border-color: rgba(226, 232, 240, 0.9) !important;
      transition:
      transform 0.2s ease,
      box-shadow 0.2s ease,
      border-color 0.2s ease,
      background 0.2s ease;
    }

    .event-card::before {
      content: "";
      position: absolute;
      inset: 0;
      height: 50px;
      background: linear-gradient(135deg, #e11d48, #1f2937);
      opacity: 0.18;
      pointer-events: none;
    }

    .event-card > * {
      position: relative;
      z-index: 1;
    }

    .event-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 18px 40px rgba(15, 23, 42, 0.14);
      border-color: rgba(148, 163, 184, 0.7) !important;
    }

    /* FILTER PILL BUTTONS */
    .filter-btn {
      box-shadow: 0 4px 10px rgba(15, 23, 42, 0.06);
      transition: background 0.2s ease, color 0.2s ease, transform 0.15s ease, box-shadow 0.15s ease;
    }
    
    .filter-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(15, 23, 42, 0.08);
    }

    /* Give the active-looking state a premium feel */
    .filter-btn.active-filter {
      box-shadow: 0 10px 22px rgba(15, 23, 42, 0.35);
      background: linear-gradient(to right, #1f2937, #111827) !important;
      color: #ffffff !important;
    }

    /* MODAL PREMIUM GLOW + SCALE ANIMATION */
    #eventModal .max-w-md {
      border-radius: 1.25rem;
      box-shadow: 0 22px 45px rgba(15, 23, 42, 0.45);
      border: 1px solid rgba(148, 163, 184, 0.45);
      background:
      radial-gradient(circle at top left, rgba(248, 113, 113, 0.18), transparent 55%),
      #ffffff;
      transform: scale(0.96);
      transition: transform 0.18s ease, opacity 0.18s ease;
    }
    
    /* when modal visible (not .hidden) we upscale */
    #eventModal:not(.hidden) .max-w-md {
        transform: scale(1);
    }

    /* PAGINATION BUTTONS PREMIUM STYLE */
    .mt-10.gap-2 button {
      border-radius: 9999px;
      transition: all 0.18s ease;
    }
    
    .mt-10.gap-2 button:hover {
        transform: translateY(-1px);
        box-shadow: 0 8px 18px rgba(15, 23, 42, 0.12);
    }
    
    .mt-10.gap-2 button[class*="bg-\[#2C3E50\]"] {
        box-shadow: 0 10px 25px rgba(15, 23, 42, 0.35);
    }
  </style>
  <!-- MAIN CONTENT -->
  <main class="flex-1 md:ml-64">
 <!-- CONTENT WRAPPER -->
 <div class="p-6 sm:p-10">
     <!-- PAGE TITLE -->
     <h2 class="text-2xl font-semibold text-[#2C3E50] mb-6">Chapter Events</h2>
     
     <!-- SEARCH + FILTERS -->
     <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
         
         <!-- Modern Search Bar -->
         <div class="relative w-full md:w-1/2">
             <i data-feather="search"
             class="w-5 h-5 text-gray-500 absolute left-3 top-1/2 -translate-y-1/2"></i>
             
             <input type="text"
             placeholder="Search events..."
             class="w-full pl-11 pr-4 py-2.5 bg-white border border-gray-300 rounded-xl shadow-sm
             focus:outline-none focus:ring-2 focus:ring-[#2C3E50] transition-all">
            </div>
            
            <!-- Filter Pills -->
            <div class="flex gap-3 overflow-x-auto pb-1 no-scrollbar">
                
                <button class="filter-btn active-filter px-5 py-2 rounded-full text-sm font-medium 
                text-gray-800 hover:bg-gray-100 transition"
                data-filter="all">
                All
            </button>
            
            <button class="filter-btn px-5 py-2 rounded-full text-sm font-medium 
            bg-white border border-gray-300 text-gray-800 hover:bg-gray-100 transition"
            data-filter="upcoming">
            Upcoming
        </button>
        
        <button class="filter-btn px-5 py-2 rounded-full text-sm font-medium
        bg-white border border-gray-300 text-gray-800 hover:bg-gray-100 transition"
        data-filter="completed">
        Completed
    </button>
    
    <button class="filter-btn px-5 py-2 rounded-full text-sm font-medium
    bg-white border border-gray-300 text-gray-800 hover:bg-gray-100 transition"
    data-filter="active">
    Active
</button>

</div>

</div>

<!-- EVENTS GRID -->
<div id="eventsGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    
    <!-- EVENT 1 — ACTIVE -->
    <div class="event-card bg-white p-5 rounded-xl shadow-md hover:shadow-lg transition-all border"
    data-status="active">
    
    <h3 class="text-lg font-semibold text-[#2C3E50] mb-2">TMN Leadership Meetup</h3>
    
    <p class="text-sm text-gray-600 flex items-center gap-1">
        <i data-feather="map-pin" class="w-4"></i>
        Mumbai Chapter
    </p>
    
    <p class="text-sm text-gray-600 flex items-center gap-1">
        <i data-feather="calendar" class="w-4"></i>
            10 December 2025
        </p>
        
        <p class="text-sm text-gray-600 flex items-center gap-1 mb-3">
            <i data-feather="clock" class="w-4"></i>
            4:00 PM – 6:00 PM
        </p>
        
        <span class="inline-block px-3 py-1 text-xs bg-green-100 text-green-700 rounded-full">
            Active
        </span>

        <button
            onclick="openEventModal('TMN Leadership Meetup','Mumbai Chapter','10 December 2025','4:00 PM – 6:00 PM','This is a leadership meetup.', 1)"
            class="mt-4 w-full bg-[#2C3E50] hover:bg-[#1B2631] text-white py-2 rounded-lg flex gap-2 justify-center transition">
            <i data-feather="arrow-right"></i>
            View Details
        </button>
    </div>
    
    
    <!-- EVENT 2 — COMPLETED -->
    <div class="event-card bg-white p-5 rounded-xl shadow-md hover:shadow-lg transition-all border"
    data-status="completed">
    
    <h3 class="text-lg font-semibold text-[#2C3E50] mb-2">Business Growth Meetup</h3>
    
        <p class="text-sm text-gray-600 flex items-center gap-1">
            <i data-feather="map-pin" class="w-4"></i>
            Delhi Chapter
        </p>
        
        <p class="text-sm text-gray-600 flex items-center gap-1">
            <i data-feather="calendar" class="w-4"></i>
            8 December 2025
        </p>
        
        <p class="text-sm text-gray-600 flex items-center gap-1 mb-3">
            <i data-feather="clock" class="w-4"></i>
            3:00 PM – 5:00 PM
        </p>
        
        <span class="inline-block px-3 py-1 text-xs bg-gray-300 text-gray-700 rounded-full">
            Completed
        </span>

        <button class="mt-4 w-full bg-gray-400 text-white py-2 rounded-lg flex gap-2 justify-center cursor-not-allowed">
            <i data-feather="x"></i>
            Closed
        </button>
    </div>

    
    <!-- EVENT 3 — UPCOMING -->
    <div class="event-card bg-white p-5 rounded-xl shadow-md hover:shadow-lg transition border"
    data-status="upcoming">
    
    <h3 class="text-lg font-semibold">Women Entrepreneurs Meetup</h3>
    
    <p class="text-sm text-gray-600 flex items-center gap-1">
        <i data-feather="map-pin" class="w-4"></i>
        Pune Chapter
    </p>
    
    <p class="text-sm text-gray-600 flex items-center gap-1">
        <i data-feather="calendar" class="w-4"></i>
        5 January 2026
    </p>
    
    <p class="text-sm text-gray-600 flex items-center gap-1 mb-3">
        <i data-feather="clock" class="w-4"></i>
        11:00 AM – 2:00 PM
    </p>
    
    <span class="bg-yellow-100 text-yellow-700 text-xs px-3 py-1 rounded-full">Upcoming</span>
    
    <button onclick="openEventModal('Women Entrepreneurs Meetup','Pune Chapter','5 January 2026','11:00 AM – 2:00 PM','A gathering of women entrepreneurs.', 3)"
    class="mt-4 w-full bg-[#2C3E50] text-white py-2 rounded-lg flex gap-2 justify-center">
            <i data-feather="arrow-right"></i> View Details
            </button>
    </div>
    
    
    <!-- EVENT 4 — UPCOMING -->
    <div class="event-card bg-white p-5 rounded-xl shadow-md hover:shadow-lg transition border"
    data-status="upcoming">
    
    <h3 class="text-lg font-semibold">Startup Pitch Session</h3>
    
    <p class="text-sm text-gray-600 flex items-center gap-1">
        <i data-feather="map-pin" class="w-4"></i> Hyderabad Chapter
    </p>
    
    <p class="text-sm text-gray-600 flex items-center gap-1">
        <i data-feather="calendar" class="w-4"></i> 20 January 2026
    </p>
    
    <p class="text-sm text-gray-600 flex items-center gap-1 mb-3">
        <i data-feather="clock" class="w-4"></i> 2:00 PM – 5:00 PM
    </p>
    
    <span class="bg-yellow-100 text-yellow-700 text-xs px-3 py-1 rounded-full">Upcoming</span>

    <button onclick="openEventModal('Startup Pitch Session','Hyderabad Chapter','20 January 2026','2:00 PM – 5:00 PM','Pitch ideas to investors.', 4)"
                class="mt-4 w-full bg-[#2C3E50] text-white py-2 rounded-lg flex gap-2 justify-center">
                <i data-feather="arrow-right"></i> View Details
        </button>
    </div>
    
    
    <!-- EVENT 5 — UPCOMING -->
    <div class="event-card bg-white p-5 rounded-xl shadow-md hover:shadow-lg transition border"
         data-status="upcoming">

         <h3 class="text-lg font-semibold">Networking Breakfast</h3>
         
         <p class="text-sm text-gray-600 flex items-center gap-1">
            <i data-feather="map-pin" class="w-4"></i> Chennai Chapter
        </p>
        
        <p class="text-sm text-gray-600 flex items-center gap-1">
            <i data-feather="calendar" class="w-4"></i> 15 January 2026
        </p>
        
        <p class="text-sm text-gray-600 flex items-center gap-1 mb-3">
            <i data-feather="clock" class="w-4"></i> 8:00 AM – 10:00 AM
        </p>
        
        <span class="bg-yellow-100 text-yellow-700 text-xs px-3 py-1 rounded-full">Upcoming</span>
        
        <button onclick="openEventModal('Networking Breakfast','Chennai Chapter','15 January 2026','8:00 AM – 10:00 AM','Business networking opportunity.', 5)"
        class="mt-4 w-full bg-[#2C3E50] text-white py-2 rounded-lg flex gap-2 justify-center">
        <i data-feather="arrow-right"></i> View Details
    </button>
</div>


<!-- EVENT 6 — UPCOMING -->
<div class="event-card bg-white p-5 rounded-xl shadow-md hover:shadow-lg transition border"
data-status="upcoming">

<h3 class="text-lg font-semibold">Financial Growth Workshop</h3>

<p class="text-sm text-gray-600 flex items-center gap-1">
    <i data-feather="map-pin" class="w-4"></i> Bengaluru Chapter
</p>

<p class="text-sm text-gray-600 flex items-center gap-1">
    <i data-feather="calendar" class="w-4"></i> 30 January 2026
</p>

<p class="text-sm text-gray-600 flex items-center gap-1 mb-3">
    <i data-feather="clock" class="w-4"></i> 10:00 AM – 1:00 PM
</p>

<span class="bg-yellow-100 text-yellow-700 text-xs px-3 py-1 rounded-full">Upcoming</span>

<button onclick="openEventModal('Financial Growth Workshop','Bengaluru Chapter','30 January 2026','10:00 AM – 1:00 PM','Workshop on business financial scaling.', 6)"
class="mt-4 w-full bg-[#2C3E50] text-white py-2 rounded-lg flex gap-2 justify-center">
<i data-feather="arrow-right"></i> View Details
</button>
</div>


<!-- EVENT 7 — COMPLETED -->
<div class="event-card bg-white p-5 rounded-xl shadow-md hover:shadow-lg transition border"
data-status="completed">

<h3 class="text-lg font-semibold">Marketing Masterclass</h3>

<p class="text-sm text-gray-600 flex items-center gap-1">
    <i data-feather="map-pin" class="w-4"></i> Jaipur Chapter
</p>

<p class="text-sm text-gray-600 flex items-center gap-1">
    <i data-feather="calendar" class="w-4"></i> 1 November 2025
</p>

        <p class="text-sm text-gray-600 flex items-center gap-1 mb-3">
            <i data-feather="clock" class="w-4"></i> 1:00 PM – 4:00 PM
        </p>

        <span class="bg-gray-300 text-gray-700 text-xs px-3 py-1 rounded-full">Completed</span>
        
        <button class="mt-4 w-full bg-gray-400 text-white py-2 rounded-lg flex gap-2 justify-center cursor-not-allowed">
            <i data-feather="x"></i>
            Closed
        </button>
    </div>
    
    
    <!-- EVENT 8 — COMPLETED -->
    <div class="event-card bg-white p-5 rounded-xl shadow-md hover:shadow-lg transition border"
    data-status="completed">
    
    <h3 class="text-lg font-semibold">Sales Training Bootcamp</h3>

        <p class="text-sm text-gray-600 flex items-center gap-1">
            <i data-feather="map-pin" class="w-4"></i> Kolkata Chapter
        </p>
        
        <p class="text-sm text-gray-600 flex items-center gap-1">
            <i data-feather="calendar" class="w-4"></i> 15 November 2025
        </p>
        
        <p class="text-sm text-gray-600 flex items-center gap-1 mb-3">
            <i data-feather="clock" class="w-4"></i> 9:00 AM – 1:00 PM
        </p>
        
        <span class="bg-gray-300 text-gray-700 text-xs px-3 py-1 rounded-full">Completed</span>
        
        <button class="mt-4 w-full bg-gray-400 text-white py-2 rounded-lg flex gap-2 justify-center cursor-not-allowed">
            <i data-feather="x"></i>
            Closed
        </button>
    </div>
    

    <!-- EVENT 9 — COMPLETED -->
    <div class="event-card bg-white p-5 rounded-xl shadow-md hover:shadow-lg transition border"
    data-status="completed">
    
    <h3 class="text-lg font-semibold">Investor Connect Session</h3>
    
    <p class="text-sm text-gray-600 flex items-center gap-1">
        <i data-feather="map-pin" class="w-4"></i> Ahmedabad Chapter
    </p>
    
    <p class="text-sm text-gray-600 flex items-center gap-1">
        <i data-feather="calendar" class="w-4"></i> 25 October 2025
    </p>
    
    <p class="text-sm text-gray-600 flex items-center gap-1 mb-3">
        <i data-feather="clock" class="w-4"></i> 12:00 PM – 3:00 PM
    </p>
    
    <span class="bg-gray-300 text-gray-700 text-xs px-3 py-1 rounded-full">Completed</span>
    
    <button class="mt-4 w-full bg-gray-400 text-white py-2 rounded-lg flex gap-2 justify-center cursor-not-allowed">
        <i data-feather="x"></i>
        Closed
    </button>
</div>

</div>
<!-- PAGINATION -->
<div class="flex justify-center mt-10 gap-2">
    <button class="border px-3 py-1 rounded-lg bg-white hover:bg-gray-100 transition">
        <i data-feather="chevron-left"></i>
    </button>
    
    <button class="px-4 py-2 rounded-lg bg-[#2C3E50] text-white border border-[#2C3E50]">1</button>
        <button class="px-4 py-2 rounded-lg bg-white border hover:bg-gray-100">2</button>
        <button class="px-4 py-2 rounded-lg bg-white border hover:bg-gray-100">3</button>
        
        <button class="border px-3 py-1 rounded-lg bg-white hover:bg-gray-100 transition">
            <i data-feather="chevron-right"></i>
        </button>
    </div>

</div>

</main>
</div>

<!-- MODAL -->
<div id="eventModal" class="hidden fixed inset-0 bg-black/40 z-50 flex items-center justify-center p-4">
    
    <div class="bg-white w-full max-w-md rounded-xl p-6 shadow-xl relative max-h-[90vh] overflow-y-auto">
        
        <button onclick="closeEventModal()" class="absolute top-3 right-3">
            <i data-feather="x" class="w-6 h-6 text-gray-600"></i>
        </button>
        
        <h3 id="modalTitle" class="text-xl font-semibold mb-3"></h3>
        <p id="modalVenue" class="text-sm text-gray-600"></p>
        <p id="modalDate" class="text-sm text-gray-600"></p>
        <p id="modalTime" class="text-sm text-gray-600 mb-3"></p>
        <p id="modalDescription" class="text-gray-700 mb-4"></p>

    <button id="confirmBtn"
    onclick="confirmAttendance()"
                  class="w-full bg-green-600 text-white py-2 rounded-lg mb-3">
                  Confirm Attendance
    </button>
    <button onclick="closeEventModal()"
    class="w-full bg-[#2C3E50] text-white py-2 rounded-lg">
      Close
    </button>
    
</div>
</div>


<script>
feather.replace();

/* MOBILE SIDEBAR */
const openMobileBtn = document.getElementById("openMobileSidebar");
const mobileSidebar = document.getElementById("mobileSidebar");
const mobilePanel = document.getElementById("mobilePanel");
const mobileOverlay = document.getElementById("mobileSidebarOverlay");

openMobileBtn.onclick = () => {
  mobileSidebar.classList.remove("hidden");
  setTimeout(() => mobilePanel.classList.add("mobile-open"), 10);
  document.body.style.overflow = "hidden";
};

mobileOverlay.onclick = () => closeMobileSidebar();

function closeMobileSidebar() {
  mobilePanel.classList.remove("mobile-open");
  document.body.style.overflow = "";
  setTimeout(() => mobileSidebar.classList.add("hidden"), 250);
}

/* PROFILE DROPDOWN */
const profileBtn = document.getElementById("profileBtn");
const profileDropdown = document.getElementById("profileDropdown");
const dropdownArrow = document.getElementById("dropdownArrow");

profileBtn.onclick = (e) => {
  e.stopPropagation();
  profileDropdown.classList.toggle("dropdown-hidden");
  profileDropdown.classList.toggle("dropdown-visible");
  dropdownArrow.classList.toggle("rotate-180");
};

document.onclick = (e) => {
  if (!profileBtn.contains(e.target)) {
    profileDropdown.classList.add("dropdown-hidden");
    profileDropdown.classList.remove("dropdown-visible");
    dropdownArrow.classList.remove("rotate-180");
  }
};

/* PERFECT FILTER (WORKS 100%) */
const filterBtns = document.querySelectorAll(".filter-btn");
const eventCards = document.querySelectorAll(".event-card");

filterBtns.forEach(btn => {
  btn.onclick = () => {

    // Update active state
    filterBtns.forEach(b => b.classList.remove("active-filter"));
    btn.classList.add("active-filter");

    const filter = btn.dataset.filter;

    eventCards.forEach(card => {

      // Read status from card
      const status = card.getAttribute("data-status")?.trim();

      // Show logic
      if (filter === "all" || status === filter) {
        card.classList.remove("hidden");
      } else {
        card.classList.add("hidden");
      }
    });
  };
});



/* MODAL */
let selectedEventId = null;

function openEventModal(title, venue, date, time, desc, eventId) {
  selectedEventId = eventId;

  modalTitle.innerText = title;
  modalVenue.innerText = "📍 " + venue;
  modalDate.innerText = "📅 " + date;
  modalTime.innerText = "⏰ " + time;
  modalDescription.innerText = desc;

  eventModal.classList.remove("hidden");
}

function closeEventModal() {
  eventModal.classList.add("hidden");
}

function confirmAttendance() {
  alert("Attendance Confirmed!");
  closeEventModal();
}
</script>
</body>
</html>
@include('components.script')

