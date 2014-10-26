<!doctype html>
<html>
	<head>  
		<link rel="shortcut icon" type="image/x-icon" href="_/fonts/icon_16.ico" />
		<meta charset="utf-8">
		@yield('metatags')
		{{ HTML::style('_/css/bootstrap.css') }}
		{{ HTML::style('_/css/mystyle.css') }}
		@yield('styles') 
		<title>@yield('meta-title', 'Digisells')</title>
		<noscript>
		 For full functionality of this site it is necessary to enable JavaScript.
		 Here are the <a href="http://www.enable-javascript.com/" target="_blank">
		 instructions how to enable JavaScript in your web browser</a>.
		</noscript>
	</head>
	<body>
	<div id="fb-root"></div>
		@yield('inbodyscripts')
		<font face="Myriad Pro">
		@yield('header')
		@yield('content')
		@yield('footer')
		</font>
		{{ HTML::script('_/js/bootstrap.js') }}
		@yield('script')
		{{ HTML::script('_/js/myscript.js')}}
	</body>
</html>