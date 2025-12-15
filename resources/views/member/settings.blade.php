@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8 space-y-10 bg-gray-50">

    {{-- HEADER --}}
    <div class="bg-gradient-to-r from-red-700 via-red-600 to-red-500 text-white rounded-2xl shadow-2xl px-10 py-8 flex flex-col md:flex-row justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold">Member Settings</h1>
            <p class="text-red-100">Manage your personal and business details</p>
        </div>
        <div>
            <a href="{{ route('member.dashboard') }}"
                class="bg-white text-red-600 font-semibold px-4 py-2 rounded-xl shadow hover:bg-red-50 transition-all">
                ← Back to Dashboard
            </a>
        </div>
    </div>

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- PROFILE OVERVIEW CARD --}}
    <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div class="flex items-center gap-4">
                {{-- Avatar --}}
                <div
                    class="w-16 h-16 bg-red-100 text-red-700 flex items-center justify-center rounded-full text-2xl font-bold uppercase">
                    {{ substr($user->name, 0, 1) }}
                </div>

                <div>
                    <h2 class="text-xl font-bold text-gray-800">{{ $user->name }}</h2>
                    <p class="text-gray-500 text-sm">{{ $user->email }}</p>
                    <p class="text-sm text-gray-600 mt-1">
                        <span class="font-medium">Role:</span> {{ ucfirst($user->role ?? 'Member') }}
                    </p>
                    @if($user->businessInfo)
                        <p class="text-sm text-gray-600">
                            <span class="font-medium">Company:</span> {{ $user->businessInfo->company_name ?? '—' }}
                        </p>
                        <p class="text-sm text-gray-600">
                            <span class="font-medium">Industry:</span> {{ $user->businessInfo->industry ?? '—' }}
                        </p>
                    @endif
                </div>
            </div>

            {{-- Quick Stats --}}
            <div class="grid grid-cols-3 md:gap-6 text-center">
                <div>
                    <p class="text-2xl font-bold text-red-600">{{ $user->networkingData->referrals_given ?? 0 }}</p>
                    <p class="text-sm text-gray-500">Referrals Given</p>
                </div>
                <div>
                    <p class="text-2xl font-bold text-red-600">{{ $user->networkingData->referrals_received ?? 0 }}</p>
                    <p class="text-sm text-gray-500">Referrals Received</p>
                </div>
                <div>
                    <p class="text-2xl font-bold text-red-600">
                        ₹{{ number_format($user->networkingData->closed_business_value ?? 0, 2) }}
                    </p>
                    <p class="text-sm text-gray-500">Closed Business</p>
                </div>
            </div>
        </div>
    </div>

    {{-- SETTINGS FORM --}}
    <form action="{{ route('member.settings.update') }}" method="POST"
        class="space-y-10 bg-white shadow-lg rounded-2xl p-8 border border-gray-100">
        @csrf

        {{-- 🧍 BASIC INFORMATION --}}
        <div>
            <h2 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-4">🧍 Basic Information</h2>
            <div class="grid md:grid-cols-2 gap-6">
                @foreach([
                    ['name'=>'full_name','label'=>'Full Name','value'=>$user->basicInfo->full_name ?? ''],
                    ['name'=>'gender','label'=>'Gender','value'=>$user->basicInfo->gender ?? ''],
                    ['name'=>'date_of_birth','label'=>'Date of Birth','value'=>$user->basicInfo->date_of_birth ?? '','type'=>'date'],
                    ['name'=>'contact_mobile','label'=>'Mobile','value'=>$user->basicInfo->contact_mobile ?? ''],
                    ['name'=>'email','label'=>'Email','value'=>$user->basicInfo->email ?? ''],
                    ['name'=>'linkedin','label'=>'LinkedIn','value'=>$user->basicInfo->linkedin ?? ''],
                ] as $field)
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-1">{{ $field['label'] }}</label>
                        <input type="{{ $field['type'] ?? 'text' }}" name="{{ $field['name'] }}"
                               value="{{ $field['value'] }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 transition placeholder-gray-400">
                    </div>
                @endforeach
            </div>
        </div>

        {{-- 🏢 BUSINESS INFORMATION --}}
        <div>
            <h2 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-4">🏢 Business Information</h2>
            <div class="grid md:grid-cols-2 gap-6">
                @foreach([
                    ['name'=>'company_name','label'=>'Company Name','value'=>$user->businessInfo->company_name ?? ''],
                    ['name'=>'industry','label'=>'Industry','value'=>$user->businessInfo->industry ?? ''],
                    ['name'=>'business_type','label'=>'Business Type','value'=>$user->businessInfo->business_type ?? ''],
                    ['name'=>'website_url','label'=>'Website','value'=>$user->businessInfo->website_url ?? '']
                ] as $field)
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-1">{{ $field['label'] }}</label>
                        <input type="text" name="{{ $field['name'] }}" value="{{ $field['value'] }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 transition placeholder-gray-400">
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                <label class="block text-sm font-semibold text-gray-600 mb-1">Business Description</label>
                <textarea name="business_description" rows="4"
                          class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 transition placeholder-gray-400">{{ $user->businessInfo->business_description ?? '' }}</textarea>
            </div>
        </div>

        {{-- 🔗 NETWORKING DATA --}}
        <div>
            <h2 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-4">🔗 Networking Data</h2>
            <div class="grid md:grid-cols-3 gap-6">
                @foreach([
                    ['name'=>'referrals_given','label'=>'Referrals Given','value'=>$user->networkingData->referrals_given ?? ''],
                    ['name'=>'referrals_received','label'=>'Referrals Received','value'=>$user->networkingData->referrals_received ?? ''],
                    ['name'=>'closed_business_value','label'=>'Closed Business Value','value'=>$user->networkingData->closed_business_value ?? '']
                ] as $field)
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-1">{{ $field['label'] }}</label>
                        <input type="text" name="{{ $field['name'] }}" value="{{ $field['value'] }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 transition placeholder-gray-400">
                    </div>
                @endforeach
            </div>
        </div>

        {{-- 🧠 RELATIONSHIP INTELLIGENCE --}}
        <div>
            <h2 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-4">🧠 Relationship Intelligence</h2>
            <div class="grid md:grid-cols-2 gap-6">
                @foreach([
                    ['name'=>'connection_strength','label'=>'Connection Strength','value'=>$user->relationshipIntelligence->connection_strength ?? ''],
                    ['name'=>'preferred_communication','label'=>'Preferred Communication','value'=>$user->relationshipIntelligence->preferred_communication ?? ''],
                    ['name'=>'interests','label'=>'Interests','value'=>$user->relationshipIntelligence->interests ?? '']
                ] as $field)
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-1">{{ $field['label'] }}</label>
                        <input type="text" name="{{ $field['name'] }}" value="{{ $field['value'] }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 transition placeholder-gray-400">
                    </div>
                @endforeach
            </div>
        </div>

        {{-- 📎 SUPPORTING DATA --}}
        <div>
            <h2 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-4">📎 Supporting Data</h2>
            <div class="grid md:grid-cols-2 gap-6">
                @foreach([
                    ['name'=>'business_cards','label'=>'Business Cards','value'=>$user->supportingData->business_cards ?? ''],
                    ['name'=>'awards','label'=>'Awards','value'=>$user->supportingData->awards ?? '']
                ] as $field)
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-1">{{ $field['label'] }}</label>
                        <input type="text" name="{{ $field['name'] }}" value="{{ $field['value'] }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 transition placeholder-gray-400">
                    </div>
                @endforeach
            </div>
        </div>

        {{-- SAVE BUTTON --}}
        <div class="flex justify-end">
            <button
                class="bg-red-600 hover:bg-red-700 text-white px-8 py-3 rounded-xl shadow-md font-semibold text-sm tracking-wide transition-all">
                💾 Save Changes
            </button>
        </div>
    </form>
</div>
@endsection
