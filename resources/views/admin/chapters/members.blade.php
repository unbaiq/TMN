@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto mt-10 bg-white shadow-xl rounded-2xl p-8">
    <!-- HEADER -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
        <div>
            <h2 class="text-3xl font-semibold text-gray-800 flex items-center gap-2">
                <i data-feather="users" class="w-7 h-7 text-[#CF2031]"></i>
                Assign Members
            </h2>
            <p class="text-gray-500 text-sm mt-1">
                Manage and assign members for <span class="font-semibold text-[#CF2031]">{{ $chapter->name }}</span>
            </p>
        </div>
        <div class="mt-4 md:mt-0 text-sm text-gray-600 bg-gray-50 border rounded-lg px-4 py-2">
            <span class="font-medium text-gray-800">Capacity:</span> {{ $chapter->capacity_no ?? '∞' }} &nbsp; | &nbsp;
            <span class="font-medium text-gray-800">Assigned:</span> 
            {{ $members->where('chapter_id', $chapter->id)->count() }}
        </div>
    </div>

    <!-- SUCCESS MESSAGE -->
    @if(session('success'))
        <div class="mb-6 flex items-center gap-2 p-4 bg-green-100 border border-green-300 rounded-lg text-green-800">
            <i data-feather="check-circle" class="w-5 h-5"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- FORM -->
    <form method="POST" action="{{ route('admin.chapters.assign', $chapter->id) }}">
        @csrf

        <!-- MEMBER SEARCH -->
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-gray-800">Available Members</h3>
            <input type="text" id="memberSearch" placeholder="Search member..."
                class="border border-gray-300 rounded-md px-3 py-2 text-sm w-64 focus:ring-2 focus:ring-[#CF2031] focus:outline-none">
        </div>

        <!-- MEMBER LIST -->
        <div id="memberList" class="grid sm:grid-cols-2 gap-3 max-h-[420px] overflow-y-auto border rounded-lg p-4 bg-gray-50">
            @foreach($members as $member)
                <label class="member-item flex items-center gap-3 bg-white p-3 rounded-lg shadow-sm hover:shadow-md transition cursor-pointer border border-transparent hover:border-[#CF2031]/20">
                    <input type="checkbox" name="member_ids[]" value="{{ $member->id }}"
                        @if($member->chapter_id === $chapter->id) checked @endif
                        class="h-4 w-4 text-[#CF2031] focus:ring-[#CF2031] rounded">
                    <div class="flex flex-col">
                        <span class="font-semibold text-gray-800">{{ $member->name }}</span>
                        <span class="text-xs text-gray-500">{{ $member->email }}</span>
                    </div>
                </label>
            @endforeach
        </div>

        @if($members->isEmpty())
            <div class="text-center text-gray-500 py-10 border rounded-lg bg-gray-50 mt-4">
                <i data-feather="user-x" class="w-10 h-10 mx-auto mb-2 text-gray-400"></i>
                <p>No available members to assign.</p>
            </div>
        @endif

        <!-- ACTIONS -->
        <div class="mt-8 flex justify-between items-center">
            <a href="{{ route('admin.chapters.index') }}" 
                class="px-5 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 flex items-center gap-2 transition">
                <i data-feather="arrow-left" class="w-4 h-4"></i> Back
            </a>

            <button type="submit"
                class="bg-gradient-to-r from-[#CF2031] to-[#b81b2a] hover:from-[#b81b2a] hover:to-[#991826] text-white px-6 py-2 rounded-lg shadow transition flex items-center gap-2">
                <i data-feather="save" class="w-4 h-4"></i> Save Assignments
            </button>
        </div>
    </form>
</div>

<!-- SEARCH FILTER SCRIPT -->
<script>
document.getElementById('memberSearch')?.addEventListener('input', function() {
    const query = this.value.toLowerCase();
    document.querySelectorAll('.member-item').forEach(item => {
        const name = item.querySelector('span.font-semibold').textContent.toLowerCase();
        const email = item.querySelector('span.text-xs').textContent.toLowerCase();
        item.style.display = (name.includes(query) || email.includes(query)) ? '' : 'none';
    });
});
</script>

<script>
    feather.replace();
</script>
@endsection
