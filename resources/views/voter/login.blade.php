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

    <div class="card shadow-sm p-4" style="width: 100%; max-width: 400px;">
        <h2 class="text-center mb-4">e-Vote</h2>
        <form class="form-login" method="POST" action="/login">
            @csrf
            <div class="login-wrap">
                <input type="text" class="form-control" name="token" placeholder="Token" autofocus @required(true)>
                <br>
                <button class="btn btn-primary d-block mx-auto" name="proses" type="submit"><i class="fa fa-lock"></i>
                    Submit</button>
            </div>
        </form>
        {{-- <div class="text-center mt-3">
            <a href="/admin">Login sebagai admin</a>
        </div> --}}
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
