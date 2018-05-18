<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <body>
        <div id="app">
            <div class="flex-center position-ref full-height">
                <div class="content">
                    <div class="title m-b-md">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
        @yield('footer')
        <script src="{{ asset('js/app.js') }}"></script>
        @yield('page-script')        
    </body>
</html>
