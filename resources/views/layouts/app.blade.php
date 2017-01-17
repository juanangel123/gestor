<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gestor</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/datatables/datatables.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/vex/vex.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/vex/vex-theme-plain.css') }}" />

    <link href="{{ url(elixir('css/app.css')) }}" rel="stylesheet">
</head>
<body id="app-layout">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    Gestor
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/') }}">Clientes</a></li>
                    <li><a href="{{ url('/contracts') }}">Contratos</a></li>
                    <li><a href="{{ url('/supplier-companies') }}">Empresas suministradoras</a></li>
                    <li><a href="{{ url('/alerts') }}">Alertas</a></li>
                </ul>
            </div>
        </div>
    </nav>


    <!-- Content -->
    @yield('content')


    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-xs-9">
                    <p class="text-muted">&copy; {{ date('Y') }} Juan Ángel Espigares Marín - <a href="http://twitter.com/john_angelical" target="_blank">Twitter</a></p>
                </div>

                <div class="col-xs-3">
                    <p class="text-muted text-right version">
                        v1.0
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScripts -->
    <!-- This datatables build comes with jquery and bootstrap pre-built (no additional resources needed) -->
    <script type="text/javascript" src="{{ asset('vendor/datatables/datatables.min.js') }}"></script>
    <!-- Date eu sorting plugin -->
    <script type="text/javascript" src="{{ asset('vendor/datatables/date-eu.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/vex/vex.combined.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/dropzonejs/dropzonejs.min.js') }}"></script>


    <script src="{{ asset('js/App.js') }}"></script>
</body>
</html>
