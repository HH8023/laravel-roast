<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <title>Roast</title>
    <script type='text/javascript'>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>

    <div id="app">
        <router-view></router-view>
    </div>

    <script src="https://webapi.amap.com/maps?v=1.4.8&key=6e2a029af4c57cebdd43e3274b26155e"></script>
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>

</body>
</html>
