@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto mt-10 bg-white shadow-xl rounded-2xl p-8">
    <!-- HEADER -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
        <div>
            <h2 class="text-3xl font-semibold text-gray-800 flex items-center gap-2">
                <i data-feather="map" class="w-7 h-7 text-[#CF2031]"></i>
                Chapters Overview
            </h2>
            <p class="text-gray-500 text-sm mt-1">
                Manage chapters, view details, and monitor membership capacity.
            </p>
        </div>

        <a href="{{ route('admin.chapters.create') }}"
           class="bg-gradient-to-r from-[#CF2031] to-[#b81b2a] hover:from-[#b81b2a] hover:to-[#991826]
                  text-white px-5 py-2 rounded-lg shadow flex items-center gap-2 transition">
            <i data-feather="plus-circle" class="w-4 h-4"></i> Create Chapter
        </a>
    </div>

    <!-- SUCCESS MESSAGE -->
    @if(session('success'))
        <div class="flex items-center gap-2 mb-6 p-4 bg-green-100 border border-green-300 text-green-800 rounded-lg">
            <i data-feather="check-circle" class="w-5 h-5"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- TABLE -->
    <div class="overflow-hidden border border-gray-200 rounded-xl">
        <table class="min-w-full text-sm border">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-semibold border-b">
                <tr>
                    <th class="py-3 px-4 border text-left">Logo</th>
                    <th class="py-3 px-4 border text-left">Chapter Name</th>
                    <th class="py-3 px-4 border text-left">City</th>
                    <th class="py-3 px-4 border text-left">Members</th>
                    <th class="py-3 px-4 border text-left">Status</th>
                    <th class="py-3 px-4 border text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($chapters as $chapter)
                    @php
                        $current = $chapter->members_count ?? $chapter->members()->count();
                        $limit = $chapter->capacity_no ?? 0;
                        $isFull = $limit > 0 && $current >= $limit;
                    @endphp
                    <tr class="hover:bg-gray-50 transition">
                        <!-- Logo -->
                        <td class="py-3 px-4 border">
                            <div class="flex items-center">
                                @if($chapter->logo)
                                    <img src="{{ asset('storage/' . $chapter->logo) }}" 
                                         class="h-10 w-10 object-cover rounded-full border border-gray-200 shadow-sm">
                                @else
                                    <div class="h-10 w-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-400">
                                        <i data-feather="image" class="w-5 h-5"></i>
                                    </div>
                                @endif
                            </div>
                        </td>

                        <!-- Name -->
                        <td class="py-3 px-4 border font-medium text-gray-800">
                            {{ $chapter->name }}
                            <div class="text-xs text-gray-500 mt-1">#{{ $chapter->chapter_code }}</div>
                        </td>

                        <!-- City -->
                        <td class="py-3 px-4 border text-gray-700">{{ $chapter->city ?? '—' }}</td>

                        <!-- Members -->
                        <td class="py-3 px-4 border">
                            <div class="flex items-center gap-2">
                                <span class="font-semibold {{ $isFull ? 'text-red-600' : 'text-green-700' }}">
                                    {{ $current }} / {{ $limit ?: '∞' }}
                                </span>
                                @if($limit)
                                    <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden max-w-[120px]">
                                        <div class="h-2 rounded-full transition-all duration-500
                                            {{ $isFull ? 'bg-red-500' : 'bg-[#CF2031]' }}"
                                            style="width: {{ min(100, ($current / max(1, $limit)) * 100) }}%">
                                        </div>
                                    </div>
                                @endif
                            </div>
                            @if($isFull)
                                <p class="text-xs text-red-500 mt-1">(Full capacity reached)</p>
                            @endif
                        </td>

                        <!-- Status -->
                        <td class="py-3 px-4 border">
                            @if($chapter->is_active)
                                <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-full text-xs bg-green-100 text-green-700 font-medium">
                                    <i data-feather="check-circle" class="w-3 h-3"></i> Active
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-full text-xs bg-gray-100 text-gray-600 font-medium">
                                    <i data-feather="x-circle" class="w-3 h-3"></i> Inactive
                                </span>
                            @endif
                        </td>

                        <!-- Actions -->
                        <td class="py-3 px-4 border text-right flex flex-wrap justify-end gap-2">
                            <a href="{{ route('admin.chapters.show', $chapter->id) }}" 
                               class="inline-flex items-center gap-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium px-3 py-1.5 rounded transition">
                               <i data-feather="eye" class="w-4 h-4"></i> View Details
                            </a>

                            <a href="{{ route('admin.chapters.members', $chapter->id) }}" 
                               class="inline-flex items-center gap-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-sm font-medium px-3 py-1.5 rounded transition">
                               <i data-feather="users" class="w-4 h-4"></i> Members
                            </a>

                            <a href="{{ route('admin.chapters.edit', $chapter->id) }}" 
                               class="inline-flex items-center gap-1.5 bg-blue-50 hover:bg-blue-100 text-blue-700 text-sm font-medium px-3 py-1.5 rounded transition">
                               <i data-feather="edit-2" class="w-4 h-4"></i> Edit
                            </a>

                            <form action="{{ route('admin.chapters.destroy', $chapter->id) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Delete this chapter?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="inline-flex items-center gap-1.5 bg-red-50 hover:bg-red-100 text-red-700 text-sm font-medium px-3 py-1.5 rounded transition">
                                    <i data-feather="trash-2" class="w-4 h-4"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-10 text-center text-gray-500">
                            <i data-feather="info" class="w-6 h-6 mx-auto mb-2 text-gray-400"></i>
                            No chapters found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- PAGINATION -->
    <div class="mt-6">
        {{ $chapters->links() }}
    </div>
</div>

<script>
    feather.replace();
</script>
@endsection
