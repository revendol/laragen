<!DOCTYPE html>
<html lang="en">
<head>
    @include('laragen::partials._head')
</head>

<body class="landing-page sidebar-collapse">
@include('laragen::partials._nav')
@yield('contents')
@include('laragen::partials._footer')
@include('laragen::partials._footerScript')
</body>

</html>
