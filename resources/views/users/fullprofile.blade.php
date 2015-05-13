@extends('template.nav')

@section('title') 
	{{Auth::user()->username}} Profile
@endsection

@section('angularApp')
	<body ng-app="postApp" >
@endsection

@section('content')

@section('content')
<div class="container-fluid">
	
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Your Profile</div>
				<div class="panel-body">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<strong>Whoops!</strong> There were some problems with your input.<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					<form class="form-horizontal" role="form" method="POST" action="{{ url('/profile') }}"  enctype="multipart/form-data">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						
						<div class="form-group">
							<div class="col-md-10 col-md-offset-1 text-center">
									
									@if (Auth::user()->images)
										<img alt="Profile Image" width="140" height="140" src="{{asset(Auth::user()->images->url)}}">
									@else
										<img alt="Profile Image" width="140" height="140" src="{{asset('/imgs/default-avatar.png')}}">
									@endif
									<p class="">Profile Picture </p>
							    	<input type="file" name="Image" id="ImageUpload" style="padding-left:50px; display:inline;">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Biography</label>
							<div class="col-md-6">
								<textarea class="form-control" rows="5" id="bio" name="bio">{{Auth::user()->biograpghy}}</textarea>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									Update
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row" id="accordian">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
		    <div class="panel-heading">
		        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#followEvents">
		          Following Events
        		</a>
    		</div>
    		<div id="followEvents" class="panel-collapse collapse">
      			<div class="panel-body">
     				@foreach (Auth::user()->followingEvent as $event)
						<p><a href="{{url('/tag/'.$event->hashtag)}}"> {{$event->hashtag}} </a> <span style="float:right;"> <a href="{{url('/user/tag/delete/'.$event->id)}}"> Delete! </a> </span></p>
					@endforeach
      		</div>
    </div>
@endsection


@endsection
