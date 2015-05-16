@extends('template.nav')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			@include("auth.loginform")
		</div>
	</div>
</div>
@endsection
