<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TMN Membership Registration</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <!-- MAIN FORM CARD -->
    <div id="form-container" class="max-w-3xl w-full mx-4 bg-white shadow-lg rounded-lg p-8 my-10">
        <h2 class="text-2xl font-semibold text-center text-[#CF2031] mb-6">
            TMN Membership Registration
        </h2>

        @if(session('success'))
            <div class="p-3 bg-green-100 text-green-800 rounded mb-4 text-center">
                {{ session('success') }}
            </div>
        @endif

        <form id="registrationForm" method="POST" 
              action="{{ route('member.join.submit', $enquiry->membership_token) }}" 
              enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Full Name *</label>
                    <input type="text" name="full_name" value="{{ old('full_name', $enquiry->name) }}"
                           class="w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-[#CF2031]" required>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Email *</label>
                    <input type="email" name="email" value="{{ old('email', $enquiry->email) }}"
                           class="w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-[#CF2031]" required>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Mobile Number *</label>
                    <input type="text" name="contact_mobile" value="{{ old('contact_mobile', $enquiry->contact_number) }}"
                           class="w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-[#CF2031]" required>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Gender</label>
                    <select name="gender" class="w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-[#CF2031]">
                        <option value="">Select</option>
                        <option value="Male" {{ old('gender')=='Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('gender')=='Female' ? 'selected' : '' }}>Female</option>
                        <option value="Other" {{ old('gender')=='Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Date of Birth</label>
                    <input type="date" name="date_of_birth"
                           class="w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-[#CF2031]"
                           value="{{ old('date_of_birth') }}">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Profession</label>
                    <input type="text" name="profession" value="{{ old('profession', $enquiry->profession) }}"
                           class="w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-[#CF2031]">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Company Name</label>
                    <input type="text" name="company_name" value="{{ old('company_name') }}"
                           class="w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-[#CF2031]">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Website</label>
                    <input type="text" name="website_url" value="{{ old('website_url') }}"
                           class="w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-[#CF2031]">
                </div>
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-1">Business Description</label>
                <textarea name="business_description" rows="3"
                          class="w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-[#CF2031]"
                          placeholder="Brief about your business...">{{ old('business_description') }}</textarea>
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-1">Profile Photo</label>
                <input type="file" name="photo"
                       class="w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-[#CF2031]">
            </div>

            <button type="submit" id="submitBtn" 
                    class="w-full bg-[#CF2031] text-white py-2 rounded-lg hover:bg-[#b81a28] transition">
                Submit Registration
            </button>
        </form>
    </div>

    <!-- LOADING SPINNER -->
    <div id="loading" class="hidden fixed inset-0 flex flex-col items-center justify-center bg-white bg-opacity-90 z-50">
        <div class="w-16 h-16 border-4 border-[#CF2031] border-dashed rounded-full animate-spin"></div>
        <p class="mt-4 text-[#CF2031] font-semibold text-lg">Submitting your information...</p>
    </div>

    <!-- THANK YOU SCREEN -->
    <div id="thankyou" class="hidden flex flex-col items-center justify-center h-screen bg-gray-100 text-center">
        <div class="bg-white shadow-lg rounded-2xl p-10 max-w-md">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 mx-auto text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <h2 class="text-2xl font-bold text-[#CF2031] mt-4">Thank You!</h2>
            <p class="text-gray-700 mt-2">Your membership registration has been submitted successfully.</p>
            <p class="text-gray-500 text-sm mt-4">Redirecting to login page...</p>
        </div>
    </div>

    <!-- ✅ FIXED JS -->
    <script>
        const form = document.getElementById('registrationForm');
        const loading = document.getElementById('loading');
        const formContainer = document.getElementById('form-container');
        const thankyou = document.getElementById('thankyou');

        form.addEventListener('submit', async function (e) {
            e.preventDefault();

            loading.classList.remove('hidden');
            formContainer.classList.add('hidden');

            const formData = new FormData(form);

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: formData
                });

                if (response.ok) {
                    loading.classList.add('hidden');
                    thankyou.classList.remove('hidden');
                    setTimeout(() => window.location.href = "/login", 3000);
                } else {
                    alert("Something went wrong while submitting. Please try again.");
                    loading.classList.add('hidden');
                    formContainer.classList.remove('hidden');
                }
            } catch (error) {
                console.error(error);
                alert("Network error. Please check your connection and try again.");
                loading.classList.add('hidden');
                formContainer.classList.remove('hidden');
            }
        });
    </script>

</body>
</html>
