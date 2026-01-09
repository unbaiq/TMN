@extends('layouts.app')

@section('content')
<div class="max-w-[95rem] mx-auto px-6 py-8 space-y-10">

    {{-- ================= HEADER ================= --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-red-800 via-red-700 to-red-600 shadow-xl">
        <div class="relative z-10 px-10 py-8 flex flex-col lg:flex-row lg:items-center lg:justify-between text-white">
            <div>
                <h1 class="text-3xl lg:text-4xl font-semibold tracking-tight">
                    Member Dashboard
                </h1>
                <p class="mt-2 text-sm text-red-100">
                    Welcome back,
                    <span class="font-semibold">{{ $member->name }}</span>
                    @if($member->chapter)
                        • {{ $member->chapter->name }}
                        @if($member->chapter->city)
                            ({{ $member->chapter->city }})
                        @endif
                    @endif
                </p>
            </div>

         @php
    $startDate = $member->created_at;
    $endDate = $member->created_at->copy()->addYear();
@endphp

<div class="mt-4 lg:mt-0 text-sm text-center">
    <p class="uppercase tracking-wide text-red-100 text-xs">
        Membership Period
    </p>
    <p class="font-semibold text-white text-base">
        {{ $startDate->format('d M Y') }} – {{ $endDate->format('d M Y') }}
    </p>
</div>

        </div>
        <div class="absolute -right-16 -bottom-16 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>
    </div>

    {{-- ================= KPI CARDS ================= --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <p class="text-xs uppercase tracking-wide text-gray-500 font-semibold">Actual Business</p>
            <p class="mt-3 text-3xl font-bold text-gray-900">₹ {{ number_format($actualBusiness, 2) }}</p>
            <p class="mt-1 text-xs text-gray-400">Closed referrals</p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <p class="text-xs uppercase tracking-wide text-gray-500 font-semibold">Expected Business</p>
            <p class="mt-3 text-3xl font-bold text-gray-900">₹ {{ number_format($expectedBusiness, 2) }}</p>
            <p class="mt-1 text-xs text-gray-400">Pipeline</p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <p class="text-xs uppercase tracking-wide text-gray-500 font-semibold">Business Given</p>
            <p class="mt-3 text-3xl font-bold text-gray-900">₹ {{ number_format($totalBusinessGiven, 2) }}</p>
            <p class="mt-1 text-xs text-gray-400">You gave</p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <p class="text-xs uppercase tracking-wide text-gray-500 font-semibold">Business Received</p>
            <p class="mt-3 text-3xl font-bold text-gray-900">₹ {{ number_format($totalBusinessTaken, 2) }}</p>
            <p class="mt-1 text-xs text-gray-400">You received</p>
        </div>
    </div>

    {{-- ================= ACTIVITY SUMMARY ================= --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <p class="text-xs uppercase text-gray-500 font-semibold">Referrals Given</p>
            <p class="mt-3 text-3xl font-bold text-gray-900">{{ $totalReferralsGiven }}</p>
            <p class="mt-1 text-xs text-gray-400">Total referrals</p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <p class="text-xs uppercase text-gray-500 font-semibold">1-to-1 Meetings</p>
            <p class="mt-3 text-3xl font-bold text-gray-900">{{ $oneToOneCount }}</p>
            <p class="mt-1 text-xs text-gray-400">Meetings</p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <p class="text-xs uppercase text-gray-500 font-semibold">Cluster Meetings</p>
            <p class="mt-3 text-3xl font-bold text-gray-900">{{ $clusterMeetingCount ?? 0 }}</p>
            <p class="mt-1 text-xs text-gray-400">Meetings</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
    <p class="text-xs uppercase text-gray-500 font-semibold">Total Connects</p>
    <p class="mt-3 text-3xl font-bold text-gray-900">
        {{ $totalConnects }}
    </p>
    <p class="mt-1 text-xs text-gray-400">Business Connects</p>
</div>

    </div>

    {{-- ================= METRICS ================= --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Visitors --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h3 class="text-xs uppercase tracking-wide text-gray-500 font-semibold">Visitors & Events</h3>
            <div class="grid grid-cols-2 gap-4 mt-4">
                <div>
                    <p class="text-xs uppercase text-gray-500">Visitors Invited</p>
                    <p class="text-lg font-bold">{{ $visitorsInvited }}</p>
                </div>
                <div>
                    <p class="text-xs uppercase text-gray-500">Visitors Converted</p>
                    <p class="text-lg font-bold">{{ $visitorsConverted }}</p>
                </div>
                <div>
                    <p class="text-xs uppercase text-gray-500">Events Attended</p>
                    <p class="text-lg font-bold">{{ $eventsAttended }}</p>
                </div>
                <div>
                    <p class="text-xs uppercase text-gray-500">Meetings Attended</p>
                    <p class="text-lg font-bold">{{ $meetingsAttended }}</p>
                </div>
            </div>
        </div>

        {{-- CSR --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h3 class="text-xs uppercase tracking-wide text-gray-500 font-semibold">CSR Impact</h3>
            <div class="grid grid-cols-3 gap-4 mt-4">
                <div>
                    <p class="text-xs uppercase text-gray-500">Amount</p>
                    <p class="text-lg font-bold">₹ {{ number_format($csrImpact->total_amount ?? 0,2) }}</p>
                </div>
                <div>
                    <p class="text-xs uppercase text-gray-500">Beneficiaries</p>
                    <p class="text-lg font-bold">{{ $csrImpact->total_beneficiaries ?? 0 }}</p>
                </div>
                <div>
                    <p class="text-xs uppercase text-gray-500">Hours</p>
                    <p class="text-lg font-bold">{{ $csrImpact->total_hours ?? 0 }}</p>
                </div>
            </div>
            <p class="mt-4 text-xs text-gray-500">
                Investors Linked:
                <span class="font-semibold text-gray-800">{{ $investorCount }}</span>
            </p>
        </div>

        {{-- Recognition --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h3 class="text-xs uppercase tracking-wide text-gray-500 font-semibold">Recognition</h3>
            <div class="grid grid-cols-3 gap-4 mt-4">
                <div>
                    <p class="text-xs uppercase text-gray-500">Awards</p>
                    <p class="text-lg font-bold">{{ $recognitionStats->total_recognitions ?? 0 }}</p>
                </div>
                <div>
                    <p class="text-xs uppercase text-gray-500">Value</p>
                    <p class="text-lg font-bold">₹ {{ number_format($recognitionStats->total_recognition_value ?? 0,2) }}</p>
                </div>
                <div>
                    <p class="text-xs uppercase text-gray-500">Points</p>
                    <p class="text-lg font-bold">{{ $recognitionStats->total_points ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- ================= CHARTS ================= --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 lg:col-span-2">
            <h3 class="text-xs uppercase tracking-wide text-gray-500 font-semibold mb-4">Business Trend</h3>
            <div class="h-72">
                <canvas id="businessLineChart"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h3 class="text-xs uppercase tracking-wide text-gray-500 font-semibold mb-4">Activity Mix</h3>
            <div class="h-72">
                <canvas id="activityDonutChart"></canvas>
            </div>
            <p class="mt-3 text-xs text-gray-500">
                Distribution of referrals, meetings & visitors
            </p>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {

    const chartLabels = @json($chartLabels);
    const chartActual = @json($chartActual);
    const chartExpected = @json($chartExpected);

    const activityData = @json($activityDistribution);
    const activityLabels = Object.keys(activityData);
    const activityValues = Object.values(activityData);

    new Chart(document.getElementById('businessLineChart'), {
        type: 'line',
        data: {
            labels: chartLabels,
            datasets: [
                {
                    label: 'Actual Business',
                    data: chartActual,
                    borderColor: '#dc2626',
                    backgroundColor: 'rgba(220,38,38,0.15)',
                    borderWidth: 3,
                    tension: 0.35
                },
                {
                    label: 'Expected Business',
                    data: chartExpected,
                    borderColor: '#f87171',
                    backgroundColor: 'rgba(248,113,113,0.15)',
                    borderDash: [6,6],
                    borderWidth: 2,
                    tension: 0.35
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    new Chart(document.getElementById('activityDonutChart'), {
        type: 'doughnut',
        data: {
            labels: activityLabels,
            datasets: [{
                data: activityValues,
                backgroundColor: ['#ef4444','#f97316','#10b981','#3b82f6','#8b5cf6','#14b8a6']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%'
        }
    });
});
</script>
@endpush
