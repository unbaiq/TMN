@extends('layouts.app')

@section('content')
<div class="max-w-[1600px] mx-auto px-6 py-8 space-y-10">

  {{-- HEADER --}}
  <div class="flex flex-col md:flex-row md:items-center md:justify-between bg-white border border-gray-200 rounded-2xl shadow-sm px-8 py-6">
      <div>
          <h1 class="text-2xl font-bold text-gray-800 tracking-tight">TMN Admin Dashboard</h1>
          <p class="text-gray-500 text-xs mt-1">Comprehensive insight into chapters, members, referrals, and performance</p>
      </div>
      <div class="mt-4 md:mt-0">
          <span class="inline-flex items-center bg-[#FDE7E9] border border-[#F9D2D5] text-[#CF2031] px-4 py-1.5 rounded-lg font-medium text-xs shadow-inner">
              <i data-feather="calendar" class="w-3.5 h-3.5 mr-2"></i> {{ now()->format('F Y') }}
          </span>
      </div>
  </div>

  {{-- KPI STATISTICS --}}
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-5">
      @foreach([
          ['label'=>'Members','value'=>$stats['total_members'],'icon'=>'users'],
          ['label'=>'Chapters','value'=>$stats['active_chapters'],'icon'=>'map-pin'],
          ['label'=>'Referrals','value'=>$stats['total_referrals'],'icon'=>'share-2'],
          ['label'=>'Business Value','value'=>$stats['business_value'],'icon'=>'briefcase'],
          ['label'=>'Events','value'=>$stats['events_this_month'],'icon'=>'calendar'],
          ['label'=>'Pending Approvals','value'=>$stats['pending_approvals'],'icon'=>'check-circle']
      ] as $item)
      <div class="bg-white border border-gray-100 rounded-xl shadow-sm hover:shadow-md transition-all duration-200 p-4">
          <div class="flex items-center justify-between">
              <div>
                  <h2 class="text-xl font-semibold text-[#CF2031]">{{ $item['value'] }}</h2>
                  <p class="text-[13px] text-gray-500 font-medium">{{ $item['label'] }}</p>
              </div>
              <div class="bg-[#FDE7E9] text-[#CF2031] p-2.5 rounded-lg">
                  <i data-feather="{{ $item['icon'] }}" class="w-4 h-4"></i>
              </div>
          </div>
      </div>
      @endforeach
  </div>

  {{-- TOP CHAPTERS --}}
  <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
      <div class="flex items-center justify-between px-6 py-3 border-b bg-[#FDE7E9]/40">
          <h2 class="text-sm font-semibold text-[#CF2031] flex items-center gap-2">
              <i data-feather="award" class="w-4 h-4"></i>
              Top Performing Chapters
          </h2>
          <a href="#" class="text-xs text-[#CF2031] hover:underline font-medium">View All</a>
      </div>

      <div class="overflow-x-auto">
          <table class="w-full text-xs">
              <thead class="bg-gray-50 text-gray-600 uppercase tracking-wide text-[11px] font-semibold border-b">
                  <tr>
                      <th class="py-2 px-4 text-left">Chapter</th>
                      <th class="py-2 px-4 text-left">Members</th>
                      <th class="py-2 px-4 text-left">Business Value</th>
                      <th class="py-2 px-4 text-left">Growth</th>
                  </tr>
              </thead>
              <tbody class="divide-y divide-gray-100">
                  @forelse($topChapters as $chapter)
                  <tr class="hover:bg-[#FDE7E9]/40 transition">
                      <td class="py-2 px-4 font-medium text-gray-700">{{ $chapter['name'] }}</td>
                      <td class="py-2 px-4 text-gray-600">{{ $chapter['members'] }}</td>
                      <td class="py-2 px-4 text-green-600 font-semibold">{{ $chapter['business_value'] }}</td>
                      <td class="py-2 px-4">
                          <span class="bg-green-50 text-green-700 text-[11px] px-3 py-0.5 rounded-full font-medium">{{ $chapter['growth'] }}</span>
                      </td>
                  </tr>
                  @empty
                  <tr><td colspan="4" class="py-4 text-center text-gray-400">No data available</td></tr>
                  @endforelse
              </tbody>
          </table>
      </div>
  </div>

  {{-- DATA GRID --}}
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

      {{-- RECENT MEMBERS --}}
      <div class="bg-white border border-gray-200 rounded-xl shadow-sm">
          <div class="px-6 py-3 border-b flex items-center justify-between bg-[#FDE7E9]/40">
              <h3 class="text-sm font-semibold text-[#CF2031] flex items-center gap-2">
                  <i data-feather="user-check" class="w-4 h-4"></i> Recent Members
              </h3>
          </div>
          <ul class="divide-y divide-gray-100">
              @forelse($recentMembers as $member)
              <li class="px-6 py-3 flex justify-between items-center hover:bg-[#FDE7E9]/30 transition">
                  <div>
                      <p class="font-medium text-gray-800 text-[13px]">{{ $member['name'] }}</p>
                      <p class="text-[12px] text-gray-500">{{ $member['profession'] }} — {{ $member['chapter'] }}</p>
                  </div>
                  <span class="text-[11px] text-gray-400">{{ $member['joined'] }}</span>
              </li>
              @empty
              <li class="px-6 py-3 text-[12px] text-gray-500">No recent members found.</li>
              @endforelse
          </ul>
      </div>

      {{-- UPCOMING EVENTS --}}
      <div class="bg-white border border-gray-200 rounded-xl shadow-sm">
          <div class="px-6 py-3 border-b flex items-center justify-between bg-[#FDE7E9]/40">
              <h3 class="text-sm font-semibold text-[#CF2031] flex items-center gap-2">
                  <i data-feather="calendar" class="w-4 h-4"></i> Upcoming Events
              </h3>
          </div>
          <ul class="divide-y divide-gray-100">
              @forelse($upcomingEvents as $event)
              <li class="px-6 py-3 flex justify-between items-center hover:bg-[#FDE7E9]/30 transition">
                  <div>
                      <p class="font-medium text-gray-800 text-[13px]">{{ $event['title'] }}</p>
                      <p class="text-[12px] text-gray-500">{{ $event['location'] }}</p>
                  </div>
                  <span class="text-[11px] bg-[#FDE7E9] text-[#CF2031] px-3 py-0.5 rounded-full font-medium">{{ $event['date'] }}</span>
              </li>
              @empty
              <li class="px-6 py-3 text-[12px] text-gray-500">No upcoming events.</li>
              @endforelse
          </ul>
      </div>

      {{-- RECENT ACTIVITY --}}
      <div class="bg-white border border-gray-200 rounded-xl shadow-sm">
          <div class="px-6 py-3 border-b flex items-center justify-between bg-[#FDE7E9]/40">
              <h3 class="text-sm font-semibold text-[#CF2031] flex items-center gap-2">
                  <i data-feather="activity" class="w-4 h-4"></i> Recent Activity
              </h3>
          </div>
          <ul class="divide-y divide-gray-100">
              @foreach($recentActivities as $activity)
              <li class="px-6 py-3 flex items-center gap-3 hover:bg-[#FDE7E9]/30 transition">
                  <div class="bg-[#FDE7E9] p-2 rounded-full">
                      <i data-feather="{{ $activity['icon'] }}" class="w-4 h-4 text-[#CF2031]"></i>
                  </div>
                  <div class="flex-1">
                      <p class="text-[13px] font-medium text-gray-800">{{ $activity['message'] }}</p>
                      <p class="text-[11px] text-gray-400">{{ $activity['time'] }}</p>
                  </div>
              </li>
              @endforeach
          </ul>
      </div>
  </div>

  {{-- ANALYTICS --}}
  <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-8 text-center">
      <h3 class="text-base font-semibold text-[#CF2031] mb-2">Analytics Dashboard</h3>
      <p class="text-gray-500 text-[13px]">Interactive reports and visual data coming soon.</p>
      <div class="mt-6">
          <div class="h-48 bg-gray-50 border border-dashed border-gray-300 rounded-xl flex items-center justify-center text-gray-400 text-[13px]">
              Placeholder for Chart.js / Livewire integration
          </div>
      </div>
  </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    if (window.feather) feather.replace();
});
</script>
@endsection
