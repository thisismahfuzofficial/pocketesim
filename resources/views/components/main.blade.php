<!DOCTYPE html>
<html lang="en">


<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    <!-- General meta tags needed-->
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <!-- Needed for responsive design -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- If you want custom browser colors on mobile -->
    <meta name="theme-color" content="#670ff2" />
    <meta name="apple-mobile-web-app-status-bar-style" content="#1843c1">
    <link rel="shortcut icon" href="{{ asset('img/image/fav-5G.png') }}">


    <title>@yield('title', setting('site.title'))</title>
    <meta name="description" content="@yield('description', setting('site.description'))">
    <link rel="canonical" href="{{ url()->current() }}" />
    <meta name="keywords" content="@yield('keywords', 'merr5G, eSIM, data, internet')">
    <meta name="author" content="merr5g">
    {{-- custom toster --}}
    <link rel="stylesheet" href="{{ asset('js/search/search.min.css') }}">
    <link rel="stylesheet" href="{{ asset('toastr/toastr.css') }}">
    <!-- CSS File -->
    <link rel="stylesheet" href="{{ asset('css/app55cc.css') }}">

    @stack('css')
   

</head>

<body>


    <header class="header">

        <x-topnav />



    </header>


    <main>
        <div class="container container-full">
            {{ $slot }}
            <x-footer></x-footer>

        </div>
    </main>



    {{-- custom toster --}}

    <script src="{{ asset('jquery/jquery-3.7.1.min55cc.js?v=1.1.22') }}"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    {{-- <script src='{{ asset('ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate55cc.js?v=1.1.22') }}'></script> --}}
    {{-- <script src="{{ asset('malsup.github.io/jquery.blockUI55cc.js?v=1.1.22') }}"></script> --}}
    {{-- <script src="{{ asset('cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min55cc.js?v=1.1.22') }}"></script> --}}
    <script src="{{ asset('js/app55cc.js') }}"></script>
    <script src="{{ asset('esimcontent/custom55cc.js?v=1.1.22') }}"></script>
    <script type="text/javascript" src="{{ asset('esimcontent/js/js.cookie.min.js') }}"></script>


    <script src="{{ asset('js/search/search.min.js') }}"></script>
    <script src="{{ asset('toastr/toastr.min.js') }}"></script>
    <script>
        document.getElementById('search').addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                document.getElementById('searchForm').submit();
            }
        });
    </script>
    <script>
        $(document).ready(function() {
    $('.js-example-basic-single').select2();
});
    </script>

    @if (session()->has('success'))
        <script>
            toastr.info("{{ session('success') }}")
        </script>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <script>
                        toastr.error("{{ $error }}")
                    </script>
                @endforeach
            </ul>
        </div>
    @endif
    @stack('javascript')



</body>





</html>
