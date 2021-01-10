<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{asset('css/app.css')}}" rel="stylesheet">
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>Cadastro de Produtos</title>
</head>
<body>
    <div class="container">
        @component('navbar', ['current' => $current])            
        @endcomponent
        <main role="main">
            @hasSection ('body')
                @yield('body')   
            @endif
        </main>
    </div>
    <script src="{{asset('js/app.js')}}" type="javascript"></script>
    <script src="{{asset('js/bootstrap.bundle.min.js')}}" type="javascript"></script>
</body>
</html>