<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Form</title>
    <link rel="icon" type="image/png" href="{{ asset('icon.png') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex align-items-center justify-content-center vh-100">
    @if ($errors->any())
        <div class="alert alert-danger text-center">
            {{ $errors->first() }}
        </div>
    @endif
    <div class="card shadow-sm p-4" style="width: 100%; max-width: 400px;">

        <h4 class="text-center mb-4">
            <i class="bi bi-check-circle-fill"></i> e-Vote
        </h4>
        <form method="POST" action="/admin">
            @csrf
            <div class="login-wrap">
                <input type="email" class="form-control" name="email" placeholder="Email" autofocus
                    @required(true)>
                <br>
                <input type="password" class="form-control" name="password" placeholder="Password" @required(true)>
                <br>
                <button class="btn btn-primary d-block mx-auto" name="proses" type="submit"><i class="fa fa-lock"></i>
                    Login</button>
            </div>
            {{-- <div class="text-center mt-3">
                <a href="/login">Login sebagai voter</a>
            </div> --}}
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
