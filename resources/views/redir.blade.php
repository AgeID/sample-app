@extends('layout1')

@section('content')
    SFW Page
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
    @if( $error == "unauthorized" )
        alert('Authentication failed: {{$error}}' );
        window.location.href = '{{$ageIdUrl}}/login?client_url={{ route('home') }}';

    @endif
    @if( $error != "unauthorized" && $error != "" )
            alert('Client internal message error:{{$error}}' );
    @endif
    @if( $status == "unverified" )
       alert('You need to verify your account before being able to access our content');
       window.location.href = '{{$ageIdUrl}}';
    @endif
    @if( $status == "unauthorized" )
        alert('You need to login / create on account on ageid.com');
        window.location.href = '{{$ageIdUrl}}/login';
    @endif
    @if( $status == "verified" )
        alert('You are allowed to access our content');
        window.location.href = '{{route('home')}}';;
    @endif
    </script>
@endsection