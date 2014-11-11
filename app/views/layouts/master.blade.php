<!doctype html>
<html>
	<head>  
		<link rel="shortcut icon" type="image/x-icon" href="_/fonts/icon_16.ico" />
		<meta charset="utf-8">
		<meta name="_token" content="{{ csrf_token() }}" hidden/>
		@yield('metatags')
		{{ HTML::style('_/css/bootstrap.css') }}
		{{ HTML::style('_/css/datepicker.css') }}
		{{ HTML::style('_/css/jquery-ui.min.css') }}
		{{ HTML::style('_/css/plugins/dataTables.bootstrap.css') }}
		{{ HTML::style('_/css/simple-sidebar.css') }}
		{{ HTML::style('_/font-awesome-4.1.0/css/font-awesome.min.css') }}
		{{ HTML::style('_/css/editable.css') }}
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
		{{ HTML::script('_/js/jquery-ui.min.js') }}
		{{ HTML::script('_/js/jquery.json-2.4.min.js') }}
		{{ HTML::script('_/js/moment.js')}}
		{{ HTML::script('_/js/plugins/dataTables/jquery.dataTables.js') }}
		{{ HTML::script('_/js/plugins/dataTables/dataTables.bootstrap.js') }}
		{{ HTML::script('_/js/plugins/dataTables/dataTable.editable.js') }}
		@yield('script')
		{{ HTML::script('_/js/myscript.js')}}
		{{ HTML::script('_/js/dataTables-columnFilter.js') }}
		{{ HTML::script('_/js/bootstrap-datepicker.js') }}
	</body>
</html>