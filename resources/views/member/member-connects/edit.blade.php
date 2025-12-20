@extends('layouts.app')
@section('title', 'Edit Connect')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white rounded-xl shadow border border-red-100">

    <h2 class="text-xl font-bold mb-4">✏️ Edit Business Connect</h2>

    <form method="POST"
          action="{{ route('member.connects.update', $memberConnect) }}">
        @csrf
        @method('PUT')

        @include('member.member-connects.form', ['memberConnect' => $memberConnect])

    </form>
</div>
@endsection
