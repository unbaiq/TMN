@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto mt-10 bg-white shadow-xl rounded-2xl p-8">
    <!-- HEADER -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-3xl font-semibold text-gray-800 flex items-center gap-2">
                <i data-feather="bar-chart-2" class="w-7 h-7 text-[#CF2031]"></i>
                Chapter Dashboard - {{ $chapter->name }}
            </h2>
            <p class="text-gray-500 text-sm mt-1">{{ $chapter->city }} | Code: {{ $chapter->chapter_code }}</p>
        </div>

        <a href="{{ route('admin.chapters.index') }}" 
           class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm flex items-center gap-2">
           <i data-feather="arrow-left" class="w-4 h-4"></i> Back to Chapters
        </a>
    </div>

    <!-- KPI CARDS -->
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Members -->
        <div class="bg-gradient-to-r from-[#CF2031] to-[#b81b2a] text-white rounded-xl p-5 shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-80">Total Members</p>
                    <h3 class="text-3xl font-bold mt-1">{{ $chapter->members->count() }}</h3>
                </div>
                <i data-feather="users" class="w-8 h-8 opacity-80"></i>
            </div>
        </div>

        <!-- Revenue -->
        <div class="bg-gradient-to-r from-green-500 to-green-600 text-white rounded-xl p-5 shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-80">Total Revenue (FY 2025)</p>
                    <h3 class="text-3xl font-bold mt-1">₹{{ number_format(2450000, 2) }}</h3>
                </div>
                <i data-feather="trending-up" class="w-8 h-8 opacity-80"></i>
            </div>
        </div>

        <!-- Referrals -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-xl p-5 shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-80">Referrals This Month</p>
                    <h3 class="text-3xl font-bold mt-1">{{ rand(80, 130) }}</h3>
                </div>
                <i data-feather="repeat" class="w-8 h-8 opacity-80"></i>
            </div>
        </div>

        <!-- Attendance -->
        <div class="bg-gradient-to-r from-yellow-500 to-amber-500 text-white rounded-xl p-5 shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-80">Avg. Attendance</p>
                    <h3 class="text-3xl font-bold mt-1">{{ rand(85, 100) }}%</h3>
                </div>
                <i data-feather="pie-chart" class="w-8 h-8 opacity-80"></i>
            </div>
        </div>
    </div>

    <!-- CHAPTER DETAILS -->
    <div class="bg-gray-50 rounded-xl p-6 mb-8 border border-gray-200">
    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
        <i data-feather="info" class="w-5 h-5 text-[#CF2031]"></i>
        Chapter Overview
    </h3>

    <div class="grid md:grid-cols-2 gap-6 text-sm text-gray-700">
        <div>
            <p><strong>Chapter Code:</strong> {{ $chapter->chapter_code }}</p>
            <p><strong>City:</strong> {{ $chapter->city ?? '—' }}</p>

            {{-- ✅ State --}}
            <p><strong>State:</strong> {{ $chapter->state ?? '—' }}</p>

            {{-- ✅ Country --}}
            <p><strong>Country:</strong> {{ $chapter->country ?? '—' }}</p>

            <p><strong>Pincode:</strong> {{ $chapter->pincode ?? '—' }}</p>

            <p><strong>Status:</strong>
                @if($chapter->is_active)
                    <span class="text-green-600 font-semibold">Active</span>
                @else
                    <span class="text-gray-500 font-semibold">Inactive</span>
                @endif
            </p>
        </div>

        <div>
            <p><strong>Capacity:</strong> {{ $chapter->capacity_no ?? 'Unlimited' }}</p>
            <p><strong>Created On:</strong> {{ $chapter->created_at->format('d M Y') }}</p>
            <p><strong>Total Members:</strong> {{ $chapter->members->count() }}</p>
            <p><strong>Filled:</strong>
                {{ round(($chapter->members->count() / max(1, $chapter->capacity_no)) * 100, 1) }}%
            </p>
        </div>
    </div>

    <p class="mt-4 text-gray-600 text-sm">
        <strong>Description:</strong><br>
        {{ $chapter->description ?? 'No description available.' }}
    </p>
</div>

            <div>
                <p><strong>Capacity:</strong> {{ $chapter->capacity_no ?? 'Unlimited' }}</p>
                <p><strong>Created On:</strong> {{ $chapter->created_at->format('d M Y') }}</p>
                <p><strong>Total Members:</strong> {{ $chapter->members->count() }}</p>
                <p><strong>Filled:</strong> 
                    {{ round(($chapter->members->count() / max(1, $chapter->capacity_no)) * 100, 1) }}%
                </p>
            </div>
        </div>
        <p class="mt-4 text-gray-600 text-sm"><strong>Description:</strong><br>{{ $chapter->description ?? 'No description available.' }}</p>
    </div>

    <!-- PERFORMANCE STATS -->
    <div class="grid md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
            <h4 class="text-sm font-semibold text-gray-700 mb-2">Total Business Generated</h4>
            <p class="text-2xl font-bold text-green-600">₹{{ number_format(2450000, 2) }}</p>
            <p class="text-xs text-gray-500 mt-1">As reported in last 12 months</p>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
            <h4 class="text-sm font-semibold text-gray-700 mb-2">Member Retention Rate</h4>
            <p class="text-2xl font-bold text-blue-600">{{ rand(80, 95) }}%</p>
            <p class="text-xs text-gray-500 mt-1">Active members staying beyond 1 year</p>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
            <h4 class="text-sm font-semibold text-gray-700 mb-2">Monthly Growth Rate</h4>
            <p class="text-2xl font-bold text-[#CF2031]">+{{ rand(2, 8) }}%</p>
            <p class="text-xs text-gray-500 mt-1">Based on last quarter average</p>
        </div>
    </div>

    <!-- MEMBER TABLE -->
    <div class="bg-white rounded-xl shadow border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <i data-feather="users" class="w-5 h-5 text-[#CF2031]"></i>
            Member List ({{ $chapter->members->count() }})
        </h3>

        @if($chapter->members->isEmpty())
            <p class="text-gray-500 text-sm">No members have joined this chapter yet.</p>
        @else
            <table class="min-w-full text-sm border border-gray-100 rounded-lg">
                <thead class="bg-gray-100 text-gray-600 uppercase text-xs font-semibold">
                    <tr>
                        <th class="py-2 px-3 border text-left">Name</th>
                        <th class="py-2 px-3 border text-left">Email</th>
                        <th class="py-2 px-3 border text-left">Profession</th>
                        <th class="py-2 px-3 border text-left">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($chapter->members as $member)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-2 px-3 border font-medium text-gray-800">{{ $member->name }}</td>
                            <td class="py-2 px-3 border text-gray-600">{{ $member->email }}</td>
                            <td class="py-2 px-3 border text-gray-600">
                                {{ $member->basicInfo->profession ?? '—' }}
                            </td>
                            <td class="py-2 px-3 border">
                                @if(optional($member->adminData)->status === 'active')
                                    <span class="px-2 py-1 rounded text-xs bg-green-100 text-green-700 font-medium">Active</span>
                                @else
                                    <span class="px-2 py-1 rounded text-xs bg-red-100 text-red-700 font-medium">Inactive</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>

<script>
    feather.replace();
</script>
@endsection
