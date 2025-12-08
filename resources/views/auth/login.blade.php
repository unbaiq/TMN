<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;600&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Lexend', sans-serif; }
  </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center px-4 py-12">
<img src="/images/adminlogin.jpg" alt="Background Image" class="absolute inset-0 w-full h-full object-cover -z-10"/>
<div class="w-full max-w-md bg-white/80 backdrop-blur-xl border border-white/30 rounded-3xl shadow-2xl p-8 sm:p-10 md:p-12">
    <div class="flex justify-center mb-6">
        <img src="/logo/lightlogo/logo.svg" alt="Logo" class="w-32 sm:w-40 h-auto object-contain drop-shadow-lg" />
    </div>
    <h2 class="text-3xl font-bold text-center text-black-500 mb-2 tracking-wide">
        Welcome Back
    </h2>
    @if ($errors->any())
        <div class="mb-4 bg-red-100 text-red-700 px-4 py-3 rounded-md text-sm shadow">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="" method="POST" class="space-y-6">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
            <input type="email" name="email" required placeholder="you@example.com" class="w-full px-4 py-3 bg-gray-100/70 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-700"/>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <div class="relative">
                <input type="password" name="password" id="password" required placeholder="••••••••" class="w-full px-4 py-3 pr-16 bg-gray-100/70 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-700"/>
                <button type="button" id="togglePassword" class="absolute inset-y-0 right-4 flex items-center text-sm font-medium text-gray-700 hover:text-blue-800">
                    Show
                </button>
            </div>
        </div>
        <div class="flex items-center justify-between">
    <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-700">
        Remember me
    </label>
    <a href="#" class="text-sm text-gray-700 hover:text-blue-800 font-medium">
        Forgot password?
    </a>
      </div>
        <button type="submit" class="w-full bg-gradient-to-r from-purple-600 via-indigo-500 to-blue-500 text-white py-3 px-4 rounded-xl font-semibold shadow-lg hover:opacity-90 active:scale-95 transition duration-200">
          Login
        </button>
    </form>
  </div>
</body>
</html>
<script>
  const togglePasswordBtn = document.getElementById('togglePassword');
  const passwordInput = document.getElementById('password');
  togglePasswordBtn.addEventListener('click', function () {
    const type = passwordInput.getAttribute('type');
    passwordInput.setAttribute('type', type === 'password' ? 'text' : 'password');
    this.textContent = type === 'password' ? 'Hide' : 'Show';
  });
</script>