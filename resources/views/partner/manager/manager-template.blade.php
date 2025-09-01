<?php
$ext_url = 'header-footer.'.$user.'-header-footer';
?>


@if(($user != 'manager' && $user != 'partner'))
<?php
Auth::logout();
 ?>
 <script type="text/javascript">
 	window.location = "{{url('/')}}";
 </script>
@else

@extends($ext_url)

@section('content')
    @yield('manager')
@endsection
@endif
