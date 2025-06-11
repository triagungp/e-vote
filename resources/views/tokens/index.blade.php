@include('sidebar')

<div class="main-content">
    <h2>Manajemen Token</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('tokens.generate') }}" method="POST" class="row g-3 mb-4">
        @csrf
        <div class="col-md-5">
            <label>Pilih Pemilihan</label>
            <select name="election_id" class="form-control" required>
                <option value="">-- Pilih --</option>
                @foreach ($elections as $election)
                    <option value="{{ $election->id }}">{{ $election->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label>Jumlah Token</label>
            <input type="number" name="jumlah" class="form-control" min="1" max="500" required>
        </div>
        <div class="col-md-4 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100">Generate Token</button>
        </div>
    </form>

    <form method="GET" class="mb-3">
        <label>Filter Pemilihan</label>
        <select name="election_id" class="form-control" onchange="this.form.submit()">
            <option value="">-- Pilih --</option>
            @foreach ($elections as $election)
                <option value="{{ $election->id }}" {{ $selectedElection == $election->id ? 'selected' : '' }}>
                    {{ $election->name }}
                </option>
            @endforeach
        </select>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Token</th>
                <th>Pemilihan</th>
                <th>Status</th>
                <th>Waktu Vote</th>
                <th>Kandidat Dipilih</th>
            </tr>
        </thead>

        <tbody>
            @forelse($voters as $voter)
                <tr>
                    <td>{{ $voter->id }}</td>
                    <td>{{ $voter->token }}</td>
                    <td>{{ $voter->election->name ?? '-' }}</td>
                    <td>
                        @if ($voter->used)
                            <span class="badge bg-success">Digunakan</span>
                        @else
                            <span class="badge bg-secondary">Belum</span>
                        @endif
                    </td>
                    <td>
                        {{ $voter->voted_at ? \Carbon\Carbon::parse($voter->voted_at)->format('d-m-Y H:i:s') : '-' }}
                    </td>

                    <td>{{ $voter->candidate->name ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">Belum ada token</td>
                </tr>  
            @endforelse
        </tbody>

    </table>

    {{ $voters->withQueryString()->links() }}
</div>
