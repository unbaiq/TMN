@include('components.adminheader')
<style>
    :root { --brand: #e53935; }
    body { font-family: ui-sans-serif, system-ui, "Segoe UI", Arial; }
    .panel { background: #fff; border-radius: 14px; box-shadow: 0 4px 18px rgba(0,0,0,0.06); }
    .input { border:1px solid #e5e7eb; padding:0.65rem .8rem; border-radius:10px; width:100%; }
    .btn-primary { background:var(--brand); color:#fff; padding:.6rem 1rem; border-radius:10px; }
    .btn-primary:hover { background:#c62828; }
    .toggle-btn { cursor:pointer; }
  </style>


<div class="bg-gray-100 p-6 flex justify-center">

  <div class="w-full max-w-md mt-10">
    
    <div class="panel p-6">
      <h1 class="text-xl font-semibold">Change Password</h1>
      <p class="text-gray-500 text-sm mt-1">Update your account password securely.</p>

      <form id="passwordForm" class="mt-6 space-y-4">

        <!-- Current Password -->
        <div>
          <label class="text-sm text-gray-600">Current Password</label>
          <div class="relative mt-1">
            <input id="currentPassword" type="password" class="input pr-10" placeholder="Enter current password" required>
            <span class="absolute right-3 top-3 text-gray-500 toggle-btn" onclick="togglePassword('currentPassword', this)">
              <i data-feather="eye"></i>
            </span>
          </div>
        </div>

        <!-- New Password -->
        <div>
          <label class="text-sm text-gray-600">New Password</label>
          <div class="relative mt-1">
            <input id="newPassword" type="password" class="input pr-10" placeholder="Enter new password" required>
            <span class="absolute right-3 top-3 text-gray-500 toggle-btn" onclick="togglePassword('newPassword', this)">
              <i data-feather="eye"></i>
            </span>
          </div>
        </div>

        <!-- Confirm Password -->
        <div>
          <label class="text-sm text-gray-600">Confirm New Password</label>
          <div class="relative mt-1">
            <input id="confirmPassword" type="password" class="input pr-10" placeholder="Re-enter new password" required>
            <span class="absolute right-3 top-3 text-gray-500 toggle-btn" onclick="togglePassword('confirmPassword', this)">
              <i data-feather="eye"></i>
            </span>
          </div>
        </div>

        <!-- Save Button -->
        <button type="submit" class="btn-primary w-full flex justify-center items-center gap-2 mt-3">
          <i data-feather="lock"></i> Save Password
        </button>

      </form>
    </div>

    <!-- Toast -->
    <div id="toast" class="fixed right-6 bottom-6 z-50"></div>
  </div>

<script>
  feather.replace();

  function togglePassword(fieldId, iconElement) {
    const field = document.getElementById(fieldId);
    const icon = iconElement.querySelector("i");

    if (field.type === "password") {
      field.type = "text";
      icon.setAttribute("data-feather", "eye-off");
    } else {
      field.type = "password";
      icon.setAttribute("data-feather", "eye");
    }

    feather.replace();
  }

  // simple client-side demo validation
  document.getElementById("passwordForm").addEventListener("submit", function(e){
    e.preventDefault();

    let cur = document.getElementById("currentPassword").value;
    let np = document.getElementById("newPassword").value;
    let cp = document.getElementById("confirmPassword").value;

    if (np !== cp) {
      showToast("New passwords do not match", "error");
      return;
    }

    if (np.length < 6) {
      showToast("Password must be at least 6 characters", "error");
      return;
    }

    showToast("Password changed successfully!", "success");
    this.reset();
  });

  function showToast(msg, type="success"){
    const box = document.createElement("div");
    box.className = "px-4 py-2 mt-2 text-white rounded shadow " 
                  + (type === "success" ? "bg-green-600" : "bg-red-600");
    box.textContent = msg;
    document.getElementById("toast").appendChild(box);
    setTimeout(() => box.remove(), 2200);
  }
</script>

@include('components.script')