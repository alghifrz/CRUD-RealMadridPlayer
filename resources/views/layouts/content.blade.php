@include('layouts.header')
 
<body class="bg-gray-200">
    @yield('main-content')
    @include('layouts.footer')
    @stack('js')
</body>
 
</html>