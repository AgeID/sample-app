@extends('layout1')

@section('content')
    <div class="row">
        <h1 class="col-xs-12 title">SFW Page</h1>
    </div>
    {{--<noscript>--}}
    <div class="row no-script">
        @if( $error == "unauthorized" )
            <div class="col-xs-12 message">
                Authentication failed: {{$error}}
            </div>
            <div class="col-xs-12 text-center">
                <a href="{{$ageIdUrl}}/login?client_url={{ route('home') }}" class="btn btn-primary">Login AgeID</a>
            </div>
        @endif
        @if( $error != "unauthorized" && $error != "" )
            <div class="col-xs-12 message">
                Client internal message error:{{$error}}
            </div>
        @endif
        @if( $status == "unverified" )
            <div class="col-xs-12 message">
                You need to verify your account before being able to access our content
            </div>
            <div class="col-xs-12 text-center">
                <a href="{{$ageIdUrl}}?client_url={{route('redirect.ageid.handshake') }}" class="btn btn-primary">Verify on AgeID</a>
            </div>
        @elseif( $status == "unauthorized" )
            <div class="col-xs-12 message">
                You need to login / create on account on ageid.com
            </div>
            <div class="col-xs-12 text-center">
                <a href="{{$ageIdUrl}}" class="btn btn-primary">AgeID</a>
            </div>
        @elseif( $status == "emailactivation" )
            <div class="col-xs-12 message">
                You need to activate your email
            </div>
            <div class="col-xs-12 text-center">
                <a href="{{$ageIdUrl}}" class="btn btn-primary">Visit AgeID</a>
            </div>
        @else
            <div class="col-xs-12 message">
                There's an issue with your account, go to <b>AgeID</b> for more info.
            </div>
            <div class="col-xs-12 text-center">
                <a href="{{$ageIdUrl}}" class="btn btn-primary">Visit AgeID</a>
            </div>
        @endif
    </div>
    {{--</noscript>--}}
@endsection
