@extends('layouts.app')

@section('content')

<script src="https://unpkg.com/feather-icons"></script>

<style>
    :root{
        --tmn-red:#e53935;
        --panel-bg:#ffffff;
        --muted:#6b7280;
        --bg-soft:#f3f4f8;
    }

    body{
        background: var(--bg-soft);
        font-family: Inter, ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
    }

    .card{
        background: var(--panel-bg);
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(15,23,42,0.06);
        border: 1px solid rgba(148,163,184,0.18);
    }

    .pill{
        padding:6px 10px;
        border-radius:999px;
        font-size:.75rem;
        font-weight:600;
    }
    .badge-active{
        background: linear-gradient(90deg,#ecfdf5,#bbf7d0);
        color:#065f46;
    }
    .muted{ color:var(--muted); }
    .section-title{ font-weight:700; color:#111827; }
    .small{ font-size:0.85rem; }

    .info-row{
        border-top:1px solid #f3f4f6;
        padding-top:0.75rem;
        padding-bottom:0.75rem;
    }

    /* PAGE HEADER (like screenshot) */
    .page-icon{
        width: 38px;
        height: 38px;
        border-radius: 12px;
        background: #fee2e2;
        display:flex;
        align-items:center;
        justify-content:center;
        color:#b91c1c;
    }

    /* TOP SUMMARY CARD */
    .accent-line{
        height:6px;
        border-radius:8px;
        background: linear-gradient(90deg,#fb923c,#ef4444,#ef5350);
        opacity:.14;
        margin:-1rem 1.5rem 0.5rem;
    }

    .summary-tag{
        font-size:.75rem;
        color:#6b7280;
    }

    /* coloured tiles row (Email / Phone / Profession / Status) */
    .summary-tiles{
        display:grid;
        grid-template-columns: repeat(1,minmax(0,1fr));
        gap:0.75rem;
    }

    @media (min-width:768px){
        .summary-tiles{
            grid-template-columns: repeat(4,minmax(0,1fr));
        }
    }

    .summary-tile{
        border-radius:14px;
        padding:0.9rem 1rem;
        display:flex;
        align-items:flex-start;
        gap:0.65rem;
        color:#fff;
        box-shadow: 0 10px 25px rgba(15,23,42,0.18);
    }
    .summary-tile span.label{
        font-size:0.75rem;
        opacity:.9;
    }
    .summary-tile span.value{
        font-size:0.9rem;
        font-weight:600;
    }

    .tile-email{
        background: linear-gradient(135deg,#2563eb,#1d4ed8);
    }
    .tile-phone{
        background: linear-gradient(135deg,#16a34a,#15803d);
    }
    .tile-prof{
        background: linear-gradient(135deg,#8b5cf6,#7c3aed);
    }
    .tile-status{
        background: linear-gradient(135deg,#f9fafb,#e5e7eb);
        color:#111827;
        box-shadow: 0 8px 18px rgba(148,163,184,0.35);
    }

    /* small info cards like Membership / Payment / Account */
    .mini-info-row{
        margin-top:1rem;
        display:grid;
        gap:0.75rem;
    }
    @media (min-width:768px){
        .mini-info-row{
            grid-template-columns: repeat(3,minmax(0,1fr));
        }
    }
    .mini-card{
        border-radius:14px;
        border:1px solid #e5e7eb;
        background:#fdfdfd;
        padding:0.75rem 1rem;
        font-size:0.8rem;
    }
    .mini-card-title{
        font-weight:600;
        color:#111827;
        margin-bottom:0.25rem;
    }
    .mini-card-label{
        font-size:0.7rem;
        color:#9ca3af;
    }

    /* TABS (look like screenshot) */
    .tab-bar{
        border-bottom:1px solid #e5e7eb;
    }
    .tab-btn{
        position:relative;
        padding:0.6rem 0.4rem;
        margin-right:1.5rem;
        font-size:0.85rem;
        color:#6b7280;
        display:inline-flex;
        align-items:center;
        gap:0.4rem;
        font-weight:500;
    }
    .tab-btn svg{
        width:16px;
        height:16px;
    }
    .tab-btn.tab-active{
        color:#111827;
    }
    .tab-btn.tab-active::after{
        content:"";
        position:absolute;
        left:0;
        right:0;
        bottom:-1px;
        height:3px;
        border-radius:999px;
        background:#2563eb;
    }

    /* Toast */
    #toast > div{
        margin-top:0.5rem;
    }
</style>

<div class="max-w-6xl mx-auto px-4 lg:px-8 py-6 space-y-6">

    {{-- PAGE HEADING (top bar like screenshot) --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="page-icon">
                <i data-feather="users"></i>
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl font-semibold text-slate-900">Member Details</h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                    View and manage member profile, attendance, services and more.
                </p>
            </div>
        </div>

        {{-- optional toolbar (export / import / reset demo) --}}
        <div class="flex items-center gap-2">
            <button id="exportBtn"
                    class="hidden sm:inline-flex items-center gap-2 px-3 py-1.5 text-xs rounded-lg border bg-white hover:bg-slate-50">
                <i data-feather="download" class="w-3 h-3"></i> Export JSON
            </button>
            <button id="importBtn"
                    class="hidden sm:inline-flex items-center gap-2 px-3 py-1.5 text-xs rounded-lg border bg-white hover:bg-slate-50">
                <i data-feather="upload" class="w-3 h-3"></i> Import
            </button>
            <button id="resetBtn"
                    class="hidden sm:inline-flex items-center gap-2 px-3 py-1.5 text-xs rounded-lg border border-red-100 text-red-600 bg-red-50/60 hover:bg-red-100/80">
                <i data-feather="rotate-ccw" class="w-3 h-3"></i> Reset Demo
            </button>
            <input id="importFile" type="file" accept="application/json" class="hidden">
        </div>
    </div>

    <!-- PROFILE TOP / SUMMARY (styled like screenshot) -->
    <section class="card p-5 lg:p-6 relative">
        <div class="accent-line"></div>

        <div class="mt-2 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-red-100 flex items-center justify-center text-red-600 text-xl sm:text-2xl font-bold">
                    R
                </div>
                <div>
                    <div class="flex flex-wrap items-center gap-3">
                        <h2 id="memberName" class="text-xl sm:text-2xl font-semibold">Ramesh Kumar</h2>
                        <div id="roleBadge" class="pill badge-active">Member</div>
                        <div id="activeBadge" class="pill bg-gray-100 text-gray-700">Active</div>
                    </div>
                    <div class="text-sm muted mt-1" id="memberBusiness">Ramesh Enterprises • Delhi</div>
                    <div class="summary-tag mt-1">
                        Member ID: <span class="font-medium">TMN-201</span> •
                        Referral: <span id="referralCode">TMN-AB12</span> •
                        Member since <span id="memberStart">2024-02-01</span> •
                        Expires <span id="memberEnd">2025-02-01</span>
                    </div>
                </div>
            </div>

            <div class="flex items-end gap-4 justify-between md:justify-end">
                <div class="text-right">
                    <div class="text-xs summary-tag">Total Amount</div>
                    <div id="totalAmount" class="text-xl font-semibold text-slate-900">₹ 12,500.00</div>
                </div>
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
                    <button id="editProfileBtn"
                            class="inline-flex items-center justify-center gap-2 px-3 py-2 text-xs sm:text-sm bg-white border border-slate-200 rounded-lg shadow-sm hover:bg-slate-50">
                        <i data-feather="edit-2" class="w-4 h-4"></i>
                        Edit
                    </button>
                    <button id="messageBtn"
                            class="inline-flex items-center justify-center gap-2 px-3 py-2 text-xs sm:text-sm bg-[#2563eb] hover:bg-[#1d4ed8] text-white rounded-lg shadow">
                        <i data-feather="send" class="w-4 h-4"></i>
                        Message
                    </button>
                </div>
            </div>
        </div>

        {{-- coloured tiles like screenshot --}}
        <div class="mt-5 summary-tiles">
            <div class="summary-tile tile-email">
                <div class="pt-0.5">
                    <i data-feather="mail" class="w-5 h-5"></i>
                </div>
                <div>
                    <span class="label block">Email</span>
                    <span id="memberEmailSummary" class="value block">ramesh@example.com</span>
                </div>
            </div>

            <div class="summary-tile tile-phone">
                <div class="pt-0.5">
                    <i data-feather="phone" class="w-5 h-5"></i>
                </div>
                <div>
                    <span class="label block">Phone</span>
                    <span class="value block">+91 98765 43210</span>
                </div>
            </div>

            <div class="summary-tile tile-prof">
                <div class="pt-0.5">
                    <i data-feather="briefcase" class="w-5 h-5"></i>
                </div>
                <div>
                    <span class="label block">Profession</span>
                    <span class="value block">Not specified</span>
                </div>
            </div>

            <div class="summary-tile tile-status">
                <div class="pt-0.5">
                    <i data-feather="shield" class="w-5 h-5"></i>
                </div>
                <div>
                    <span class="label block">Status</span>
                    <span class="value block" id="statusSummary">Active</span>
                </div>
            </div>
        </div>

        {{-- small info cards row (Membership / Payment / Account) --}}
        <div class="mini-info-row">
            <div class="mini-card">
                <div class="mini-card-title flex items-center gap-1">
                    <i data-feather="credit-card" class="w-4 h-4 text-indigo-500"></i>
                    Membership
                </div>
                <div class="grid grid-cols-2 gap-y-1 mt-2">
                    <div class="mini-card-label">Number</div>
                    <div class="text-xs text-slate-700 text-right">Not assigned</div>
                    <div class="mini-card-label">Start date</div>
                    <div class="text-xs text-slate-700 text-right" id="membershipStartMini">2024-02-01</div>
                </div>
            </div>

            <div class="mini-card">
                <div class="mini-card-title flex items-center gap-1">
                    <i data-feather="dollar-sign" class="w-4 h-4 text-emerald-500"></i>
                    Payment
                </div>
                <div class="grid grid-cols-2 gap-y-1 mt-2">
                    <div class="mini-card-label">Amount</div>
                    <div class="text-xs text-slate-700 text-right">N/A</div>
                    <div class="mini-card-label">Last paid</div>
                    <div class="text-xs text-slate-700 text-right">N/A</div>
                </div>
            </div>

            <div class="mini-card">
                <div class="mini-card-title flex items-center gap-1">
                    <i data-feather="user-check" class="w-4 h-4 text-violet-500"></i>
                    Account
                </div>
                <div class="grid grid-cols-2 gap-y-1 mt-2">
                    <div class="mini-card-label">Role</div>
                    <div class="text-xs text-slate-700 text-right" id="roleMini">Member</div>
                    <div class="mini-card-label">Created</div>
                    <div class="text-xs text-slate-700 text-right">7 Oct 2024</div>
                </div>
            </div>
        </div>
    </section>

    {{-- BELOW: main layout: left column cards + tabs (JS unchanged) --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">


<!-- RIGHT: Tabs & Main Content -->
<div class="w-full">
    <div class="card p-4">

        <!-- TAB BAR -->
        <div class="tab-bar flex items-center gap-6 pb-1 border-b overflow-x-auto">
            <button class="tab-btn tab-active" data-tab="overview"><i data-feather="grid"></i><span>Overview</span></button>
            <button class="tab-btn" data-tab="attendance"><i data-feather="calendar"></i><span>Attendance</span></button>
            <button class="tab-btn" data-tab="invest"><i data-feather="trending-up"></i><span>Investments</span></button>
            <button class="tab-btn" data-tab="meet"><i data-feather="users"></i><span>1-1 Meetups</span></button>
            <button class="tab-btn" data-tab="services"><i data-feather="briefcase"></i><span>Services</span></button>
            <button class="tab-btn" data-tab="give"><i data-feather="arrow-up-circle"></i><span>Give</span></button>
            <button class="tab-btn" data-tab="take"><i data-feather="arrow-down-circle"></i><span>Take</span></button>
            <button class="tab-btn" data-tab="referrals"><i data-feather="share-2"></i><span>Referrals</span></button>
            <button class="tab-btn" data-tab="business"><i data-feather="briefcase"></i><span>Business</span></button>
            <button class="tab-btn" data-tab="cluster"><i data-feather="layers"></i><span>Cluster Meetings</span></button>
            <button class="tab-btn" data-tab="recognitions"><i data-feather="award"></i><span>Recognitions</span></button>
        </div>

        <div class="mt-4">

            <!-- ========== OVERVIEW TAB ========== -->
            <div class="tab-content" id="overview">

                <div class="p-4 border rounded-xl bg-slate-50/40">
                    <h4 class="font-semibold text-slate-900">Chapter & Participation</h4>
                    <div class="mt-3 small muted">Assigned Chapter</div>
                    <div id="assignedChapter" class="font-medium text-slate-900"></div>

                    <div class="small muted mt-3">Cluster Meetings attended</div>
                    <ul id="clusterList" class="mt-2 list-disc list-inside text-sm"></ul>
                </div>

                <div class="p-4 border rounded-xl bg-slate-50/40 mt-4">
                    <h4 class="font-semibold text-slate-900">Business Snapshot</h4>

                    <div class="mt-3 small muted">Turnover (last FY)</div>
                    <div id="businessTurnover" class="font-medium text-slate-900"></div>

                    <div class="small muted mt-3">Business Category</div>
                    <div id="businessCategory" class="font-medium text-slate-900"></div>
                </div>

                <div class="mt-4">
                    <h4 class="font-semibold text-slate-900">Recent Activity</h4>
                    <div id="activityList" class="mt-2 space-y-2 small muted"></div>
                </div>

            </div>

            <!-- ========== ATTENDANCE TAB ========== -->
            <div class="tab-content hidden" id="attendance">

                <div class="p-4 border rounded-xl bg-slate-50/40">
                    <h4 class="font-semibold text-slate-900">Events Attended</h4>
                    <table class="w-full text-sm mt-3">
                        <thead class="text-xs muted"><tr><th>Event</th><th>Date</th><th>Status</th></tr></thead>
                        <tbody id="eventsAttended"></tbody>
                    </table>
                </div>

                <div class="p-4 border rounded-xl bg-slate-50/40 mt-4">
                    <h4 class="font-semibold text-slate-900">Chapter Attendance</h4>
                    <table class="w-full text-sm mt-3">
                        <thead class="text-xs muted"><tr><th>Chapter</th><th>Meet</th><th>Date</th></tr></thead>
                        <tbody id="chapterAttendance"></tbody>
                    </table>
                </div>

            </div>

            <!-- ========== INVESTMENTS TAB ========== -->
            <div class="tab-content hidden" id="invest">

                <div class="p-4 border rounded-xl bg-slate-50/40">
                    <h4 class="font-semibold text-slate-900">Investor Details</h4>

                    <div class="mt-3 small muted">Amount to Invest</div>
                    <div id="investAmount" class="font-medium text-slate-900"></div>

                    <div class="mt-3 small muted">Interested Categories</div>
                    <div id="investCategories" class="font-medium text-slate-900"></div>

                    <div class="mt-3 small muted">Preferred Stage</div>
                    <div id="investStage" class="font-medium text-slate-900"></div>

                    <div class="mt-4">
                        <h5 class="font-semibold text-slate-900">Past Investments</h5>
                        <table class="w-full text-sm mt-2">
                            <thead class="text-xs muted"><tr><th>Recipient</th><th>Amount</th><th>Date</th></tr></thead>
                            <tbody id="pastInvestments"></tbody>
                        </table>
                    </div>
                </div>

            </div>

            <!-- ========== 1-1 MEETUPS TAB ========== -->
            <div class="tab-content hidden" id="meet">

                <div class="p-4 border rounded-xl bg-slate-50/40">
                    <h4 class="font-semibold text-slate-900">1-1 Meetups</h4>
                    <table class="w-full text-sm mt-3">
                        <thead class="text-xs muted"><tr><th>With</th><th>Date</th><th>Notes</th></tr></thead>
                        <tbody id="meetupsList"></tbody>
                    </table>
                </div>

            </div>

            <!-- ========== SERVICES TAB ========== -->
            <div class="tab-content hidden" id="services">

                <div class="p-4 border rounded-xl bg-slate-50/40">
                    <h4 class="font-semibold text-slate-900">Services Availed</h4>
                    <table class="w-full text-sm mt-3">
                        <thead class="text-xs muted"><tr><th>Service</th><th>Provider</th><th>Date</th><th>Status</th></tr></thead>
                        <tbody id="servicesAvailed"></tbody>
                    </table>

                    <div class="mt-4">
                        <h4 class="font-semibold text-slate-900">Services Given</h4>
                        <table class="w-full text-sm mt-3">
                            <thead class="text-xs muted"><tr><th>Service</th><th>Client</th><th>Date</th></tr></thead>
                            <tbody id="servicesGiven"></tbody>
                        </table>
                    </div>
                </div>

            </div>

            <!-- ========== GIVE TAB ========== -->
            <div class="tab-content hidden" id="give">
                <div class="p-4 border rounded-xl bg-slate-50/40">
                    <h4 class="font-semibold text-slate-900">Give Records</h4>
                    <table class="w-full text-sm mt-3">
                        <thead class="text-xs muted"><tr><th>Date</th><th>To</th><th>Category</th><th>Value</th><th>Notes</th></tr></thead>
                        <tbody id="giveTable"></tbody>
                    </table>
                </div>
            </div>

            <!-- ========== TAKE TAB ========== -->
            <div class="tab-content hidden" id="take">
                <div class="p-4 border rounded-xl bg-slate-50/40">
                    <h4 class="font-semibold text-slate-900">Take Records</h4>
                    <table class="w-full text-sm mt-3">
                        <thead class="text-xs muted"><tr><th>Date</th><th>From</th><th>Category</th><th>Value</th><th>Notes</th></tr></thead>
                        <tbody id="takeTable"></tbody>
                    </table>
                </div>
            </div>

            <!-- ========== REFERRALS TAB ========== -->
            <div class="tab-content hidden" id="referrals">
                <div class="p-4 border rounded-xl bg-slate-50/40">
                    <h4 class="font-semibold text-slate-900">Referral Records</h4>
                    <table class="w-full text-sm mt-3">
                        <thead class="text-xs muted"><tr><th>ID</th><th>To</th><th>Status</th><th>Value</th><th>Date</th></tr></thead>
                        <tbody id="referralTable"></tbody>
                    </table>
                </div>
            </div>

            <!-- ========== BUSINESS TAB ========== -->
            <div class="tab-content hidden" id="business">
                <div class="p-4 border rounded-xl bg-slate-50/40">
                    <h4 class="font-semibold text-slate-900">Business Information</h4>
                    <table class="w-full text-sm mt-3">
                        <thead class="text-xs muted"><tr><th>Name</th><th>Category</th><th>Turnover</th><th>City</th><th>Website</th></tr></thead>
                        <tbody id="businessTable"></tbody>
                    </table>
                </div>
            </div>

            <!-- ========== CLUSTER MEETINGS TAB ========== -->
            <div class="tab-content hidden" id="cluster">
                <div class="p-4 border rounded-xl bg-slate-50/40">
                    <h4 class="font-semibold text-slate-900">Cluster Meetings</h4>
                    <table class="w-full text-sm mt-3">
                        <thead class="text-xs muted"><tr><th>Title</th><th>Chapter</th><th>Date</th><th>Notes</th></tr></thead>
                        <tbody id="clusterTable"></tbody>
                    </table>
                </div>
            </div>

            <!-- ========== RECOGNITIONS TAB ========== -->
            <div class="tab-content hidden" id="recognitions">
                <div class="p-4 border rounded-xl bg-slate-50/40">
                    <h4 class="font-semibold text-slate-900">Recognitions</h4>
                    <table class="w-full text-sm mt-3">
                        <thead class="text-xs muted"><tr><th>Title</th><th>By</th><th>Category</th><th>Date</th></tr></thead>
                        <tbody id="recognitionsTable"></tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>
</div>

<!-- EDIT PROFILE MODAL (unchanged structure, just works with new UI) -->
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

<!-- Toast -->
<div id="toast" class="fixed right-6 bottom-6 z-50"></div>

<script>
  // === Demo client-side Member Detail page (JS unchanged, just works with new UI) ===
  (function(){
    feather.replace();

    const KEY = 'tmn_member_demo_v1';

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

    function showToast(msg='Saved', type='success'){
      const t = document.createElement('div');
      t.className = 'px-4 py-2 rounded shadow text-white ' + (type==='success' ? 'bg-green-600' : 'bg-gray-800');
      t.textContent = msg;
      document.getElementById('toast').appendChild(t);
      setTimeout(()=> t.remove(), 2200);
    }

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

    function renderProfile(){
      const u = data.user;
      const p = data.profile;

      document.getElementById('memberName').textContent = u.name;
      document.getElementById('memberBusiness').textContent = `${p.business_name} • ${p.city}`;
      document.getElementById('memberBusinessFull').textContent = `${p.business_name} — ${p.business_description}`;
      document.getElementById('memberEmail').textContent = u.email;
      document.getElementById('memberEmailSummary').textContent = u.email;
      document.getElementById('memberPhone').textContent = u.phone;
      document.getElementById('memberAddress').textContent = p.address;
      document.getElementById('memberDesignation').textContent = p.designation;
      document.getElementById('referId').textContent = u.refer_id || '-';
      document.getElementById('role').textContent = u.role;
      document.getElementById('roleMini').textContent = u.role || '-';
      document.getElementById('emailVerified').textContent = u.email_verified_at ? 'Yes' : 'No';
      document.getElementById('isActive').textContent = u.is_active ? 'Yes' : 'No';
      document.getElementById('statusSummary').textContent = u.is_active ? 'Active' : 'Inactive';
      document.getElementById('totalAmount').textContent = `₹ ${Number(u.total_amount||0).toLocaleString('en-IN')}`;
      document.getElementById('referralCode').textContent = u.referral_code || '-';
      document.getElementById('memberStart').textContent = u.membership_start || '-';
      document.getElementById('memberEnd').textContent = u.membership_end || '-';
      document.getElementById('membershipStartMini').textContent = u.membership_start || '-';
      document.getElementById('roleBadge').textContent = (u.role || 'member').toUpperCase();
      document.getElementById('activeBadge').textContent = u.is_active ? 'Active' : 'Inactive';

      document.getElementById('csrCategories').textContent = (data.csr.categories || []).join(', ');
      document.getElementById('csrAmount').textContent = `₹ ${Number(data.csr.pledged_amount||0).toLocaleString('en-IN')}`;
      document.getElementById('csrNotes').textContent = data.csr.notes || '-';

      document.getElementById('assignedChapter').textContent = data.chapter.assigned?.name || '-';

      const clusterList = document.getElementById('clusterList');
      clusterList.innerHTML = '';
      data.cluster_meetings.forEach(m => {
        const li = document.createElement('li');
        li.textContent = `${m.title} — ${m.date}`;
        clusterList.appendChild(li);
      });

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
    const exportBtn = document.getElementById('exportBtn');
    const importBtn = document.getElementById('importBtn');
    const resetBtn  = document.getElementById('resetBtn');
    const importFile= document.getElementById('importFile');

    if (exportBtn){
      exportBtn.addEventListener('click', () => {
        const blob = new Blob([JSON.stringify(data, null, 2)], {type:'application/json'});
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url; a.download = `tmn_member_${data.user.id || 'member'}.json`;
        document.body.appendChild(a); a.click(); a.remove(); URL.revokeObjectURL(url);
      });
    }

    if (importBtn && importFile){
      importBtn.addEventListener('click', ()=> importFile.click());
      importFile.addEventListener('change', function(e){
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
    }

    if (resetBtn){
      resetBtn.addEventListener('click', resetDemo);
    }

    renderAll();
  })();
</script>

<script>feather.replace()
</script>
@endsection