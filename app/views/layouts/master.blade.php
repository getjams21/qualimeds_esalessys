<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		{{ HTML::style('_/css/bootstrap.css') }}
		{{ HTML::style('_/css/mystyle.css') }}
		<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Roboto+Slab">
	</head>
	<body>
		<font face="Roboto+Slab">
			<div class="container col-md-6 col-md-offset-3">
				@yield('content')
			</div>
		</font>
		{{ HTML::script('_/js/bootstrap.js') }}
		{{ HTML::script('_/js/myscript.js')}}
	</body>
</html>