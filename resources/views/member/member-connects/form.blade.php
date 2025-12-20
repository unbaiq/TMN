@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-5">

    <div>
        <label class="text-sm font-medium">Person Name *</label>
        <input name="person_name" required
               value="{{ old('person_name', $memberConnect->person_name ?? '') }}"
               class="w-full border rounded-lg px-4 py-2 mt-1">
    </div>

    <div>
        <label class="text-sm font-medium">Designation</label>
        <input name="designation"
               value="{{ old('designation', $memberConnect->designation ?? '') }}"
               class="w-full border rounded-lg px-4 py-2 mt-1">
    </div>

    <div>
        <label class="text-sm font-medium">Company Name *</label>
        <input name="company_name" required
               value="{{ old('company_name', $memberConnect->company_name ?? '') }}"
               class="w-full border rounded-lg px-4 py-2 mt-1">
    </div>

    <div>
        <label class="text-sm font-medium">Industry *</label>
        <input name="industry" required
               value="{{ old('industry', $memberConnect->industry ?? '') }}"
               class="w-full border rounded-lg px-4 py-2 mt-1">
    </div>

    <div>
        <label class="text-sm font-medium">Profession *</label>
        <input name="profession" required
               value="{{ old('profession', $memberConnect->profession ?? '') }}"
               class="w-full border rounded-lg px-4 py-2 mt-1">
    </div>

    <div>
        <label class="text-sm font-medium">Website</label>
        <input name="website"
               value="{{ old('website', $memberConnect->website ?? '') }}"
               class="w-full border rounded-lg px-4 py-2 mt-1">
    </div>

    <div>
        <label class="text-sm font-medium">Phone</label>
        <input name="contact_phone"
               value="{{ old('contact_phone', $memberConnect->contact_phone ?? '') }}"
               class="w-full border rounded-lg px-4 py-2 mt-1">
    </div>

    <div>
        <label class="text-sm font-medium">WhatsApp</label>
        <input name="whatsapp_number"
               value="{{ old('whatsapp_number', $memberConnect->whatsapp_number ?? '') }}"
               class="w-full border rounded-lg px-4 py-2 mt-1">
    </div>

    <div>
        <label class="text-sm font-medium">Email</label>
        <input name="contact_email"
               value="{{ old('contact_email', $memberConnect->contact_email ?? '') }}"
               class="w-full border rounded-lg px-4 py-2 mt-1">
    </div>

    <div>
        <label class="text-sm font-medium">Chapter</label>
        <input name="chapter_name"
               value="{{ old('chapter_name', $memberConnect->chapter_name ?? '') }}"
               class="w-full border rounded-lg px-4 py-2 mt-1">
    </div>

    <div class="md:col-span-2">
        <label class="text-sm font-medium">Services</label>
        <textarea name="services" rows="3"
                  class="w-full border rounded-lg px-4 py-2 mt-1">{{ old('services', $memberConnect->services ?? '') }}</textarea>
    </div>

    <div>
        <label class="text-sm font-medium">Visibility</label>
        <select name="visibility" class="w-full border rounded-lg px-4 py-2 mt-1">
            <option value="members" @selected(old('visibility', $memberConnect->visibility ?? '') === 'members')>Members</option>
            <option value="public" @selected(old('visibility', $memberConnect->visibility ?? '') === 'public')>Public</option>
        </select>
    </div>

</div>

<div class="mt-6 flex justify-end gap-3">
    <a href="{{ route('member.connects.index') }}"
       class="px-5 py-2 rounded-lg border text-gray-600">
        Cancel
    </a>

    <button class="bg-red-700 hover:bg-red-800 text-white px-6 py-2 rounded-lg shadow">
        Save Connect
    </button>
</div>
