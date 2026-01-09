@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-8">

    {{-- ================= SINGLE CONTAINER ================= --}}
    <div class="bg-white rounded-2xl shadow p-8 space-y-8">

        {{-- HEADER --}}
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-900">
                    Edit Recognition
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Update recognition details or attachment.
                </p>
            </div>

            <a href="{{ route('admin.recognitions.index') }}"
               class="bg-gray-100 hover:bg-gray-200 text-gray-700
                      px-4 py-2 rounded-lg text-sm font-medium transition">
                <i data-feather="arrow-left" class="inline w-4 h-4 mr-1"></i>
                Back
            </a>
        </div>

        {{-- FORM --}}
        <form method="POST"
              action="{{ route('admin.recognitions.update', $recognition) }}"
              enctype="multipart/form-data"
              class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Title --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Title
                </label>
                <input type="text"
                       name="title"
                       value="{{ old('title', $recognition->title) }}"
                       required
                       class="w-full border rounded-lg px-4 py-2.5 text-sm
                              focus:ring-red-500 focus:border-red-500">
            </div>

            {{-- Description --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Description
                </label>
                <textarea name="description"
                          rows="3"
                          class="w-full border rounded-lg px-4 py-2.5 text-sm
                                 focus:ring-red-500 focus:border-red-500">{{ old('description', $recognition->description) }}</textarea>
            </div>

            {{-- Date / Business Value / Points --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Date
                    </label>
                    <input type="date"
                           name="recognized_on"
                           value="{{ old('recognized_on', optional($recognition->recognized_on)->format('Y-m-d')) }}"
                           class="w-full border rounded-lg px-4 py-2.5 text-sm
                                  focus:ring-red-500 focus:border-red-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Business Value (₹)
                    </label>
                    <input type="number"
                           step="0.01"
                           name="business_value"
                           value="{{ old('business_value', $recognition->business_value) }}"
                           class="w-full border rounded-lg px-4 py-2.5 text-sm
                                  focus:ring-red-500 focus:border-red-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Points
                    </label>
                    <input type="number"
                           name="points"
                           value="{{ old('points', $recognition->points) }}"
                           class="w-full border rounded-lg px-4 py-2.5 text-sm
                                  focus:ring-red-500 focus:border-red-500">
                </div>
            </div>

            {{-- Evidence File --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Replace Evidence File (optional)
                </label>

                <input type="file"
                       name="evidence_file"
                       accept=".jpg,.jpeg,.png,.pdf"
                       class="w-full border rounded-lg px-4 py-2.5 text-sm
                              file:bg-red-600 file:text-white
                              hover:file:bg-red-700">

                @if($recognition->evidence_file)
                    <p class="text-xs text-gray-500 mt-2">
                        Current file:
                        <a href="{{ asset('storage/'.$recognition->evidence_file) }}"
                           target="_blank"
                           class="text-blue-600 hover:underline">
                            View
                        </a>
                    </p>
                @endif
            </div>

            {{-- ACTIONS --}}
            <div class="pt-6 flex justify-end gap-3">
                <a href="{{ route('admin.recognitions.index') }}"
                   class="px-5 py-2.5 rounded-lg text-sm
                          bg-gray-100 hover:bg-gray-200
                          text-gray-700 font-medium">
                    Cancel
                </a>

                <button type="submit"
                        class="bg-red-600 hover:bg-red-700
                               text-white px-6 py-2.5
                               rounded-lg text-sm font-medium shadow">
                    <i data-feather="save" class="inline w-4 h-4 mr-1"></i>
                    Update Recognition
                </button>
            </div>

        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    if (window.feather) feather.replace();
});
</script>
@endsection
