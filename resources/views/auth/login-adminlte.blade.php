<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIM-TUN | Log in</title>
    <!-- Favicons -->
    <link href="{{ asset('media/img/logo-tanjabar.png') }}" rel="icon">
    <link href="{{ asset('media/img/logo-tanjabar.png') }}" rel="apple-touch-icon">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('templates/adminlte') }}/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('templates/adminlte') }}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('templates/adminlte') }}/dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <img src="{{ asset('media/img/logo-tanjabar.png') }}" alt="" width="85px"><br>
            <a href="#" class="h2"><b>SIM-TUN</b></a>
        </div>
        <div class="text-center mb-4 text-bold">DIKBUD KAB. TANJUNG JABUNG BARAT</div>

        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>
                <form id="form" action="{{ url('login/proses') }}" class="needs-validation" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="yourUsername" value="{{ old('email') }}" required placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        <div class="invalid-feedback">Please enter your password!</div>
                    </div>

                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>

                        <div class="col-4">
                            <a href="javascript:void(0)" class="btn btn-primary btn-block btnSubmit">Sign In</a>
                        </div>

                    </div>
                </form>
            </div>

        </div>
    </div>
    <script src="{{ asset('templates/adminlte') }}/plugins/jquery/jquery.min.js"></script>
    <script src="{{ asset('templates/adminlte') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('templates/adminlte') }}/dist/js/adminlte.min.js?v=3.2.0"></script>
    <script>
        $('.btnSubmit').click(function() {
            var remember = $('#remember').is(':checked');
            var uname = $('[name="email"]').val();
            var pass = $('[name="password"]').val();
            if (remember) {
                setCookie('uname', uname, 7);
                setCookie('pass', pass, 7);
            } else {
                clearCookie('uname');
                clearCookie('pass');
            }

            setTimeout(() => {
                $('#form').submit();
            }, 300);
        });


        if (getCookie('uname')) {
            $('#remember').attr('checked', true);
            $('[name="email"]').val(getCookie('uname'));
            $('[name="password"]').val(getCookie('pass'));
        }

        function setCookie(cname, cvalue, exdays) {
            var d = new Date();
            d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
            var expires = "expires=" + d.toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        }

        function getCookie(cname) {
            var name = cname + "=";
            var decodedCookie = decodeURIComponent(document.cookie);
            var ca = decodedCookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }

        function clearCookie(cname) {
            document.cookie = cname + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/";
        }
    </script>


</body>

</html>
