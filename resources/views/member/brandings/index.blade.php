@extends('layouts.app')

@section('content')
<div class="max-w-8xl mx-auto px-4 py-4 space-y-6">

    {{-- HEADER --}}
    <div class="bg-gradient-to-r from-red-700 via-red-600 to-red-500 text-white rounded-2xl px-8 py-6 flex justify-between items-center shadow-lg">
        <div>
            <h2 class="text-3xl font-semibold">Branding & Media Activities</h2>
            <p class="text-sm text-white/80 mt-1">
                Track your Articles, Stories, Video Shoots, Podcasts, PR and Media Releases for TMN.
            </p>
        </div>
        <a href="{{ route('member.brandings.create') }}"
           class="bg-white text-red-600 px-4 py-2 rounded-lg font-medium shadow hover:bg-gray-100 transition">
            <i data-feather="plus" class="inline w-4 h-4 mr-1"></i>
            Add Branding
        </a>
    </div>

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex justify-between items-center">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="font-semibold">✕</button>
        </div>
    @endif

    {{-- FILTERS --}}
    <form method="GET"
          class="bg-white border border-gray-200 shadow rounded-xl p-4 flex flex-wrap gap-4 items-end">

        {{-- SEARCH --}}
        <div class="relative">
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Search title, branding type or publication..."
                   class="pl-10 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-1 focus:ring-red-600 focus:border-red-600">
            <i data-feather="search"
               class="absolute left-3 top-2.5 w-4 h-4 text-gray-400"></i>
        </div>

        {{-- BRANDING TYPE --}}
        <select name="branding_type"
                class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-1 focus:ring-red-600">
            <option value="">All Branding Types</option>
            @foreach([
                'article' => 'Article',
                'story' => 'Story',
                'video_shoot' => 'Video Shoot',
                'podcast' => 'Podcast',
                'pr_activity' => 'PR Activity',
                'media_release' => 'Media Release',
                'magazine_feature' => 'Magazine Feature',
                'award_mention' => 'Award Mention',
                'social_campaign' => 'Social Campaign',
                'other' => 'Other'
            ] as $key => $label)
                <option value="{{ $key }}" {{ request('branding_type') === $key ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>

        {{-- STATUS --}}
        <select name="status"
                class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-1 focus:ring-red-600">
            <option value="">All Status</option>
            @foreach([
                'draft' => 'Draft',
                'submitted' => 'Submitted',
                'under_review' => 'Under Review',
                'approved' => 'Approved',
                'rejected' => 'Rejected'
            ] as $key => $label)
                <option value="{{ $key }}" {{ request('status') === $key ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>

        {{-- FILTER BUTTON --}}
        <button type="submit"
                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
            Filter
        </button>
    </form>

    {{-- TABLE --}}
    <div class="bg-white border border-gray-200 shadow rounded-2xl overflow-hidden">

        @if($brandings->count())
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-600 border-b">
                <tr>
                    <th class="px-4 py-3 text-left">Title</th>
                    <th class="px-4 py-3 text-left">Branding Type</th>
                    <th class="px-4 py-3 text-left">Impact</th>
                    <th class="px-4 py-3 text-center">Status</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">
                @foreach($brandings as $branding)
                <tr>

                    {{-- TITLE --}}
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3">
                            @if($branding->thumbnail_url)
                                <img src="{{ $branding->thumbnail_url }}"
                                     class="w-10 h-10 rounded object-cover border"
                                     alt="">
                            @endif
                            <div>
                                <div class="font-medium">{{ $branding->title }}</div>
                                <div class="text-xs text-gray-500">{{ $branding->headline }}</div>
                            </div>
                        </div>
                    </td>

                    {{-- BRANDING TYPE --}}
                    <td class="px-4 py-3 capitalize">
                        {{ str_replace('_', ' ', $branding->branding_type) }}
                    </td>

                    {{-- IMPACT --}}
                    <td class="px-4 py-3 text-gray-600">
                        Reach: {{ $branding->reach_count ?? '—' }}<br>
                        Engagement: {{ $branding->engagement_count ?? '—' }}
                    </td>

                    {{-- STATUS --}}
                    <td class="px-4 py-3 text-center">
                        <span class="px-2 py-1 rounded-full text-xs {{ $branding->status_color }}">
                            {{ ucfirst(str_replace('_',' ', $branding->status)) }}
                        </span>
                    </td>

                    {{-- ACTIONS --}}
                    <td class="px-4 py-3 text-right space-x-3">
                        <a href="{{ route('member.brandings.show', $branding) }}"
                           class="text-blue-600 hover:underline">View</a>

                        <a href="{{ route('member.brandings.edit', $branding) }}"
                           class="text-green-600 hover:underline">Edit</a>

                        <form action="{{ route('member.brandings.destroy', $branding) }}"
                              method="POST"
                              class="inline">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Delete this branding record?')"
                                    class="text-red-600 hover:underline">
                                Delete
                            </button>
                        </form>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- PAGINATION --}}
        <div class="p-4 border-t bg-gray-50">
            {{ $brandings->links() }}
        </div>

        @else
            <div class="p-10 text-center text-gray-500">
                No branding activities found.
            </div>
        @endif
    </div>
</div>

{{-- ICONS --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    if (window.feather) feather.replace();
});
</script>
@endsection
