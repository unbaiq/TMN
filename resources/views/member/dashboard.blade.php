@extends('layouts.app')

@section('content')
    <div class="max-w-8xl mx-auto px-4 py-6 space-y-8">

        {{-- HEADER --}}
        <div
            class="bg-gradient-to-r from-red-700 via-red-600 to-red-500 rounded-2xl shadow-2xl px-10 py-8 text-white flex flex-col md:flex-row md:items-center md:justify-between relative overflow-hidden">
            <div class="relative z-10">
                <h1 class="text-3xl md:text-4xl font-bold tracking-tight">Member Dashboard</h1>
                <p class="mt-2 text-sm md:text-base text-red-100">
                    Welcome, <span class="font-semibold">{{ $member->name }}</span>
                    @if($member->chapter)
                        • {{ $member->chapter->name }}
                        @if($member->chapter->city)
                            ({{ $member->chapter->city }})
                        @endif
                    @endif
                </p>
            </div>
            <div class="mt-4 md:mt-0 text-sm md:text-right relative z-10">
                <p class="font-medium text-red-50 uppercase tracking-wide">Financial Year</p>
                <p class="text-red-100 font-semibold">
                    {{ now()->startOfYear()->format('d M Y') }} – {{ now()->endOfYear()->format('d M Y') }}
                </p>
            </div>
            <div class="absolute right-0 bottom-0 opacity-25 blur-2xl w-44 h-44 bg-red-400 rounded-full"></div>
        </div>

        {{-- TOP SUMMARY CARDS --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">

            {{-- Actual Business --}}
            <div
                class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-lg hover:-translate-y-1 transition duration-300">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Actual Business (Closed)</p>
                <p class="mt-3 text-3xl font-extrabold text-gray-800">₹ {{ number_format($actualBusiness, 2) }}</p>
                <p class="mt-1 text-xs text-gray-400">From closed referrals this year</p>
            </div>

            {{-- Expected Business --}}
            <div
                class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-lg hover:-translate-y-1 transition duration-300">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Expected Business (Pipeline)</p>
                <p class="mt-3 text-3xl font-extrabold text-gray-800">₹ {{ number_format($expectedBusiness, 2) }}</p>
                <p class="mt-1 text-xs text-gray-400">Open / in-progress referrals</p>
            </div>

            {{-- Business Given --}}
            <div
                class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-lg hover:-translate-y-1 transition duration-300">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Business Given</p>
                <p class="mt-3 text-3xl font-extrabold text-gray-800">₹ {{ number_format($totalBusinessGiven, 2) }}</p>
                <p class="mt-1 text-xs text-gray-400">You gave to others</p>
            </div>

            {{-- Business Taken --}}
            <div
                class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-lg hover:-translate-y-1 transition duration-300">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Business Received</p>
                <p class="mt-3 text-3xl font-extrabold text-gray-800">₹ {{ number_format($totalBusinessTaken, 2) }}</p>
                <p class="mt-1 text-xs text-gray-400">You received from others</p>
            </div>
        </div>

        {{-- SECOND ROW SUMMARY --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">
            {{-- Referrals --}}
            <div
                class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-lg hover:-translate-y-1 transition">
                <p class="text-xs font-semibold text-gray-500 uppercase">Referrals Given</p>
                <p class="mt-3 text-3xl font-extrabold text-gray-800">{{ $totalReferralsGiven }}</p>
                <p class="mt-1 text-xs text-gray-400">Referrals you have passed</p>
            </div>
            <div
                class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-lg hover:-translate-y-1 transition">
                <p class="text-xs font-semibold text-gray-500 uppercase">Referrals Received</p>
                <p class="mt-3 text-3xl font-extrabold text-gray-800">{{ $totalReferralsReceived }}</p>
                <p class="mt-1 text-xs text-gray-400">Referrals you got</p>
            </div>

            {{-- Thank You & 1-1 --}}
            <div
                class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-lg hover:-translate-y-1 transition">
                <p class="text-xs font-semibold text-gray-500 uppercase">TYFCB (Thank You)</p>
                <p class="mt-3 text-3xl font-extrabold text-gray-800">₹ {{ number_format($totalThankYouAmount, 2) }}</p>
                <p class="mt-1 text-xs text-gray-400">Thank You slips given</p>
            </div>
            <div
                class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-lg hover:-translate-y-1 transition">
                <p class="text-xs font-semibold text-gray-500 uppercase">1-to-1 Meetings</p>
                <p class="mt-3 text-3xl font-extrabold text-gray-800">{{ $oneToOneCount }}</p>
                <p class="mt-1 text-xs text-gray-400">Relationship-building meetings</p>
            </div>
        </div>

        {{-- THIRD ROW --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Visitors --}}
            <div
                class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-lg hover:-translate-y-1 transition space-y-3">
                <p class="text-xs font-semibold text-gray-500 uppercase">Visitors & Events</p>
                <div class="grid grid-cols-2 gap-4 text-sm mt-2">
                    <div>
                        <p class="text-gray-500 text-xs uppercase">Visitors Invited</p>
                        <p class="text-xl font-bold text-gray-800">{{ $visitorsInvited }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs uppercase">Visitors Converted</p>
                        <p class="text-xl font-bold text-gray-800">{{ $visitorsConverted }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs uppercase">Events Attended</p>
                        <p class="text-xl font-bold text-gray-800">{{ $eventsAttended }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs uppercase">Meetings Attended</p>
                        <p class="text-xl font-bold text-gray-800">{{ $meetingsAttended }}</p>
                    </div>
                </div>
            </div>

            {{-- CSR Impact --}}
            <div
                class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-lg hover:-translate-y-1 transition space-y-3">
                <p class="text-xs font-semibold text-gray-500 uppercase">CSR Impact</p>
                <div class="grid grid-cols-3 gap-4 text-sm mt-2">
                    <div>
                        <p class="text-gray-500 text-xs uppercase">Amount Spent</p>
                        <p class="text-lg font-bold text-gray-800">₹ {{ number_format($csrImpact->total_amount ?? 0, 2) }}
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs uppercase">Beneficiaries</p>
                        <p class="text-lg font-bold text-gray-800">{{ $csrImpact->total_beneficiaries ?? 0 }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs uppercase">Volunteer Hours</p>
                        <p class="text-lg font-bold text-gray-800">{{ $csrImpact->total_hours ?? 0 }}</p>
                    </div>
                </div>
                <p class="mt-3 text-xs text-gray-400">Investors Linked: <span
                        class="font-semibold text-gray-700">{{ $investorCount }}</span></p>
            </div>

            {{-- Recognition --}}
            <div
                class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-lg hover:-translate-y-1 transition space-y-3">
                <p class="text-xs font-semibold text-gray-500 uppercase">Recognitions</p>
                <div class="grid grid-cols-3 gap-4 text-sm mt-2">
                    <div>
                        <p class="text-gray-500 text-xs uppercase">Total Awards</p>
                        <p class="text-lg font-bold text-gray-800">{{ $recognitionStats->total_recognitions ?? 0 }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs uppercase">Value</p>
                        <p class="text-lg font-bold text-gray-800">₹
                            {{ number_format($recognitionStats->total_recognition_value ?? 0, 2) }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs uppercase">Points</p>
                        <p class="text-lg font-bold text-gray-800">{{ $recognitionStats->total_points ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- GRAPHS --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Line Chart --}}
            <div
                class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 lg:col-span-2 hover:shadow-lg hover:-translate-y-1 transition">
                <p class="text-xs font-semibold text-gray-500 uppercase mb-3">Business Trend (Expected vs Actual)</p>
                <div class="h-72"><canvas id="businessLineChart"></canvas></div>
            </div>

            {{-- Donut Chart --}}
            <div
                class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-lg hover:-translate-y-1 transition">
                <p class="text-xs font-semibold text-gray-500 uppercase mb-3">Activity Mix</p>
                <div class="h-72"><canvas id="activityDonutChart"></canvas></div>
                <p class="mt-3 text-xs text-gray-500 leading-relaxed">Shows distribution of your activities: referrals, 1-1,
                    visitors, thank you etc.</p>
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

            const ctxLine = document.getElementById('businessLineChart');
            const ctxDonut = document.getElementById('activityDonutChart');
            if (!ctxLine || !ctxDonut) return;

            // ===== LINE CHART =====
            new Chart(ctxLine.getContext('2d'), {
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
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            tension: 0.35
                        },
                        {
                            label: 'Expected Business',
                            data: chartExpected,
                            borderColor: '#f87171',
                            backgroundColor: 'rgba(248,113,113,0.15)',
                            borderDash: [6, 6],
                            borderWidth: 2,
                            pointRadius: 3,
                            tension: 0.35
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: true, labels: { color: '#4b5563', boxWidth: 12 } }
                    },
                    scales: {
                        x: { ticks: { color: '#6b7280' }, grid: { color: '#f3f4f6' } },
                        y: {
                            ticks: {
                                color: '#6b7280',
                                callback: (value) => '₹ ' + value.toLocaleString()
                            },
                            grid: { color: '#f3f4f6' }
                        }
                    }
                }
            });

            // ===== DONUT CHART =====
            new Chart(ctxDonut.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: activityLabels,
                    datasets: [{
                        data: activityValues,
                        backgroundColor: ['#ef4444', '#f97316', '#10b981', '#3b82f6', '#8b5cf6', '#14b8a6'],
                        borderColor: '#fff',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { position: 'bottom', labels: { color: '#374151', usePointStyle: true } } },
                    cutout: '70%'
                }
            });
        });
    </script>
@endpush