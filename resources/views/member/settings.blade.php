@include('components.memberheader')
<div class="p-6 sm:p-10 space-y-6">

        <!-- grid: left settings form, right quick actions -->
        <div class=" gap-6">

          <!-- Left: main settings -->
          <section class="lg:col-span-2 bg-white rounded-lg shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Account settings</h2>

            <!-- Tabs -->
            <div class="mb-6">
              <nav class="flex gap-2 border-b -mx-6 px-6">
                <button data-tab="profile" class="tab-btn px-4 py-2 -mb-px text-sm font-medium text-red-600 border-b-2 border-red-600">Profile</button>
                <button data-tab="security" class="tab-btn px-4 py-2 text-sm font-medium text-gray-600">Security</button>
                <button data-tab="notifications" class="tab-btn px-4 py-2 text-sm font-medium text-gray-600">Notifications</button>
              </nav>
            </div>

            <!-- Tab contents -->
            <div id="tabProfile" class="tab-content">
              <form id="profileForm" class="bg-white rounded-lg shadow-sm p-6 space-y-6">

  <!-- grid: two columns on md+, single on small -->
  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
      <label for="fullName" class="block text-xs text-gray-600 mb-1">Full name</label>
      <input id="fullName" name="fullName" type="text" value="Member Name"
             class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-1 focus:ring-red-300" />
    </div>

    <div>
      <label for="displayName" class="block text-xs text-gray-600 mb-1">Display name</label>
      <input id="displayName" name="displayName" type="text" value="Member"
             class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-1 focus:ring-red-300" />
    </div>

    <div>
      <label for="email" class="block text-xs text-gray-600 mb-1">Email</label>
      <input id="email" name="email" type="email" value="member@example.com" 
             class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-1 focus:ring-red-300" />
    </div>

    <div>
      <label for="phone" class="block text-xs text-gray-600 mb-1">Phone</label>
      <input id="phone" name="phone" type="tel" value="+91 99999 99999"
             class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-1 focus:ring-red-300" />
    </div>

    <!-- Profession field added -->
    <div class="md:col-span-1">
      <label for="profession" class="block text-xs text-gray-600 mb-1">Profession</label>
      <input id="profession" name="profession" type="text" value="Entrepreneur"
             placeholder="e.g., Designer, Consultant, Founder"
             class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-1 focus:ring-red-300" />
    </div>

    <!-- optional: membership / extra column placeholder to keep grid neat -->
    <div class="md:col-span-1 hidden md:block"></div>
  </div>

  <div>
    <label for="bio" class="block text-xs text-gray-600 mb-1">Bio</label>
    <textarea id="bio" name="bio" rows="5"
              class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-1 focus:ring-red-300"
    >Short bio about member</textarea>
  </div>

  <!-- action row: Reset (left) + Save (right) -->
  <div class="flex items-center justify-between">
    <div>
      <button id="resetProfile" type="button"
              class="px-4 py-2 bg-white border rounded-md text-sm hover:shadow-sm">
        Reset
      </button>
    </div>

    <div class="flex items-center gap-3">
      <button id="previewProfileBtn" type="button"
              class="px-4 py-2 bg-white border rounded-md text-sm hover:shadow-sm hidden">
        Preview
      </button>

      <button id="saveProfileBtn" type="submit"
              class="px-4 py-2 bg-red-500 text-white rounded-md text-sm shadow">
        Save changes
      </button>
    </div>
  </div>
</form>
            </div>

            <div id="tabSecurity" class="tab-content hidden">
              <form id="securityForm" class="space-y-4">
                <div>
                  <label class="text-xs text-gray-600">Change password</label>
                  <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mt-2">
                    <input id="currentPassword" type="password" placeholder="Current password" class="px-3 py-2 border rounded-md" />
                    <input id="newPassword" type="password" placeholder="New password" class="px-3 py-2 border rounded-md" />
                    <input id="confirmPassword" type="password" placeholder="Confirm new" class="px-3 py-2 border rounded-md" />
                  </div>
                </div>

                <div class="flex items-center gap-2 justify-end">
                  <button id="resetPass" type="button" class="px-3 py-2 bg-white border rounded-md text-sm">Reset</button>
                  <button id="savePass" type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md text-sm">Update password</button>
                </div>

                <hr class="my-3">

                <div>
                  <label class="text-xs text-gray-600">Two-factor authentication</label>
                  <p class="text-sm text-gray-500 mt-1">Enable two-factor auth for extra account security.</p>
                  <div class="mt-3 flex items-center gap-3">
                    <input id="toggle2fa" type="checkbox" class="w-4 h-4" />
                    <label for="toggle2fa" class="text-sm">Enable two-factor authentication</label>
                  </div>
                </div>
              </form>
            </div>

            <div id="tabNotifications" class="tab-content hidden">
              <form id="notificationsForm" class="space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                  <div>
                    <label class="text-xs text-gray-600">Email notifications</label>
                    <div class="mt-2 space-y-2">
                      <label class="flex items-center gap-2"><input type="checkbox" checked /> New messages</label>
                      <label class="flex items-center gap-2"><input type="checkbox" checked /> Service requests</label>
                      <label class="flex items-center gap-2"><input type="checkbox" /> Updates & promotions</label>
                    </div>
                  </div>

                  <div>
                    <label class="text-xs text-gray-600">Mobile push</label>
                    <div class="mt-2 space-y-2">
                      <label class="flex items-center gap-2"><input type="checkbox" checked /> Requests & confirmations</label>
                      <label class="flex items-center gap-2"><input type="checkbox" /> Marketing</label>
                    </div>
                  </div>
                </div>

                <div class="flex items-center gap-2 justify-end">
                  <button type="button" id="resetNotif" class="px-3 py-2 bg-white border rounded-md text-sm">Reset</button>
                  <button id="saveNotif" type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md text-sm">Save</button>
                </div>
              </form>
            </div>

          </section>

          <!-- Right: quick actions & profile card -->
          
        </div>
      </div>


      </main>
 
