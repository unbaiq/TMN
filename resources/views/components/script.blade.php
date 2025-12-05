<script>
    // Activate feather icons
    feather.replace();

    // Mobile sidebar elements
    const openMobileBtn = document.getElementById('openMobileSidebar');
    const mobileSidebar = document.getElementById('mobileSidebar');
    const mobilePanel = document.getElementById('mobilePanel');
    const mobileOverlay = document.getElementById('mobileSidebarOverlay');
    const closeMobileBtn = document.getElementById('closeMobileSidebar');

    function openMobileSidebar() {
      // show container and slide in
      mobileSidebar.classList.remove('hidden');
      setTimeout(() => mobilePanel.classList.add('mobile-open'), 10);

      // lock body scroll
      document.documentElement.style.overflow = 'hidden';
    }

    function closeMobileSidebar() {
      // slide out then hide
      mobilePanel.classList.remove('mobile-open');
      document.documentElement.style.overflow = '';
      setTimeout(() => mobileSidebar.classList.add('hidden'), 220);
    }

    if (openMobileBtn) openMobileBtn.addEventListener('click', openMobileSidebar);
    if (closeMobileBtn) closeMobileBtn.addEventListener('click', closeMobileSidebar);
    if (mobileOverlay) mobileOverlay.addEventListener('click', closeMobileSidebar);

    // Close mobile sidebar on resize to desktop
    window.addEventListener('resize', () => {
      if (window.innerWidth >= 768 && !mobileSidebar.classList.contains('hidden')) {
        closeMobileSidebar();
      }
    });

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
      if (!profileBtn.contains(ev.target) && !profileDropdown.contains(ev.target)) {
        dropdownArrow.classList.remove('rotate-180');
        profileDropdown.classList.add('dropdown-hidden');
        profileDropdown.classList.remove('dropdown-visible');
      }
    });
  </script>
  <script>
document.addEventListener("DOMContentLoaded", () => {
    const currentPage = window.location.pathname.split("/").pop();  
    const navLinks = document.querySelectorAll(".nav-item");

    navLinks.forEach(link => {
        link.classList.remove("nav-active");

        let href = link.getAttribute("href");

        if (!href || href === "#") return;

        // Normalize link value
        href = href.trim().toLowerCase();
        const file = href.split("/").pop();

        // Match HTML file or directory
        if (currentPage === file || currentPage === file.replace(".html", "")) {
            link.classList.add("nav-active");
        }

        // Special match for home page
        if ((currentPage === "" || currentPage === "/") && href === "#") {
            link.classList.add("nav-active");
        }
    });
});
</script>


</body>
</html>
