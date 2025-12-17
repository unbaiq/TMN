@extends('layouts.app')

@section('content')
<style>
/* Modern Button Style */
button {
    transition: all 0.25s ease;
}
button:hover {
    transform: translateY(-2px);
}

/* INPUTS */
input,
select,
textarea {
    transition: all .2s ease-in-out;
}

input:focus,
select:focus,
textarea:focus {
    border-color: #e11d48 !important;
    box-shadow: 0 0 0 3px rgba(225,29,72,0.25);
    outline: none;
}
</style>
<div class="max-w-7xl mx-auto px-6 py-10 space-y-10">

    {{-- ==== HEADER ==== --}}
    <div class="bg-gradient-to-r from-red-600 via-red-500 to-orange-400 rounded-2xl shadow-lg px-8 py-10 flex flex-col md:flex-row md:items-center md:justify-between text-white relative overflow-hidden">
        <div class="relative z-10">
            <h2 class="text-3xl font-bold tracking-tight">Event Attendance</h2>
            <p class="text-red-100 mt-2 text-sm md:text-base">
                Managing attendance for <span class="font-semibold">{{ $event->title }}</span>
            </p>
        </div>

        <a href="{{ route('admin.events.attended') }}"
           class="inline-flex items-center gap-2 text-sm font-medium bg-white/10 hover:bg-white/20 px-5 py-2.5 rounded-xl backdrop-blur transition relative z-10">
            <i data-feather="arrow-left" class="w-4"></i> Back to Events
        </a>

        <div class="absolute right-0 top-0 w-56 h-56 bg-white/10 rounded-full blur-3xl opacity-30"></div>
    </div>

    {{-- ==== ALERT ==== --}}
    @if (session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl shadow-sm flex items-center gap-2">
            <i data-feather="check-circle" class="w-5"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- ==== ATTENDANCE FORM ==== --}}
    <form action="{{ route('admin.events.attendance.update', $event->id) }}" method="POST" class="bg-white border border-gray-200 shadow-xl rounded-2xl overflow-hidden relative">
        @csrf

        {{-- Table Header --}}
        <div class="px-6 py-4 border-b bg-gray-50 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-800">Member Attendance List</h3>
            <span class="text-sm text-gray-500">Total Members: {{ $members->count() }}</span>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-100 text-gray-700 border-b sticky top-0 z-10">
                    <tr>
                        <th class="px-6 py-3 font-medium">#</th>
                        <th class="px-6 py-3 font-medium">Member</th>
                        <th class="px-6 py-3 font-medium">Email</th>
                        <th class="px-6 py-3 font-medium text-center">Attendance</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($members as $index => $member)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-gray-600">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 font-medium text-gray-800 flex items-center gap-2">
                                <div class="w-8 h-8 bg-gradient-to-br from-red-100 to-orange-100 rounded-full flex items-center justify-center text-sm font-semibold text-red-700">
                                    {{ strtoupper(substr($member->name, 0, 1)) }}
                                </div>
                                {{ $member->name }}
                            </td>
                            <td class="px-6 py-4 text-gray-500">{{ $member->email }}</td>
                            <td class="px-6 py-4 text-center">
                                <select name="attendance[{{ $member->id }}]"
                                        class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 transition">
                                    <option value="absent" {{ ($attendances[$member->id] ?? '') == 'absent' ? 'selected' : '' }}>❌ Absent</option>
                                    <option value="present" {{ ($attendances[$member->id] ?? '') == 'present' ? 'selected' : '' }}>✅ Present</option>
                                    <option value="late" {{ ($attendances[$member->id] ?? '') == 'late' ? 'selected' : '' }}>⏰ Late</option>
                                </select>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Fixed Save Bar --}}
        <div class="sticky bottom-0 bg-white border-t border-gray-200 px-6 py-4 flex items-center justify-end">
            <button type="submit"
                class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-red-600 to-orange-500 text-white rounded-xl font-semibold shadow-md hover:shadow-lg hover:scale-105 transition">
                <i data-feather="save" class="w-5"></i> Save Attendance
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        if (window.feather) feather.replace();
    });
</script>
@endsection
