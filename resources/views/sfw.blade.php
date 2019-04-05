@extends('layout1')

@section('content')

    <div class="btn-group btn-group-justified" role="group" aria-label="..." style="position: absolute;top: 0;left: 0;z-index: 2000;">
        <div class="btn-group" role="group">
            <a href="?type=ageidOnload" type="button" class="btn btn-default {{$type == 'ageidOnload' ? 'active' : 'false'}}">AgeID modal on page load</a>
        </div>
        <div class="btn-group" role="group">
            <a href="?type=ageidOnAction" type="button" class="btn btn-default {{$type == 'ageidOnAction' ? 'active' : 'false'}}">AgeID modal on button action</a>
        </div>
        <div class="btn-group" role="group">
            <a href="?type=ageidOnLoadAndAction" type="button" class="btn btn-default {{$type == 'ageidOnLoadAndAction' ? 'active' : 'false'}}">AgeID modal on page load and button action</a>
        </div>
    </div>
    <div class="row">
        <h1 class="col-xs-12 title">SFW Page</h1>

        @if($type != 'ageidOnload')
            <div class="col-xs-12">
                <h3>AgeID Verification Process</h3>
                <p class="ageid-notice">UK Law now requires all users to be age verified prior to accessing adult content - you only need to do this once</p>
                <button id="ageIdVerify" class="btn__ageid btn__ageid--blue"></button>
            </div>
        @endif

    </div>


    <noscript>
    <div class="row no-script">
        <div class="col-xs-12 message">
            It appears your javascript is disabled.<br>Click the following button to proceed to AgeID
        </div>
        <div class="col-xs-12 text-center"><a href="{{ route('redirect.ageid.handshake') }}" id="ageIdVerify" class="btn__ageid btn__ageid--blue">Verify with AgeID</a></div>
    </div>
    </noscript>
@endsection

@section('footer')
<div id="ageIdModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div id="ageid-frontdesk" class="modal-body"></div>
        </div>
    </div>
</div>
@endsection


@section('page-script')
<script type="text/javascript">
    var initAgeId = function() {
        if( document.querySelector('#ageid-frontdesk') ) {
            ageid.frontdesk.render({
                container    : 'ageid-frontdesk',
                clientId     : '{{$clientId}}',
                payload      : '{{$payload}}',
                apiURL       : '{{$callbackUrl}}',
                successURL   : '{{$successUrl}}',
                retryCounter : {{$retryCounter}},                   // optional
                retryInterval: {{$retryInterval}},                  // optional
                activePanel  : 'login',                             // optional
                prefillEmail : '',                                  // optional
                ageIdUrl     : '{{$ageIdUrl}}'                     // for non-production
            });
        }
    };

    var ageidOnload = function () {
        initAgeId();
        $("#ageIdModal").modal({
            keyboard: false,
            @if($type == 'ageidOnload')
            backdrop: 'static'
            @endif
        }).modal('show');
    };

    var ageidOnAction = function () {
        initAgeId();
        var ageidButton = document.querySelector('#ageid-verify');
        ageidButton.addEventListener("click", function(){
            $("#ageIdModal").modal({
                keyboard: false
            }).modal('show');
        }, false);
    };

    var ageidOnLoadAndAction = function () {
        ageidOnload();
        ageidOnAction();
    };


</script>
<script type="text/javascript" src="{{$ageIdUrl}}/sso/{{$ageIdVersion}}/handshake?pilot={{$pilot}}&client_id={{$clientId}}&payload={{$payload}}&onload={{$type}}" async defer></script>
@endsection