<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Kandidat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        /* Add any custom CSS here */
        .main-content {
            padding: 20px;
        }
        .table img {
            max-width: 60px;
            height: auto;
        }
    </style>
</head>
<body>
    @include('sidebar') {{-- Assuming 'sidebar' contains your sidebar HTML --}}

    <div class="main-content">
        <h2 class="mb-4">Daftar Kandidat</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createModal">+ Tambah
            Kandidat</button>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>Nama</th>
                    <th>Foto</th>
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
                    <th>Visi</th>
                    <th>Misi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($candidates as $index => $candidate)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $candidate->name }}</td>
                        <td>
                            @if ($candidate->photo)
                                <img src="{{ asset('storage/' . $candidate->photo) }}" width="60">
                            @else
                                <img src="{{ asset('storage/photos/default.jpg') }}" width="60">
                            @endif
                        </td>
                        <td>{{ $candidate->election->name ?? '-' }}</td>
                        <td>{{ Str::limit($candidate->vision, 50) }}</td>
                        <td>{{ Str::limit($candidate->mission, 50) }}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                data-bs-target="#editModal{{ $candidate->id }}">Edit</button>

                            <form action="{{ route('candidates.destroy', $candidate->id) }}" method="POST"
                                style="display:inline;" onsubmit="return confirm('Yakin hapus?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Belum ada kandidat</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $candidates->links() }}

        @foreach ($candidates as $candidate)
            <div class="modal fade" id="editModal{{ $candidate->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <form action="{{ route('candidates.update', $candidate->id) }}" method="POST"
                        class="modal-content" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Kandidat</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-2">
                                <label>Nama</label>
                                <input type="text" name="name" class="form-control"
                                    value="{{ $candidate->name }}" required>
                            </div>
                            <div class="mb-2">
                                <label>Foto</label>
                                <input type="file" name="photo" class="form-control" accept="image/*">
                            </div>
                            <div class="mb-2">
                                <label>Pemilihan</label>
                                <select name="election_id" class="form-control" required>
                                    @foreach ($elections as $election)
                                        <option value="{{ $election->id }}"
                                            {{ $candidate->election_id == $election->id ? 'selected' : '' }}>
                                            {{ $election->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-2">
                                <label>Visi</label>
                                <textarea name="vision" class="form-control">{{ $candidate->vision }}</textarea>
                            </div>
                            <div class="mb-2">
                                <label>Misi</label>
                                <textarea name="mission" class="form-control">{{ $candidate->mission }}</textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary" type="submit">Simpan</button>
                            <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    <div class="modal fade" id="createModal" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('candidates.store') }}" method="POST" class="modal-content"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kandidat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label>Nama</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label>Foto</label>
                        <input type="file" name="photo" class="form-control" accept="image/*">
                    </div>
                    <div class="mb-2">
                        <label>Pemilihan</label>
                        <select name="election_id" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            @foreach ($elections as $election)
                                <option value="{{ $election->id }}">{{ $election->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2">
                        <label>Visi</label>
                        <textarea name="vision" class="form-control"></textarea>
                    </div>
                    <div class="mb-2">
                        <label>Misi</label>
                        <textarea name="mission" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit">Simpan</button>
                    <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Batal</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>