<script>
  // ----------------------
  // UI wiring (trimmed: removed quick-actions/delete modal)
  // ----------------------
  document.addEventListener('DOMContentLoaded', () => {
    // feather icons
    if (typeof feather !== 'undefined' && feather.replace) feather.replace();

    // mobile sidebar toggles
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

    // profile dropdown
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
    document.addEventListener('click', (ev) => {
      if (profileBtn && profileDropdown && !profileBtn.contains(ev.target) && !profileDropdown.contains(ev.target)) {
        dropdownArrow.classList.remove('rotate-180');
        profileDropdown.classList.add('dropdown-hidden');
        profileDropdown.classList.remove('dropdown-visible');
      }
    });

    // Tabs
    const tabButtons = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');
    tabButtons.forEach(btn => {
      btn.addEventListener('click', () => {
        tabButtons.forEach(b => b.classList.remove('text-red-600', 'border-red-600'));
        tabButtons.forEach(b => b.classList.add('text-gray-600'));
        tabContents.forEach(c => c.classList.add('hidden'));
        // enable clicked
        btn.classList.add('text-red-600');
        btn.classList.remove('text-gray-600');
        const target = btn.getAttribute('data-tab');
        document.getElementById('tab' + target.charAt(0).toUpperCase() + target.slice(1)).classList.remove('hidden');
      });
    });

    // Simple form handlers — replace with API calls
    const profileForm = document.getElementById('profileForm');
    const securityForm = document.getElementById('securityForm');
    const notificationsForm = document.getElementById('notificationsForm');

    function toast(message, kind = 'success') {
      const toast = document.createElement('div');
      toast.className = `fixed bottom-6 right-6 px-4 py-2 rounded shadow-lg ${kind==='error'? 'bg-red-600 text-white':'bg-green-600 text-white'}`;
      toast.textContent = message;
      document.body.appendChild(toast);
      setTimeout(() => { toast.remove(); }, 3000);
    }

    if (profileForm) {
      profileForm.addEventListener('submit', (e) => {
        e.preventDefault();
        // do validation and call API here
        toast('Profile saved');
      });
    }
    if (securityForm) {
      securityForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const newPass = document.getElementById('newPassword').value;
        const confirm = document.getElementById('confirmPassword').value;
        if (newPass && newPass !== confirm) { toast('Passwords do not match', 'error'); return; }
        toast('Password updated');
        securityForm.reset();
      });
    }
    if (notificationsForm) {
      notificationsForm.addEventListener('submit', (e) => {
        e.preventDefault();
        toast('Notification preferences saved');
      });
    }

    // Reset buttons
    const resetProfile = document.getElementById('resetProfile');
    if (resetProfile) resetProfile.addEventListener('click', () => {
      document.getElementById('fullName').value = 'Member Name';
      document.getElementById('displayName').value = 'Member';
      document.getElementById('email').value = 'member@example.com';
      document.getElementById('phone').value = '+91 99999 99999';
      document.getElementById('bio').value = 'Short bio about member';
      toast('Profile reset');
    });

    const resetPass = document.getElementById('resetPass');
    if (resetPass) resetPass.addEventListener('click', () => {
      document.getElementById('currentPassword').value = '';
      document.getElementById('newPassword').value = '';
      document.getElementById('confirmPassword').value = '';
    });

    const resetNotif = document.getElementById('resetNotif');
    if (resetNotif) resetNotif.addEventListener('click', () => {
      // Simple: uncheck optional ones (example)
      notificationsForm.querySelectorAll('input[type="checkbox"]').forEach(c => c.checked = false);
      toast('Notifications reset');
    });

    // re-run feather icons if present
    if (typeof feather !== 'undefined' && feather.replace) feather.replace();

    // Close dropdowns/modals on Escape
    document.addEventListener('keydown', (ev) => {
      if (ev.key === 'Escape') {
        // close mobile if open
        if (!mobileSidebar.classList.contains('hidden')) closeMobileSidebar();
        // close profile dropdown
        if (profileDropdown && !profileDropdown.classList.contains('dropdown-hidden')) {
          profileDropdown.classList.add('dropdown-hidden'); profileDropdown.classList.remove('dropdown-visible'); dropdownArrow.classList.remove('rotate-180');
        }
      }
    });
  });
</script>

@include('components.script')

