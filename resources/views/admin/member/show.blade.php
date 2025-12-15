@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto bg-white shadow-xl rounded-2xl p-8 mt-10">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between border-b pb-5 mb-6">
        <div>
            <h2 class="text-3xl font-semibold text-gray-800">Member Profile</h2>
            <p class="text-gray-500 text-sm mt-1">Detailed information about the TMN member.</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('admin.members.index') }}"
               class="inline-flex items-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium px-4 py-2 rounded-lg transition">
                ← Back to Members
            </a>
        </div>
    </div>

    <div class="grid md:grid-cols-[220px,1fr] gap-8 items-start">
        <!-- Profile Photo -->
        <div class="flex flex-col items-center">
            <div class="w-40 h-40 rounded-full overflow-hidden shadow-md">
                @if($member->basicInfo && $member->basicInfo->photo)
                    <img src="{{ asset('storage/'.$member->basicInfo->photo) }}" alt="Profile Photo" class="w-full h-full object-cover">
                @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($member->basicInfo->full_name ?? $member->name) }}&background=CF2031&color=fff&size=256"
                         alt="Avatar" class="w-full h-full object-cover">
                @endif
            </div>
            <h3 class="text-lg font-semibold mt-4 text-gray-800">
                {{ $member->basicInfo->full_name ?? $member->name }}
            </h3>
            <p class="text-gray-500 text-sm">{{ $member->basicInfo->profession ?? 'Member' }}</p>

            <div class="mt-3">
                @if(optional($member->adminData)->status === 'active')
                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                        Active Member
                    </span>
                @else
                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">
                        Pending Verification
                    </span>
                @endif
            </div>
        </div>

        <!-- Member Details -->
        <div class="space-y-8">
            <!-- Basic Info Card -->
            <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#CF2031]" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10 2a6 6 0 00-6 6v2a6 6 0 0012 0V8a6 6 0 00-6-6zM2 12a8 8 0 0116 0v1a2 2 0 01-2 2H4a2 2 0 01-2-2v-1z" />
                    </svg>
                    Basic Information
                </h4>
                <div class="grid md:grid-cols-2 gap-4 text-sm text-gray-700">
                    <p><strong>Email:</strong> {{ $member->email }}</p>
                    <p><strong>Mobile:</strong> {{ $member->basicInfo->contact_mobile ?? '—' }}</p>
                    <p><strong>Gender:</strong> {{ $member->basicInfo->gender ?? '—' }}</p>
                    <p><strong>Date of Birth:</strong> {{ $member->basicInfo->date_of_birth ?? '—' }}</p>
                    <p><strong>Membership ID:</strong> {{ $member->basicInfo->membership_id ?? '—' }}</p>
                    <p><strong>Date Joined:</strong> {{ $member->basicInfo->date_joined ? \Carbon\Carbon::parse($member->basicInfo->date_joined)->format('d M Y') : '—' }}</p>
                </div>
            </div>

            <!-- Business Info Card -->
            <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#CF2031]" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M2 9a1 1 0 011-1h14a1 1 0 011 1v8H2V9z" />
                        <path d="M9 2h2a1 1 0 011 1v3H8V3a1 1 0 011-1z" />
                    </svg>
                    Business Information
                </h4>
                <div class="text-sm text-gray-700 space-y-2">
                    <p><strong>Company:</strong> {{ $member->businessInfo->company_name ?? '—' }}</p>
                    <p><strong>Website:</strong>
                        @if($member->businessInfo && $member->businessInfo->website_url)
                            <a href="{{ $member->businessInfo->website_url }}" target="_blank" class="text-blue-600 hover:underline">
                                {{ $member->businessInfo->website_url }}
                            </a>
                        @else
                            —
                        @endif
                    </p>
                    <p><strong>Description:</strong></p>
                    <p class="text-gray-600 leading-relaxed">
                        {{ $member->businessInfo->business_description ?? 'No description provided.' }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="mt-10 border-t pt-6 flex justify-end">
        @if(optional($member->adminData)->status !== 'active')
            <form method="POST" action="{{ route('admin.members.activate', $member->id) }}"
                  onsubmit="return confirm('Are you sure you want to activate this member?')">
                @csrf
                <button type="submit"
                        class="bg-[#CF2031] hover:bg-[#b81b2a] text-white font-semibold px-6 py-2 rounded-lg shadow transition">
                    Activate Member
                </button>
            </form>
        @endif
    </div>
</div>
@endsection
