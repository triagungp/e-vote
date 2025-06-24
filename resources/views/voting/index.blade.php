<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Voting</title>
    <link rel="icon" type="image/png" href="{{ asset('icon.png') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex align-items-center justify-content-center pt-5">
    <div class="container">
        <div class="d-flex justify-content-end mb-3">
            <form action="{{ route('logout') }}" method="GET">
                <button type="submit" class="btn btn-danger btn-sm">Keluar</button>
            </form>
        </div>
        <h2 class="text-center mb-4">Silakan Pilih Kandidat {{ $election->name }}</h2>

        @if (session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger text-center">{{ session('error') }}</div>
        @endif

        <div class="row justify-content-center">
            @foreach ($candidates as $candidate)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm p-4" style="width: 100%; max-width: 400px; height: 100%;">
                        <h2 class="text-center mb-4">{{ $candidate->name }}</h2>
                        <form class="form-vote" method="POST" action="{{ route('voting.vote', $candidate->id) }}">
                            @csrf
                            <div class="text-center">
                                <a href="#" data-bs-toggle="modal"
                                    data-bs-target="#modalDetail{{ $candidate->id }}">
                                    <img src="{{ asset('storage/' . $candidate->photo) }}" class="rounded shadow-sm"
                                        alt="Foto Kandidat"
                                        style="max-height: 180px; max-width: 100%; object-fit: contain; cursor: pointer;">
                                </a>
                            </div>

                            <br>
                            <button class="btn btn-primary d-block mx-auto" type="submit"
                                {{ $voter->used ? 'disabled' : '' }}>
                                <i class="fa fa-lock"></i> Vote
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
            @foreach ($candidates as $candidate)
                <!-- Modal Detail Kandidat -->
                <div class="modal fade" id="modalDetail{{ $candidate->id }}" tabindex="-1"
                    aria-labelledby="modalLabel{{ $candidate->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalLabel{{ $candidate->id }}">{{ $candidate->name }}
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Tutup"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-5 text-center mb-3">
                                        <img src="{{ asset('storage/' . $candidate->photo) }}"
                                            alt="Foto {{ $candidate->name }}" class="img-fluid rounded shadow"
                                            style="max-height: 300px; object-fit: contain;">
                                    </div>
                                    <div class="col-md-7">
                                        <h5>Visi</h5>
                                        <p>{{ $candidate->vision ?? '-' }}</p>
                                        <h5>Misi</h5>
                                        <p>{!! nl2br(e($candidate->mission ?? '-')) !!}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <form method="POST" action="{{ route('voting.vote', $candidate->id) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-primary"
                                        {{ $voter->used ? 'disabled' : '' }}>
                                        <i class="fa fa-check"></i> Vote
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
