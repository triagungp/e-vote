<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Voter</title>
    <link rel="icon" type="image/png" href="{{ asset('icon.png') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>


<body class="bg-light d-flex align-items-center justify-content-center vh-100"
    style="background: url('{{ asset('background.png') }}') center center fixed; background-size: cover;">

    <div class="card shadow-sm p-4" style="width: 100%; max-width: 400px;">
        <!-- Form Login Token -->
        <div id="form-login-token">
            <h2 class="text-center mb-4">e-Vote</h2>
            <form method="POST" action="/login">
                @csrf
                <div class="login-wrap">
                    <input type="text" class="form-control" name="token" placeholder="Token" autofocus
                        @required(true)>
                    <br>
                    <button class="btn btn-primary d-block mx-auto" name="proses" type="submit"><i
                            class="fa fa-lock"></i>
                        Login</button>
                    {{-- <button type="button" class="btn btn-link d-block mx-auto" id="btn-request-token">Request Token</button> --}}

                </div>
            </form>
        </div>

        <!-- Form Request Token -->
        {{-- <div id="form-request-token" style="display: none;">
            <h2 class="text-center mb-4">Request Token</h2>
            <form method="POST" action="/request-token">
                @csrf
                <div class="mb-3">
                    <input type="email" name="email" id="email" class="form-control" placeholder="Email" autofocus required>
                </div>
                <button type="submit" class="btn btn-success d-block mx-auto">Request Token</button>
                <button type="button" class="btn btn-link d-block mx-auto" id="btn-back-login">Kembali ke Login Token</button>
            </form>
        </div> --}}


    </div>
    {{-- <script>
        document.getElementById('btn-request-token').onclick = function() {
            document.getElementById('form-login-token').style.display = 'none';
            document.getElementById('form-request-token').style.display = 'block';
        };
        document.getElementById('btn-back-login').onclick = function() {
            document.getElementById('form-request-token').style.display = 'none';
            document.getElementById('form-login-token').style.display = 'block';
        };
    </script> --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
