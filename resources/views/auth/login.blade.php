@php
  $assetBase = app()->environment('local')
    ? ''
    : config('app.url') . '/tmn/public';
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>TMN Login</title>
  <link rel="apple-touch-icon" sizes="180x180" href="{{ $assetBase }}/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ $assetBase }}/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ $assetBase }}/favicon-16x16.png">
  <link rel="manifest" href="{{ $assetBase }}/site.webmanifest">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;600&display=swap" rel="stylesheet">

  <style>
    /* Base page */
    body {
      font-family: 'Lexend', sans-serif;
      background: radial-gradient(circle at top left, #ea580c, #ef4444, #f87171);
      min-height: 100vh;
      overflow: hidden;
      position: relative;
    }

    /* TMN Mesh Background */
    .tmn-bg::before {
      content: "";
      position: absolute;
      inset: 0;
      background-image:
        linear-gradient(120deg, rgba(255, 255, 255, 0.08) 1px, transparent 1px),
        linear-gradient(60deg, rgba(255, 255, 255, 0.06) 1px, transparent 1px);
      background-size: 70px 70px;
      animation: moveLines 14s linear infinite;
      z-index: -1;
    }

    @keyframes moveLines {
      from {
        transform: translateX(0) translateY(0);
      }

      to {
        transform: translateX(-120px) translateY(-120px);
      }
    }

    /* PREMIUM LOADER */
    /* Rotating outer ring */
    .tmn-loader-ring {
      width: 80px;
      height: 80px;
      border-radius: 9999px;
      border: 6px solid transparent;
      border-top-color: #ffffff;
      border-right-color: rgba(255, 255, 255, 0.7);
      animation: spinRing 0.9s linear infinite;
    }

    @keyframes spinRing {
      to {
        transform: rotate(360deg);
      }
    }

    /* Inner pulsing dot */
    .tmn-loader-dot {
      width: 20px;
      height: 20px;
      background: #ffffff;
      border-radius: 50%;
      animation: pulseDot 1s infinite ease-in-out;
      opacity: 0.9;
    }

    @keyframes pulseDot {
      0% {
        transform: scale(1);
        opacity: 0.7;
      }

      50% {
        transform: scale(1.4);
        opacity: 1;
      }

      100% {
        transform: scale(1);
        opacity: 0.7;
      }
    }

    /* Fade overlay */
    #loadingOverlay {
      animation: fadeIn 0.25s ease-out forwards;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
      }

      to {
        opacity: 1;
      }
    }

    /* Modern Button Style */
    button {
      transition: all 0.25s ease;
    }

    button:hover {
      transform: translateY(-2px);
    }

    /* INPUTS */
    input,
    select,
    textarea {
      transition: all .2s ease-in-out;
    }

    input:focus,
    select:focus,
    textarea:focus {
      border-color: #e11d48 !important;
      box-shadow: 0 0 0 3px rgba(225, 29, 72, 0.25);
      outline: none;
    }
  </style>
</head>

<body class="tmn-bg flex items-center justify-center px-4 py-12">

  <!-- PREMIUM LOADING OVERLAY -->
  <div id="loadingOverlay"
    class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50">
    <div class="flex flex-col items-center space-y-6">

      <!-- Rotating Ring -->
      <div class="relative flex items-center justify-center">
        <div class="tmn-loader-ring"></div>

        <!-- Inner Dot -->
        <div class="absolute tmn-loader-dot"></div>
      </div>

      <!-- Text -->
      <p class="text-white text-lg font-medium tracking-wide">
        Logging you in…
      </p>
    </div>
  </div>

  <!-- LOGIN CARD -->
  <div class="w-full max-w-md bg-white/75 backdrop-blur-2xl shadow-2xl border border-white/30 rounded-3xl p-8 sm:p-10">

    <div class="flex justify-center mb-6">
      <img src="{{ $assetBase }}/images/newlogo.png" class="w-32 sm:w-40 drop-shadow-lg" />

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

    <!-- LOGIN FORM -->
    <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-6" id="loginForm">
      @csrf

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
        <input type="email" name="email" required placeholder="you@example.com"
          class="w-full px-4 py-3 bg-gray-100/70 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500" />
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
        <div class="relative">
          <input type="password" name="password" id="password" required placeholder="••••••••"
            class="w-full px-4 py-3 pr-16 bg-gray-100/70 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500" />

          <button type="button" id="togglePassword"
            class="absolute inset-y-0 right-4 flex items-center text-sm font-medium text-gray-700 hover:text-red-700">
            Show
          </button>
        </div>
      </div>

      <div class="flex items-center justify-between">
        <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
          <input type="checkbox" name="remember"
            class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-500">
          Remember me
        </label>

        <a href="#" class="text-sm text-gray-700 hover:text-red-700 font-medium">Forgot password?</a>
      </div>

      <button id="loginBtn" type="submit"
        class="w-full bg-gradient-to-r from-red-600 via-red-500 to-orange-400 text-white py-3 px-4 rounded-xl font-semibold shadow-lg hover:opacity-90 active:scale-95 transition duration-200">
        Login
      </button>
    </form>

  </div>

  <!-- JS -->
  <script>
    // Toggle Password
    const togglePassword = document.getElementById("togglePassword");
    const passwordField = document.getElementById("password");

    togglePassword.addEventListener("click", () => {
      const type = passwordField.type === "password" ? "text" : "password";
      passwordField.type = type;
      togglePassword.textContent = type === "password" ? "Show" : "Hide";
    });

    // Premium Loader Trigger
    const loginForm = document.getElementById("loginForm");
    const loadingOverlay = document.getElementById("loadingOverlay");
    const loginBtn = document.getElementById("loginBtn");

    loginForm.addEventListener("submit", () => {
      loadingOverlay.classList.remove("hidden");

      loginBtn.disabled = true;
      loginBtn.innerHTML = `
    <span class="flex items-center justify-center gap-2">
      <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-30" cx="12" cy="12" r="10" stroke="white" stroke-width="4"></circle>
        <path class="opacity-100" fill="white" d="M4 12a8 8 0 018-8v4l3-3-3-3v4a8 8 0 11-8 8z"></path>
      </svg>
      Logging in…
    </span>
  `;
    });
  </script>

</body>

</html>