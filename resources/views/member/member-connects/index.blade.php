@extends('layouts.app')
@section('title', 'Member Connects')

@section('content')
<div class="max-w-8xl mx-auto px-6 py-6 space-y-6">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                🌐 Member Connects
            </h2>
            <p class="text-sm text-gray-600">
                Manage your business connects and explore global member connects
            </p>
        </div>

        <a href="{{ route('member.connects.create') }}"
           class="bg-red-700 hover:bg-red-800 text-white px-5 py-2.5 rounded-lg shadow text-sm font-medium">
            + Add Connect
        </a>
    </div>

    {{-- TABS --}}
    <div class="flex gap-4 border-b border-red-200">
        <a href="{{ route('member.connects.index') }}"
           class="pb-2 text-sm font-semibold
           {{ $type === 'all' ? 'border-b-2 border-red-700 text-red-700' : 'text-gray-500 hover:text-red-600' }}">
            All Connects
        </a>

        <a href="{{ route('member.connects.index', ['type' => 'my']) }}"
           class="pb-2 text-sm font-semibold
           {{ $type === 'my' ? 'border-b-2 border-red-700 text-red-700' : 'text-gray-500 hover:text-red-600' }}">
            My Connects
        </a>
    </div>

    {{-- SEARCH --}}
    <form method="GET" class="bg-white rounded-xl shadow border border-red-100 p-4">
        <input type="hidden" name="type" value="{{ $type }}">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Search name, company, industry, profession"
                   class="border border-red-200 rounded-lg px-4 py-2 col-span-3
                          focus:ring focus:ring-red-200 focus:border-red-400">

            <button class="bg-gray-900 hover:bg-black text-white rounded-lg px-4 py-2 font-medium">
                Search
            </button>
        </div>
    </form>

    {{-- TABLE --}}
    <div class="bg-white rounded-xl shadow border border-red-100 overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-red-50 text-gray-800 uppercase text-xs">
                <tr>
                    <th class="p-4 text-left">Name</th>
                    <th>Company</th>
                    <th>Designation</th>
                    <th>Industry</th>
                    <th>Connect By</th>
                    <th class="text-right p-4">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($connects as $connect)
                <tr class="hover:bg-red-50/50 transition">
                    <td class="p-4 font-semibold text-gray-900">
                        {{ $connect->person_name }}
                    </td>

                    <td class="font-medium text-gray-800">
                        {{ $connect->company_name }}
                    </td>

                    <td class="text-gray-700">
                        {{ $connect->designation ?? '-' }}
                    </td>

                    <td class="text-gray-700">
                        {{ $connect->industry }}
                    </td>

                    <td class="text-red-700 font-medium">
                        {{ $connect->member->name }}
                    </td>

                    {{-- ACTIONS --}}
                    <td class="p-4 text-right space-x-3">

                        {{-- ✅ SHOW EDIT/DELETE ONLY IN "MY CONNECTS" --}}
                        @if($type === 'my' && $connect->user_id === auth()->id())

                            <a href="{{ route('member.connects.edit', $connect) }}"
                               class="text-red-700 hover:text-red-900 font-medium">
                                Edit
                            </a>

                            <form method="POST"
                                  action="{{ route('member.connects.destroy', $connect) }}"
                                  class="inline">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Delete this connect?')"
                                        class="text-gray-600 hover:text-red-700 font-medium">
                                    Delete
                                </button>
                            </form>

                        @else
                            <span class="text-gray-400 text-xs italic">
                                View only
                            </span>
                        @endif

                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center p-6 text-gray-500">
                        No connects found
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PAGINATION --}}
    <div class="pt-2">
        {{ $connects->links() }}
    </div>

</div>
@endsection
