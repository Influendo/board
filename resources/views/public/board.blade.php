<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="theme-color" content="#ffffff" />
    <meta name="msapplication-TileColor" content="#da532c" />
    <meta name="msapplication-TileImage" content="{{ asset('favicon/mstile-150x150.png') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon/apple-touch-icon.png') }}" />
    <link rel="icon" type="image/png" href="{{ asset('favicon/android-chrome-512x512.png') }}" sizes="512x512" />
    <link rel="icon" type="image/png" href="{{ asset('favicon/android-chrome-192x192.png') }}" sizes="192x192" />
    <link rel="icon" type="image/png" href="{{ asset('favicon/favicon-32x32.png') }}" sizes="32x32" />
    <link rel="icon" type="image/png" href="{{ asset('favicon/favicon-16x16.png') }}" sizes="16x16" />
    <link rel="mask-icon" href="{{ asset('favicon/safari-pinned-tab.svg') }}" color="#5bbad5" />
    <link rel="shortcut icon" href="{{ asset('favicon/favicon.ico') }}" />
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="{{ asset_env('css/app.css') }}" rel="stylesheet" />
    <script>window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token(), ]); ?></script>
</head>
<body>
    <div id="app">
        <board uid="influendo"></board>
        <slider></slider>
        <inactivity></inactivity>
        <updater></updater>
    </div>
    <script src="{{ asset_env('js/app.js') }}"></script>
</body>
</html>
