@include('sidebar')

<div class="main-content">
    <h2 class="mb-4">Dashboard Hasil Voting</h2>

    <form method="GET" class="mb-3">
        <label for="electionFilter">Filter Pemilihan</label>
        <select name="election_id" id="electionFilter" class="form-control" onchange="this.form.submit()">
            <option value="">-- Pilih --</option>
            @foreach ($elections as $election)
                <option value="{{ $election->id }}"
                    {{ (string) $electionId === (string) $election->id ? 'selected' : '' }}>
                    {{ $election->name }}
                </option>
            @endforeach
        </select>
    </form>
    @if ($elections->isEmpty())
        <div class="alert alert-warning text-center mb-4">
            Belum ada pemilihan.
        </div>
    @endif
    @if ($selectedElection)
        <div class="card mb-4">
            <div class="card-header">
                <h4>{{ $selectedElection->name }}</h4>
                <small>
                    Periode:
                    {{ \Carbon\Carbon::parse($selectedElection->start_time)->format('d-m-Y H:i:s') }}
                    s/d
                    {{ \Carbon\Carbon::parse($selectedElection->end_time)->format('d-m-Y H:i:s') }}
                </small>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kandidat</th>
                            <th>Jumlah Suara</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($selectedElection->candidates->sortByDesc(fn($c) => $c->votes->count()) as $i => $candidate)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $candidate->name }}</td>
                                <td>{{ $candidate->votes->count() }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">Belum ada kandidat</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
