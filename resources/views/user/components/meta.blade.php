<!DOCTYPE html>
<html lang="en">
  
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Top Management Network</title>

    @php
        $assetBase = app()->environment('local')
            ? ''
            : config('app.url') . '/tmn/public';
    @endphp

    {{-- Main CSS --}}
    <link rel="stylesheet" href="{{ $assetBase }}/css/base.css">

    {{-- Favicon & Icons --}}
    <link rel="shortcut icon" href="{{ $assetBase }}/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ $assetBase }}/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ $assetBase }}/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ $assetBase }}/favicon-16x16.png">
    <link rel="manifest" href="{{ $assetBase }}/site.webmanifest">

    {{-- Tailwind (CDN – recommended) --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Font Awesome --}}
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />

    {{-- Splide --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/splidejs/4.1.4/css/splide.min.css"
          rel="stylesheet">

    {{-- Swiper --}}
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
</head>

<body>
