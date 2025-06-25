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

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>NO</th>
                <th>Token</th>
                <th>
                    Pemilihan
                    <div class="dropdown d-inline">
                        <button class="btn btn-link btn-sm p-0" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false" title="Filter Pemilihan">
                            <i class="bi bi-chevron-down"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item {{ request('election_id') == '' ? 'active' : '' }}"
                                    href="{{ request()->fullUrlWithQuery(['election_id' => null]) }}">
                                    Semua
                                </a>
                            </li>
                            @foreach ($elections as $election)
                                <li>
                                    <a class="dropdown-item {{ request('election_id') == $election->id ? 'active' : '' }}"
                                        href="{{ request()->fullUrlWithQuery(['election_id' => $election->id]) }}">
                                        {{ $election->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </th>
                <th class="text-center" style="width: 120px;">
                    Status
                    <div class="dropdown d-inline">
                        <button class="btn btn-link btn-sm p-0" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false" title="Filter Status">
                            <i class="bi bi-chevron-down"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item {{ request('status') == '' ? 'active' : '' }}"
                                    href="{{ request()->fullUrlWithQuery(['status' => null]) }}">
                                    Semua
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ request('status') == 'used' ? 'active' : '' }}"
                                    href="{{ request()->fullUrlWithQuery(['status' => 'used']) }}">
                                    Digunakan
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ request('status') == 'unused' ? 'active' : '' }}"
                                    href="{{ request()->fullUrlWithQuery(['status' => 'unused']) }}">
                                    Belum
                                </a>
                            </li>
                        </ul>
                    </div>
                </th>
                <th>Waktu Vote</th>
                <th>Kandidat Dipilih</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($voters as $index => $voter)
                <tr>
                    <td>{{ $index + 1 }}</td>
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
                    <td>
                        <form action="{{ route('tokens.destroy', $voter->id) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('Hapus token ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">Belum ada token</td>
                </tr>
            @endforelse
        </tbody>

    </table>
    {{ $voters->links() }}
</div>
