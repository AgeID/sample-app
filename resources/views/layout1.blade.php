<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="https://cdn1.ageid.com/css/ageid-button.css" rel="stylesheet">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <body>
    @if(config('app.env') == 'qa')
    <div class="debug">
        Linked to:
        <a href="{{config('ageId.baseURL')}}" target="_blank">{{config('ageId.baseURL')}}</a><br/>
        Client ID: {{config('ageId.clientId')}}
    </div>
    @endif
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

        <script>
            $('.btn-group-justified').show();
        </script>
        @yield('page-script')        
    </body>
</html>
