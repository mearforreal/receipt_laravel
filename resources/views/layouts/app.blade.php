<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    {{-- <script src="{{ asset('js/script.js') }}"></script> --}}
    <script>
        $(document).ready(function () {
            
        $("#upload_receipt_form").submit(function (event) {
            event.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                url: "{{route('receipt.store')}}",
                type: "POST",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    if (!!data.message) {
                        $("#alert")
                            .addClass("alert-success")
                            .removeClass("d-none").removeClass("alert-danger");
                        $("#alert-heading").text(data.message);
                        $("#alert-content").text(data.receipt.type);

                        
                    }

                // no data then delete first row
                // check pagination

                const data_tr =  $('#data-table .data-tr')

                if(data_tr.length === 0){
                    $('#tr-no-data').remove()
                }

                console.log(data_tr.length);

                if(data_tr.length >= 0 && data_tr.length < 8){
                    $('#data-table tr:last').after(
                    `<tr class="data-tr">
                        <th scope="row">${data.receipt.id}</th>
                        <td>${'{{ auth()->user() !== null  ? auth()->user()->name : ''}}'}</td>
                        <td>  <img src="{{route('receipt.image', ['fileName' => '/'])}}${'/'+data.receipt.foto}" alt="receipt.image" width="100" height="100"/> </td>
                        <td>${data.receipt.type}</td>
                        <td>${data.receipt.code || '-'}</td>
                        <td>${data.receipt.status}</td>
                    </tr>`
                    );
                }
                
            

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    if (!!jqXHR.responseJSON.errors) {
                        $("#alert")
                            .addClass("alert-danger")
                            .removeClass("d-none")
                            .removeClass("alert-success");
                        $("#alert-heading").text(jqXHR.responseJSON.message);

                        let error_text = "";
                        for (const [key, value] of Object.entries(
                            jqXHR.responseJSON.errors
                        )) {
                            error_text += `${key}: ${value}\n`;
                        }

                        $("#alert-content").text(error_text);
                    }

                    if (jqXHR.status === 401 || jqXHR.status === 403) {
                        location.href = "{{route('login')}}"
                    }

                    console.error(textStatus, errorThrown);
                    console.error(jqXHR.responseJSON.errors);
                },
            });

            setTimeout(() => {
                            $("#alert")
                            .addClass("d-none")
                        }, 2000);
    });
});
    </script>

</body>
</html>
