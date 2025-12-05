@include('components.adminheader')

<script src="https://unpkg.com/feather-icons"></script>

  <style>
    :root{
      --tmn-red:#e53935;
      --panel-bg:#ffffff;
      --muted:#6b7280;
    }
    body { background: #f3f4f6; font-family: Inter, ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial; }
    .card { background: var(--panel-bg); border-radius: 12px; box-shadow: 0 4px 10px rgba(15,23,42,0.04); }
    .accent-line { height:6px; border-radius:8px; background: linear-gradient(90deg,#fb923c,#ef4444, #ef5350); opacity:.12; margin-top:-1rem; margin-left:1rem; margin-right:1rem; }
    .pill { padding:6px 10px; border-radius:999px; font-size:.75rem; font-weight:600; }
    .badge-active { background: linear-gradient(90deg,#ecfdf5,#bbf7d0); color:#065f46; }
    .muted { color:var(--muted); }
    .section-title { font-weight:700; color:#111827; }
    .tab-active { border-bottom:3px solid var(--tmn-red); padding-bottom:0.5rem; }
    .small { font-size:0.85rem; }
    .info-row { border-top:1px solid #f3f4f6; padding-top:0.75rem; padding-bottom:0.75rem; }
  </style>


      <div class="max-w-6xl mx-auto px-6 py-6 space-y-6">

        <!-- PROFILE TOP -->
        <section class="card p-6 relative">
          <div class="accent-line"></div>
          <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center gap-4">
              <div class="w-20 h-20 rounded-xl bg-red-100 flex items-center justify-center text-red-600 text-2xl font-bold">R</div>
              <div>
                <div class="flex items-center gap-3">
                  <h2 id="memberName" class="text-2xl font-semibold">Ramesh Kumar</h2>
                  <div id="roleBadge" class="pill badge-active">Member</div>
                  <div id="activeBadge" class="pill bg-gray-100 text-gray-700">Active</div>
                </div>
                <div class="text-sm muted mt-1" id="memberBusiness">Ramesh Enterprises • Delhi</div>
                <div class="text-xs muted mt-1">Referral: <span id="referralCode">TMN-AB12</span> • Member since <span id="memberStart">2024-02-01</span> • Expires: <span id="memberEnd">2025-02-01</span></div>
              </div>
            </div>

            <div class="flex items-center gap-3">
              <div class="text-right mr-2">
                <div class="text-sm muted">Total Amount</div>
                <div id="totalAmount" class="text-xl font-semibold">₹ 12,500.00</div>
              </div>

              <div class="flex items-center gap-2">
                <button id="editProfileBtn" class="px-3 py-2 bg-white border rounded shadow-sm flex items-center gap-2">
                  <i data-feather="edit-2" class="w-4"></i> Edit
                </button>
                <button id="messageBtn" class="px-3 py-2 bg-red-600 text-white rounded flex items-center gap-2">
                  <i data-feather="send" class="w-4"></i> Message
                </button>
              </div>
            </div>
          </div>
        </section>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

          <!-- LEFT: Contact & Profile -->
          <div class="space-y-6">
            <div class="card p-4">
              <h3 class="section-title">Contact & Profile</h3>
              <div class="mt-3 space-y-2">
                <div class="info-row flex items-center justify-between">
                  <div>
                    <div class="text-sm muted">Email</div>
                    <div id="memberEmail" class="font-medium">ramesh@example.com</div>
                  </div>
                </div>

                <div class="info-row flex items-center justify-between">
                  <div>
                    <div class="text-sm muted">Phone</div>
                    <div id="memberPhone" class="font-medium">+91 98765 43210</div>
                  </div>
                </div>

                <div class="info-row">
                  <div class="text-sm muted">Address</div>
                  <div id="memberAddress" class="mt-1">12, MG Road, Connaught Place, New Delhi, 110001</div>
                </div>

                <div class="info-row">
                  <div class="text-sm muted">Business</div>
                  <div id="memberBusinessFull" class="mt-1">Ramesh Enterprises — Manufacturing & Distribution</div>
                  <div class="text-xs muted mt-1">Designation: <span id="memberDesignation">Founder & CEO</span></div>
                </div>
              </div>
            </div>

            <div class="card p-4">
              <h3 class="section-title">Profile Details</h3>
              <div class="mt-3 space-y-2">
                <div class="flex items-center justify-between">
                  <div class="text-sm muted">Referral ID</div>
                  <div id="referId" class="font-medium">101</div>
                </div>
                <div class="flex items-center justify-between">
                  <div class="text-sm muted">Membership Role</div>
                  <div id="role" class="font-medium">member</div>
                </div>
                <div class="flex items-center justify-between">
                  <div class="text-sm muted">Email verified</div>
                  <div id="emailVerified" class="font-medium">Yes</div>
                </div>
                <div class="flex items-center justify-between">
                  <div class="text-sm muted">Is Active</div>
                  <div id="isActive" class="font-medium">Yes</div>
                </div>
              </div>
            </div>

            <div class="card p-4">
              <h3 class="section-title">CSR & Philanthropy</h3>
              <div class="mt-3 space-y-2">
                <div class="flex items-center justify-between">
                  <div>
                    <div class="text-sm muted">CSR Interested Areas</div>
                    <div id="csrCategories" class="font-medium">Skill development, Health support</div>
                  </div>
                </div>

                <div class="flex items-center justify-between mt-3">
                  <div class="text-sm muted">CSR Amount Pledged</div>
                  <div id="csrAmount" class="font-medium">₹ 50,000</div>
                </div>

                <div class="mt-3 text-xs muted">Collaboration notes: <div id="csrNotes">Open to local skill development programs; prefers education & health</div></div>
              </div>
            </div>

          </div>

          <!-- MIDDLE: Tabs & Main Content -->
          <div class="lg:col-span-2">
            <div class="card p-4">
              <!-- tabs -->
              <div class="flex items-center gap-4 border-b pb-3">
                <button class="tab-btn tab-active text-sm pb-2" data-tab="overview">Overview</button>
                <button class="tab-btn text-sm pb-2" data-tab="attendance">Attendance</button>
                <button class="tab-btn text-sm pb-2" data-tab="invest">Investments</button>
                <button class="tab-btn text-sm pb-2" data-tab="meet">1-1 Meetups</button>
                <button class="tab-btn text-sm pb-2" data-tab="services">Services</button>
              </div>

              <div class="mt-4">
                <!-- Overview Tab -->
                <div class="tab-content" id="overview">
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-4 border rounded">
                      <h4 class="font-semibold">Chapter & Participation</h4>
                      <div class="mt-3 small muted">Assigned Chapter</div>
                      <div id="assignedChapter" class="font-medium">Delhi Chapter</div>
                      <div class="small muted mt-3">Cluster Meetings attended</div>
                      <ul id="clusterList" class="mt-2 list-disc list-inside text-sm">
                        <!-- filled by js -->
                      </ul>
                    </div>

                    <div class="p-4 border rounded">
                      <h4 class="font-semibold">Business Snapshot</h4>
                      <div class="mt-3 small muted">Turnover (last FY)</div>
                      <div id="businessTurnover" class="font-medium">₹ 25,00,000</div>
                      <div class="small muted mt-3">Business category</div>
                      <div id="businessCategory" class="font-medium">Manufacturing</div>
                    </div>
                  </div>

                  <div class="mt-4">
                    <h4 class="font-semibold">Recent Activity</h4>
                    <div id="activityList" class="mt-2 space-y-2 small muted">
                      <!-- js -->
                    </div>
                  </div>
                </div>

                <!-- Attendance Tab -->
                <div class="tab-content hidden" id="attendance">
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-4 border rounded">
                      <h4 class="font-semibold">Events Attended</h4>
                      <table class="w-full text-sm mt-3">
                        <thead class="text-left text-xs muted">
                          <tr><th>Event</th><th>Date</th><th>Status</th></tr>
                        </thead>
                        <tbody id="eventsAttended" class="text-sm">
                          <!-- js -->
                        </tbody>
                      </table>
                    </div>

                    <div class="p-4 border rounded">
                      <h4 class="font-semibold">Chapter Attendance</h4>
                      <table class="w-full text-sm mt-3">
                        <thead class="text-left text-xs muted"><tr><th>Chapter</th><th>Meet</th><th>Date</th></tr></thead>
                        <tbody id="chapterAttendance">
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>

                <!-- Investments Tab -->
                <div class="tab-content hidden" id="invest">
                  <div class="p-4 border rounded">
                    <h4 class="font-semibold">Investor Details</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mt-3">
                      <div>
                        <div class="text-sm muted">Amount to Invest</div>
                        <div id="investAmount" class="font-medium">₹ 10,00,000</div>
                      </div>
                      <div>
                        <div class="text-sm muted">Interested Categories</div>
                        <div id="investCategories" class="font-medium">Startup, Partner</div>
                      </div>
                      <div>
                        <div class="text-sm muted">Preferred Stage</div>
                        <div id="investStage" class="font-medium">Seed / Early</div>
                      </div>
                    </div>

                    <div class="mt-4">
                      <h5 class="font-semibold">Past Investments</h5>
                      <table class="w-full text-sm mt-2">
                        <thead class="text-xs muted"><tr><th>Recipient</th><th>Amount</th><th>Date</th></tr></thead>
                        <tbody id="pastInvestments"></tbody>
                      </table>
                    </div>
                  </div>
                </div>

                <!-- 1-1 Meetups Tab -->
                <div class="tab-content hidden" id="meet">
                  <div class="p-4 border rounded">
                    <h4 class="font-semibold">1-1 Meetups</h4>
                    <table class="w-full text-sm mt-3">
                      <thead class="text-xs muted"><tr><th>With</th><th>Date</th><th>Notes</th></tr></thead>
                      <tbody id="meetupsList"></tbody>
                    </table>
                  </div>
                </div>

                <!-- Services Tab -->
                <div class="tab-content hidden" id="services">
                  <div class="p-4 border rounded">
                    <h4 class="font-semibold">Services Availed</h4>
                    <table class="w-full text-sm mt-3">
                      <thead class="text-xs muted"><tr><th>Service</th><th>Provider</th><th>Date</th><th>Status</th></tr></thead>
                      <tbody id="servicesAvailed"></tbody>
                    </table>

                    <div class="mt-4">
                      <h4 class="font-semibold">Services Given</h4>
                      <table class="w-full text-sm mt-3">
                        <thead class="text-xs muted"><tr><th>Service</th><th>Client</th><th>Date</th></tr></thead>
                        <tbody id="servicesGiven"></tbody>
                      </table>
                    </div>
                  </div>
                </div>

              </div>
            </div>

          </div>
        </div>

      </div>

      <!-- EDIT PROFILE MODAL -->
      <div id="editModal" class="fixed inset-0 z-50 hidden items-center justify-center">
        <div class="absolute inset-0 bg-black/40"></div>
        <div class="relative z-10 bg-white rounded-2xl max-w-2xl w-full p-6 shadow-xl">
          <div class="flex items-center justify-between mb-3">
            <h3 class="text-lg font-semibold">Edit Member Profile</h3>
            <button id="closeEdit" class="text-gray-400">✕</button>
          </div>
          <form id="editForm" class="grid grid-cols-1 md:grid-cols-2 gap-3">
            <input id="formName" class="border rounded px-3 py-2" placeholder="Full name" required />
            <input id="formEmail" class="border rounded px-3 py-2" placeholder="Email" required />
            <input id="formPhone" class="border rounded px-3 py-2" placeholder="Phone"/>
            <input id="formBusiness" class="border rounded px-3 py-2" placeholder="Business name"/>
            <input id="formDesignation" class="border rounded px-3 py-2" placeholder="Designation"/>
            <input id="formStart" type="date" class="border rounded px-3 py-2"/>
            <input id="formEnd" type="date" class="border rounded px-3 py-2"/>
            <textarea id="formAddress" class="border rounded px-3 py-2 md:col-span-2" rows="3" placeholder="Address"></textarea>

            <div class="md:col-span-2 flex items-center justify-end gap-3">
              <button type="button" id="cancelEdit" class="px-4 py-2 rounded bg-gray-100">Cancel</button>
              <button type="submit" class="px-4 py-2 rounded bg-red-600 text-white">Save</button>
            </div>
          </form>
        </div>
      </div>

    </main>
  </div>

  <!-- Toast -->
  <div id="toast" class="fixed right-6 bottom-6 z-50"></div>

  <script>
  // === Demo client-side Member Detail page ===
  (function(){
    feather.replace();

    // Storage key
    const KEY = 'tmn_member_demo_v1';

    // Seed demo data (matches migrations & fields)
    const seed = {
      user: {
        id: 201,
        name: 'Ramesh Kumar',
        email: 'ramesh@example.com',
        phone: '+91 98765 43210',
        role: 'member',
        refer_id: 101,
        referral_code: 'TMN-RK201',
        total_amount: 12500.00,
        is_active: true,
        email_verified_at: '2024-02-02T09:00:00Z',
        membership_start: '2024-02-01',
        membership_end: '2025-02-01'
      },
      profile: {
        address: '12, MG Road, Connaught Place, New Delhi, 110001',
        city: 'Delhi',
        state: 'Delhi',
        pincode: '110001',
        country: 'India',
        business_name: 'Ramesh Enterprises',
        business_type: 'Manufacturing',
        designation: 'Founder & CEO',
        business_description: 'Manufacturer and distributor of consumer goods',
        website: 'https://rameshenterprises.example.com',
        linkedin: 'https://linkedin.com/in/ramesh'
      },
      csr: {
        categories: ['Skill development', 'Health support'],
        pledged_amount: 50000,
        notes: 'Open to local skill development programs.'
      },
      chapter: {
        assigned: { id: 1, name: 'Delhi Chapter' },
        attendance: [
          { chapter: 'Delhi Chapter', meet: 'Monthly Networking', date: '2024-04-10' },
          { chapter: 'Delhi Chapter', meet: 'Cluster Meeting', date: '2024-06-12' }
        ]
      },
      cluster_meetings: [
        { id: 1, title: 'Q1 Cluster — Delhi', date:'2024-04-10', notes:'Focus on skill connect' },
        { id: 2, title: 'Q2 Cluster — Delhi', date:'2024-06-12', notes:'CSR collaboration' }
      ],
      events_attended: [
        { id: 301, title: 'TMN Annual Summit', date:'2024-11-20', status: 'attended' },
        { id: 302, title: 'Leadership Workshop', date:'2024-08-09', status: 'attended' }
      ],
      investments: {
        to_invest: 1000000,
        interested_in: ['Startup','Partner'],
        stage: 'Seed / Early',
        past: [
          { recipient: 'Alpha Startup', amount: 200000, date: '2024-03-15' }
        ]
      },
      meetups: [
        { with: 'Priya Sharma', date: '2024-05-20', notes: 'Discuss collaboration' }
      ],
      services_availed: [
        { id: 401, title: 'Brand Consultation', provider: 'Avinash H', date: '2024-02-12', status: 'completed' }
      ],
      services_given: [
        { id: 402, title: 'Manufacturing Advice', client:'Local Startup', date:'2024-03-08' }
      ],
      businesses: [
        { id:501, name:'Ramesh Enterprises', type:'Manufacturing', city:'Delhi', turnover:'₹25,00,000' }
      ],
      activity: [
        'Registered for TMN Annual Summit',
        'Completed Brand Consultation',
        'Pledged CSR funds for Skill development'
      ]
    };

    // load or initialize
    function load(){
      try {
        const raw = localStorage.getItem(KEY);
        if (!raw){
          localStorage.setItem(KEY, JSON.stringify(seed));
          return seed;
        }
        return JSON.parse(raw);
      } catch(e){
        console.warn('load failed', e);
        localStorage.setItem(KEY, JSON.stringify(seed));
        return seed;
      }
    }

    let data = load();

    function save(){
      localStorage.setItem(KEY, JSON.stringify(data));
      showToast('Saved');
    }

    function resetDemo(){
      if (!confirm('Reset demo data?')) return;
      data = seed;
      localStorage.setItem(KEY, JSON.stringify(seed));
      renderAll();
      showToast('Demo reset');
    }

    // utility
    function showToast(msg='Saved', type='success'){
      const t = document.createElement('div');
      t.className = 'px-4 py-2 rounded shadow text-white ' + (type==='success' ? 'bg-green-600' : 'bg-gray-800');
      t.textContent = msg;
      document.getElementById('toast').appendChild(t);
      setTimeout(()=> t.remove(), 2200);
    }

    // render functions
    function renderProfile(){
      const u = data.user;
      const p = data.profile;

      document.getElementById('memberName').textContent = u.name;
      document.getElementById('memberBusiness').textContent = `${p.business_name} • ${p.city}`;
      document.getElementById('memberBusinessFull').textContent = `${p.business_name} — ${p.business_description}`;
      document.getElementById('memberEmail').textContent = u.email;
      document.getElementById('memberPhone').textContent = u.phone;
      document.getElementById('memberAddress').textContent = p.address;
      document.getElementById('memberDesignation').textContent = p.designation;
      document.getElementById('referId').textContent = u.refer_id || '-';
      document.getElementById('role').textContent = u.role;
      document.getElementById('emailVerified').textContent = u.email_verified_at ? 'Yes' : 'No';
      document.getElementById('isActive').textContent = u.is_active ? 'Yes' : 'No';
      document.getElementById('totalAmount').textContent = `₹ ${Number(u.total_amount||0).toLocaleString('en-IN')}`;
      document.getElementById('referralCode').textContent = u.referral_code || '-';
      document.getElementById('memberStart').textContent = u.membership_start || '-';
      document.getElementById('memberEnd').textContent = u.membership_end || '-';
      document.getElementById('roleBadge').textContent = (u.role || 'member').toUpperCase();
      document.getElementById('activeBadge').textContent = u.is_active ? 'Active' : 'Inactive';

      // CSR
      document.getElementById('csrCategories').textContent = (data.csr.categories || []).join(', ');
      document.getElementById('csrAmount').textContent = `₹ ${Number(data.csr.pledged_amount||0).toLocaleString('en-IN')}`;
      document.getElementById('csrNotes').textContent = data.csr.notes || '-';

      // overview fields
      document.getElementById('assignedChapter').textContent = data.chapter.assigned?.name || '-';
      // cluster list
      const clusterList = document.getElementById('clusterList');
      clusterList.innerHTML = '';
      data.cluster_meetings.forEach(m => {
        const li = document.createElement('li');
        li.textContent = `${m.title} — ${m.date}`;
        clusterList.appendChild(li);
      });

      // activity
      const al = document.getElementById('activityList');
      al.innerHTML = '';
      data.activity.forEach(a => {
        const d = document.createElement('div');
        d.className = 'py-1';
        d.textContent = a;
        al.appendChild(d);
      });
    }

    function renderAttendance(){
      const tbodyEvents = document.getElementById('eventsAttended');
      tbodyEvents.innerHTML = '';
      data.events_attended.forEach(ev => {
        const tr = document.createElement('tr');
        tr.innerHTML = `<td class="py-2">${ev.title}</td><td class="py-2 small muted">${ev.date}</td><td class="py-2">${ev.status}</td>`;
        tbodyEvents.appendChild(tr);
      });

      const chatt = document.getElementById('chapterAttendance');
      chatt.innerHTML = '';
      data.chapter.attendance.forEach(a => {
        const tr = document.createElement('tr');
        tr.innerHTML = `<td class="py-2">${a.chapter}</td><td class="py-2">${a.meet}</td><td class="py-2 small muted">${a.date}</td>`;
        chatt.appendChild(tr);
      });
    }

    function renderInvestments(){
      document.getElementById('investAmount').textContent = `₹ ${Number(data.investments.to_invest||0).toLocaleString('en-IN')}`;
      document.getElementById('investCategories').textContent = (data.investments.interested_in || []).join(', ');
      document.getElementById('investStage').textContent = data.investments.stage || '-';

      const past = document.getElementById('pastInvestments');
      past.innerHTML = '';
      (data.investments.past||[]).forEach(i => {
        const tr = document.createElement('tr');
        tr.innerHTML = `<td class="py-2">${i.recipient}</td><td class="py-2">₹ ${Number(i.amount).toLocaleString('en-IN')}</td><td class="py-2 small muted">${i.date}</td>`;
        past.appendChild(tr);
      });
    }

    function renderMeetups(){
      const tbody = document.getElementById('meetupsList');
      tbody.innerHTML = '';
      (data.meetups||[]).forEach(m => {
        const tr = document.createElement('tr');
        tr.innerHTML = `<td class="py-2">${m.with}</td><td class="py-2 small muted">${m.date}</td><td class="py-2">${m.notes}</td>`;
        tbody.appendChild(tr);
      });
    }

    function renderServices(){
      const av = document.getElementById('servicesAvailed');
      av.innerHTML = '';
      (data.services_availed||[]).forEach(s => {
        const tr = document.createElement('tr');
        tr.innerHTML = `<td class="py-2">${s.title}</td><td class="py-2">${s.provider}</td><td class="py-2 small muted">${s.date}</td><td class="py-2">${s.status || ''}</td>`;
        av.appendChild(tr);
      });

      const gv = document.getElementById('servicesGiven');
      gv.innerHTML = '';
      (data.services_given||[]).forEach(s => {
        const tr = document.createElement('tr');
        tr.innerHTML = `<td class="py-2">${s.title}</td><td class="py-2">${s.client}</td><td class="py-2 small muted">${s.date}</td>`;
        gv.appendChild(tr);
      });
    }

    function renderBusinesses(){
      const el = document.getElementById('businessTurnover');
      el.textContent = data.businesses?.[0]?.turnover || '-';
      document.getElementById('businessCategory').textContent = data.profile.business_type || '-';
    }

    // Render all
    function renderAll(){
      renderProfile();
      renderAttendance();
      renderInvestments();
      renderMeetups();
      renderServices();
      renderBusinesses();
      feather.replace();
    }

    // Tabs
    document.querySelectorAll('.tab-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('tab-active'));
        btn.classList.add('tab-active');
        const tab = btn.getAttribute('data-tab');
        document.querySelectorAll('.tab-content').forEach(c => c.classList.add('hidden'));
        document.getElementById(tab).classList.remove('hidden');
      });
    });

    // Edit Modal
    const editModal = document.getElementById('editModal');
    document.getElementById('editProfileBtn').addEventListener('click', () => {
      // fill form
      const u = data.user, p = data.profile;
      document.getElementById('formName').value = u.name || '';
      document.getElementById('formEmail').value = u.email || '';
      document.getElementById('formPhone').value = u.phone || '';
      document.getElementById('formBusiness').value = p.business_name || '';
      document.getElementById('formDesignation').value = p.designation || '';
      document.getElementById('formAddress').value = p.address || '';
      document.getElementById('formStart').value = u.membership_start || '';
      document.getElementById('formEnd').value = u.membership_end || '';
      editModal.classList.remove('hidden'); editModal.classList.add('flex');
    });

    document.getElementById('closeEdit').addEventListener('click', ()=> editModal.classList.add('hidden'));
    document.getElementById('cancelEdit').addEventListener('click', ()=> editModal.classList.add('hidden'));

    document.getElementById('editForm').addEventListener('submit', function(e){
      e.preventDefault();
      // save
      data.user.name = document.getElementById('formName').value;
      data.user.email = document.getElementById('formEmail').value;
      data.user.phone = document.getElementById('formPhone').value;
      data.profile.business_name = document.getElementById('formBusiness').value;
      data.profile.designation = document.getElementById('formDesignation').value;
      data.profile.address = document.getElementById('formAddress').value;
      data.user.membership_start = document.getElementById('formStart').value;
      data.user.membership_end = document.getElementById('formEnd').value;
      save();
      renderAll();
      editModal.classList.add('hidden');
    });

    // Export / Import / Reset
    document.getElementById('exportBtn').addEventListener('click', () => {
      const blob = new Blob([JSON.stringify(data, null, 2)], {type:'application/json'});
      const url = URL.createObjectURL(blob);
      const a = document.createElement('a');
      a.href = url; a.download = `tmn_member_${data.user.id || 'member'}.json`;
      document.body.appendChild(a); a.click(); a.remove(); URL.revokeObjectURL(url);
    });

    document.getElementById('importBtn').addEventListener('click', ()=> document.getElementById('importFile').click());
    document.getElementById('importFile').addEventListener('change', function(e){
      const f = e.target.files[0];
      if (!f) return;
      const reader = new FileReader();
      reader.onload = function(evt){
        try {
          const obj = JSON.parse(evt.target.result);
          if (confirm('Replace current member data with imported?')) {
            data = obj;
            save();
            renderAll();
            showToast('Imported');
          }
        } catch(err) { alert('Invalid JSON'); }
      };
      reader.readAsText(f);
      this.value = '';
    });

    document.getElementById('resetBtn').addEventListener('click', resetDemo);

    // initial render
    renderAll();

  })();
  </script>

  <script>feather.replace()</script>
@include('components.script')
