@extends('layout1')

@section('content')
    SFW Page

    <noscript>
    <div class="row no-script">
        <div class="col-xs-12 message">
            It appears your javascript is disabled.<br>Click the following button to proceed to AgeID
        </div>
        <div class="col-xs-12 text-center"><a href="{{ route('redirect.ageid.handshake') }}" class="btn btn-primary">Verify with AgeID</a></div>
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
    var ageidOnload = function () {
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
            ageIdUrl     : '{{$ageIdUrl}}',                     // for non-production
            clientUrl    : '{{config('app.url')}}'              //mandatory, used for redirecting the user back to client's site after account creation and registering
        });
        $("#ageIdModal").modal({
            backdrop: 'static',
            keyboard: false
        }).modal('show');
    };
</script>
<script type="text/javascript" src="{{$ageIdUrl}}/sso/v1/handshake?pilot={{$pilot}}&client_id={{$clientId}}&payload={{$payload}}&onload=ageidOnload" async defer></script>
@endsection