@extends('layout1')

@section('content')
    SFW Page
@endsection

@section('page-script')
<script type="text/javascript" src="{{$ageIdUrl}}/sso/{{$ageIdVersion}}/handshake?pilot={{$pilot}}&client_id={{$clientId}}&payload={{$payload}}"></script>
@endsection