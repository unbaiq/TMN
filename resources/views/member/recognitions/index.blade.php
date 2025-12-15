@extends('layouts.app')

@section('content')
<div class="max-w-8xl mx-auto px-4 py-4 space-y-6">

    {{-- ==== HEADER ==== --}}
    <div class="bg-gradient-to-r from-red-700 via-red-600 to-red-500 text-white rounded-2xl px-8 py-6 flex justify-between items-center shadow-lg">
        <div>
            <h2 class="text-3xl font-semibold">Recognitions</h2>
            <p class="text-sm text-white/80 mt-1">Appreciate members for contributions and track recognitions.</p>
        </div>
        <a href="{{ route('member.recognitions.create') }}" class="bg-white text-red-600 px-4 py-2 rounded-lg font-medium shadow hover:bg-gray-100 transition">
            <i data-feather="plus" class="inline w-4 h-4 mr-1"></i> Add Recognition
        </a>
    </div>

    {{-- ==== FILTER BAR ==== --}}
    <form method="GET" class="bg-white border border-gray-200 shadow rounded-xl p-4 flex flex-wrap gap-4 items-end">
        <div class="flex-1 min-w-[180px]">
            <label class="text-xs text-gray-600">Search</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Member or title..."
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-1 focus:ring-red-600 focus:border-red-600">
        </div>
        <div>
            <label class="text-xs text-gray-600">Category</label>
            <select name="category" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-1 focus:ring-red-600 focus:border-red-600">
                <option value="">All</option>
                @foreach (['referral'=>'Referral','thank_you'=>'Thank You','visitor'=>'Visitor','leadership'=>'Leadership','training'=>'Training','testimony'=>'Testimony','support'=>'Support','milestone'=>'Milestone','other'=>'Other'] as $key=>$label)
                    <option value="{{ $key }}" {{ request('category')==$key?'selected':'' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="text-xs text-gray-600">Status</label>
            <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-1 focus:ring-red-600 focus:border-red-600">
                <option value="">Any</option>
                <option value="approved" {{ request('status')=='approved'?'selected':'' }}>Approved</option>
                <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending</option>
                <option value="rejected" {{ request('status')=='rejected'?'selected':'' }}>Rejected</option>
            </select>
        </div>
        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium">Apply</button>
    </form>

    {{-- ==== TABLE ==== --}}
    <div class="bg-white rounded-2xl shadow border border-gray-200 overflow-hidden">
        @if($recognitions->count())
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-600 border-b">
                <tr>
                    <th class="px-4 py-3 text-left">Member</th>
                    <th class="px-4 py-3 text-left">Title</th>
                    <th class="px-4 py-3 text-left">Category</th>
                    <th class="px-4 py-3 text-center">Points</th>
                    <th class="px-4 py-3 text-center">Status</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($recognitions as $rec)
                <tr>
                    <td class="px-4 py-3 font-medium text-gray-800">{{ $rec->member->name }}</td>
                    <td class="px-4 py-3 text-gray-700">{{ $rec->title }}</td>
                    <td class="px-4 py-3 capitalize text-gray-600">{{ str_replace('_',' ',$rec->category) }}</td>
                    <td class="px-4 py-3 text-center">{{ $rec->points ?? '—' }}</td>
                    <td class="px-4 py-3 text-center">
                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $rec->status_badge }}">
                            {{ ucfirst($rec->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-right space-x-3">
                        <a href="{{ route('member.recognitions.show',$rec) }}" class="text-blue-600 hover:underline">View</a>
                        <a href="{{ route('member.recognitions.edit',$rec) }}" class="text-green-600 hover:underline">Edit</a>
                        <form action="{{ route('member.recognitions.destroy',$rec) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Delete this recognition?')" class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-4 border-t bg-gray-50">{{ $recognitions->links() }}</div>
        @else
        <div class="p-10 text-center text-gray-500">No recognitions found.</div>
        @endif
    </div>
</div>
<script>document.addEventListener('DOMContentLoaded',()=>{if(window.feather)feather.replace();});</script>
@endsection
