<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset_env('css/app.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script>window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token(), ]); ?></script>
</head>
<body>
    <div id="app">
        <board uid="influendo"></board>
        <slider></slider>
        <inactivity></inactivity>
    </div>

    <!-- Scripts -->
    <script src="{{ asset_env('js/app.js') }}"></script>
</body>
</html>
