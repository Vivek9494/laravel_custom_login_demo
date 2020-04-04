<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
    
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    @yield('stylesheet')

</head>
<body>
@yield('logout')

<div class="container">
    @yield('content')
</div>

</body>
    @yield('js')
</html>