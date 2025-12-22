@extends('layouts.app')
@section('title', 'Member Connects')

@section('content')
<div class="max-w-8xl mx-auto px-6 py-6 space-y-6">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">
                🌐 Member Connects
            </h2>
            <p class="text-sm text-gray-600">
                Manage your business connects and explore member connects
            </p>
        </div>

        <a href="{{ route('member.connects.create') }}"
           class="bg-red-700 hover:bg-red-800 text-white px-5 py-2.5 rounded-lg shadow text-sm font-medium">
            + Add Connect
        </a>
    </div>

    {{-- TABS --}}
    <div class="flex gap-6 border-b border-red-200">
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

    {{-- SEARCH + RESET --}}
    <form method="GET" class="bg-white rounded-xl shadow border border-red-100 p-4">
        <input type="hidden" name="type" value="{{ $type }}">

        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Search name, company, industry, profession"
                   class="border border-red-200 rounded-lg px-4 py-2 md:col-span-3
                          focus:ring focus:ring-red-200 focus:border-red-400">

            <button type="submit"
                    class="bg-gray-900 hover:bg-black text-white rounded-lg px-4 py-2 font-medium">
                Search
            </button>

            <a href="{{ route('member.connects.index', ['type' => $type]) }}"
               class="text-center border border-gray-300 text-gray-700 hover:bg-gray-100
                      rounded-lg px-4 py-2 font-medium">
                Reset
            </a>
        </div>
    </form>

    {{-- TABLE --}}
    <div class="bg-white rounded-xl shadow border border-red-100 overflow-x-auto">
        <table class="w-full text-sm text-center">
            <thead class="bg-red-50 text-gray-800 uppercase text-xs">
                <tr>
                    <th class="p-4">Name</th>
                    <th>Company</th>
                    <th>Designation</th>
                    <th>Industry</th>
                    <th>Connect By</th>
                    <th class="p-4">Action</th>
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
                        {{ $connect->member->name ?? '-' }}
                    </td>

                    {{-- ACTION --}}
                    <td class="p-4 space-x-3">
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
                            <span class="text-gray-400 italic text-xs">
                                View only
                            </span>
                        @endif
                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="6" class="p-6 text-gray-500">
                        No connects found
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{-- PAGINATION --}}
    <div class="pt-4">
        {{ $connects->links() }}
    </div>

</div>
@endsection
