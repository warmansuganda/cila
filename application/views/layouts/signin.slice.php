<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" type="text/css" href="{{ elixir('assets/css/signin.min.css') }}">
    @yield('css')
</head>
<body id="login">
    <div class="row" id="header">
        <div class="col col-md-6 col-sm-6 col-xs-6">
            <img class="logo" src="{{ base_url() }}assets/img/logo_bijb_120.png">
        </div>
        <div class="col col-md-6 col-sm-6 col-xs-6 text-right">
            <div  style="padding-right: 10px;">
                <div class="title">Bandara Internasional Jawa Barat</div>
                <div class="description">
                    Jl. Jendral Gatot Subroto No.10, Malabar, Lengkong, Kota Bandung, Jawa Barat 40262
                    <br> Phone : (022) 09384503 | Email : info@bijb.co.id
                </div>
                <div>
                    <a class="btn btn-social-icon btn-facebook"><i class="fa fa-facebook"></i></a>
                    <a class="btn btn-social-icon btn-twitter"><i class="fa fa-twitter"></i></a>
                    <a class="btn btn-social-icon btn-google"><i class="fa fa-google-plus"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col col-md-8 col-sm-6">
            <img class="img-responsive" src="{{ base_url() }}assets/img/scetch_bijb.jpg">
            <div class="apps-information">
                <h1 class="title">Accounting Application</h1>
                <div class="description">
                    A person consistently looking for ways to improve personal productivity <br>
                    EaglEye will enhance your productivity to a whole new level
                </div>
                <button id="btn-getstarted" type="button" class="btn">Get Started</button>
            </div>
        </div>
        <div class="form-login col col-md-4 col-sm-6">
            @yield('content')
        </div>
    </div>
    <script type="text/javascript" src="{{ elixir('assets/js/signin.min.js') }}"></script>
    <script type="text/javascript">
        NProgress.start();
    </script>
    <script type="text/javascript">
        $(function(){
            NProgress.done();

            $('#btn-getstarted').click(function(){
                $('input[name=username]').focus();
            })
        });
    </script>
    @yield('js')
</body>
</html>