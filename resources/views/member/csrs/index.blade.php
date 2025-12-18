@extends('layouts.app')

@section('content')
<div class="max-w-8xl mx-auto px-4 py-6 space-y-6">

    {{-- HEADER --}}
    <div class="bg-gradient-to-r from-red-700 via-red-600 to-red-500
                text-white rounded-2xl px-8 py-6 flex justify-between items-center shadow-lg">
        <div>
            <h2 class="text-3xl font-semibold">Branding & Media Activities</h2>
            <p class="text-sm text-white/80 mt-1">
                Articles, Stories, Videos, Podcasts, PR & Media activities recorded by you.
            </p>
        </div>

        <a href="{{ route('member.brandings.create') }}"
           class="bg-white text-red-600 px-4 py-2 rounded-lg font-medium shadow hover:bg-gray-100 transition">
            <i data-feather="plus" class="inline w-4 h-4 mr-1"></i>
            Add Branding
        </a>
    </div>

    {{-- SUCCESS --}}
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex justify-between items-center">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()">✕</button>
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
                   placeholder="Search title, publication or media…"
                   class="pl-10 border border-gray-300 rounded-lg px-3 py-2 text-sm
                          focus:ring-1 focus:ring-red-600 focus:border-red-600">
            <i data-feather="search"
               class="absolute left-3 top-2.5 w-4 h-4 text-gray-400"></i>
        </div>

        {{-- BRANDING TYPE --}}
        <select name="branding_type"
                class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-red-600">
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
                class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-red-600">
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

        <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm">
            Filter
        </button>
    </form>

    {{-- TABLE --}}
    <div class="bg-white border border-gray-200 shadow rounded-2xl overflow-hidden">

        @if($brandings->count())
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-600 border-b">
                <tr>
                    <th class="px-4 py-3 text-left">Branding</th>
                    <th class="px-4 py-3 text-left">Type</th>
                    <th class="px-4 py-3 text-left">Date</th>
                    <th class="px-4 py-3 text-left">Impact</th>
                    <th class="px-4 py-3 text-center">Status</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">
                @foreach($brandings as $branding)
                <tr>

                    {{-- BRANDING --}}
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3">
                            <img src="{{ $branding->thumbnail_url }}"
                                 class="w-10 h-10 rounded border object-cover"
                                 alt="">
                            <div>
                                <div class="font-medium">{{ $branding->title }}</div>
                                <div class="text-xs text-gray-500">
                                    {{ $branding->publication_name ?? $branding->media_platform ?? '—' }}
                                </div>
                            </div>
                        </div>
                    </td>

                    {{-- TYPE --}}
                    <td class="px-4 py-3 capitalize">
                        {{ str_replace('_',' ',$branding->branding_type) }}
                    </td>

                    {{-- DATE --}}
                    <td class="px-4 py-3">
                        {{ $branding->formatted_date }}
                    </td>

                    {{-- IMPACT --}}
                    <td class="px-4 py-3 text-gray-600">
                        {{ $branding->impact_summary }}
                    </td>

                    {{-- STATUS --}}
                    <td class="px-4 py-3 text-center">
                        <span class="px-2 py-1 rounded-full text-xs {{ $branding->status_color }}">
                            {{ ucfirst(str_replace('_',' ',$branding->status)) }}
                        </span>
                    </td>

                    {{-- ACTIONS --}}
                    <td class="px-4 py-3 text-right space-x-3">
                        <a href="{{ route('member.brandings.show', $branding) }}"
                           class="text-blue-600 hover:underline">View</a>

                        <a href="{{ route('member.brandings.edit', $branding) }}"
                           class="text-green-600 hover:underline">Edit</a>

                        <form action="{{ route('member.brandings.destroy', $branding) }}"
                              method="POST" class="inline">
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

        <div class="p-4 border-t bg-gray-50">
            {{ $brandings->links() }}
        </div>

        @else
            <div class="p-10 text-center text-gray-500">
                No branding records found.
            </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    if (window.feather) feather.replace();
});
</script>
@endsection
