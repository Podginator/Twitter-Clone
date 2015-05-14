@extends('template.nav')



@section('content')

	<div class="wide">
		<div class="home">

		<div class="row">
		  	<div class="col-xs-5"></div>
		    <div class="col-xs-2 title">Stories!</div>
		    <div class="col-xs-5"></div>
		</div>

		<div class="row">
			<div class="col-md-4 col-md-offset-7 homelogin">
		  		@include('auth.loginform')
			</div>
		</div>

			
		</div>
	</div>
	
@endsection
