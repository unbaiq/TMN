<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;600&display=swap" rel="stylesheet">
<style>
    body {
      font-family: 'Lexend', sans-serif;

      /* UPDATED TMN GRADIENT */
      background: radial-gradient(
        circle at top left,
        #ea580c,   /* orange-600 */
        #ef4444,   /* red-500 */
        #f87171    /* red-400 */
      );

      min-height: 100vh;
      overflow: hidden;
      position: relative;
    }

    /* TMN network mesh lines */
    .tmn-bg::before {
      content: "";
      position: absolute;
      inset: 0;
      background-image:
        linear-gradient(120deg, rgba(255,255,255,0.08) 1px, transparent 1px),
        linear-gradient(60deg, rgba(255,255,255,0.06) 1px, transparent 1px);
      background-size: 70px 70px;
      animation: moveLines 12s linear infinite;
      z-index: -1;
    }

    @keyframes moveLines {
      from { transform: translateX(0) translateY(0); }
      to { transform: translateX(-100px) translateY(-100px); }
    }
</style>
</head>
<body class="tmn-bg flex items-center justify-center px-4 py-12">
  <div class="w-full max-w-md bg-white/75 backdrop-blur-2xl shadow-2xl border border-white/30 rounded-3xl p-8 sm:p-10">
    <div class="flex justify-center mb-6">
      <img src="{{ asset('images/logo1.png') }}" class="w-32 sm:w-40 drop-shadow-lg" />
    </div>
    <h2 class="text-3xl font-bold text-center text-gray-900 mb-2 tracking-wide">
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
    <form method="POST" class="space-y-6">
      @csrf
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
        <input type="email" name="email" required placeholder="you@example.com" class="w-full px-4 py-3 bg-gray-100/70 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500"/>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
        <div class="relative">
          <input type="password" name="password" id="password" required placeholder="••••••••"
            class="w-full px-4 py-3 pr-16 bg-gray-100/70 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500"/>
          <button type="button" id="togglePassword"
            class="absolute inset-y-0 right-4 flex items-center text-sm font-medium text-gray-700 hover:text-red-700">
            Show
          </button>
        </div>
      </div>
      <div class="flex items-center justify-between">
        <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
          <input type="checkbox" name="remember" class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-500">
          Remember me
        </label>
        <a href="#" class="text-sm text-gray-700 hover:text-red-700 font-medium">
          Forgot password?
        </a>
      </div>
      <button type="submit"
        class="w-full bg-gradient-to-r from-red-600 via-red-500 to-orange-400 text-white py-3 px-4 rounded-xl font-semibold shadow-lg hover:opacity-90 active:scale-95 transition duration-200">
        Login
      </button>
    </form>
  </div>
<script>
  const togglePassword = document.getElementById("togglePassword");
  const passwordField = document.getElementById("password");

  togglePassword.addEventListener("click", () => {
    const type = passwordField.type === "password" ? "text" : "password";
    passwordField.type = type;
    togglePassword.textContent = type === "password" ? "Show" : "Hide";
  });
</script>
</body>
</html>
