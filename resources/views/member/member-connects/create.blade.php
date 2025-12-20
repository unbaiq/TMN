@extends('layouts.app')
@section('title', 'Add Connect')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white rounded-xl shadow border border-red-100">
    <h2 class="text-xl font-bold mb-4">➕ Add Business Connect</h2>

    <form method="POST" action="{{ route('member.connects.store') }}">
        @include('member.member-connects.form')
    </form>
</div>
@endsection
