@extends('template.nav')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Home</div>

				<div class="panel-body">
					@foreach ($posts as $post)
                       <div class="panel-body">
                       		{{$post->text}}
                       	</div>
                    @endforeach
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
