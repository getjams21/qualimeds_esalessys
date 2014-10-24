<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Learn Laravel</title>
		{{ HTML::style('_/css/bootstrap.css') }}
		{{ HTML::style('_/css/mystyle.css') }}
	</head>
	<body>
		@yield('header')
		@yield('content')

		{{ HTML::script('_/js/bootstrap.js') }}
		{{ HTML::script('_/js/myscript.js')}}
	</body>
</html>
