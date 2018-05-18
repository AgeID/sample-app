@extends('layout1')

@section('content')
    {{--<noscript>--}}
        <div class="row no-script">
            <div class="col-xs-12 message">
                We could not verify your account,<br> please proceed to AgeID to log in and try again.
            </div>
            <div class="col-xs-12 text-center"><a href="{{ config('ageId.baseURL').'/login?client_url='.route('redirect.ageid.handshake') }}" class="btn btn-primary">Login AgeID</a></div>
            <div class="col-xs-12 message">
                Or create an account.
            </div>
            <div class="col-xs-12 text-center"><a href="{{ config('ageId.baseURL').'/register?client_url='.route('redirect.ageid.handshake') }}" class="btn btn-primary">Register AgeID</a></div>
        </div>
    {{--</noscript>--}}
@endsection