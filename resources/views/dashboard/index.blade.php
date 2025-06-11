@include('sidebar')

<div class="main-content">

    <h1 class="mb-4">Hasil Voting</h1>
    <form method="GET" class="mb-3">
        <label for="electionFilter">Filter Pemilihan</label>
        <select name="election_id" id="electionFilter" class="form-control" onchange="this.form.submit()">
            <option value="">-- Pilih --</option>
            @foreach ($elections as $election)
                <option value="{{ $election->id }}" {{ request('election_id') == $election->id ? 'selected' : '' }}>
                    {{ $election->name }}
                </option>
            @endforeach
        </select>
    </form>

    @foreach ($elections as $election)
        <div class="card mb-4">
            <div class="card-header">
                <h4>{{ $election->name }}</h4>
                <small>
                    Periode:
                    {{ \Carbon\Carbon::parse($election->start_time)->format('d-m-Y H:i:s') }}
                    s/d
                    {{ \Carbon\Carbon::parse($election->end_time)->format('d-m-Y H:i:s') }}
                </small>

            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama Kandidat</th>
                            <th>Jumlah Suara</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tbody>
                        @foreach ($election->candidates->sortByDesc(fn($c) => $c->votes->count()) as $candidate)
                            <tr>
                                <td>{{ $candidate->name }}</td>
                                <td>{{ $candidate->votes->count() }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
</div>
