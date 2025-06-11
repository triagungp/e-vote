@include('sidebar')

<body>
    <div class="main-content">

        <h2 class="mb-4">Daftar Pemilihan</h2>

        <!-- Button Tambah -->
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createModal">+ Tambah
            Pemilihan</button>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Deskripsi</th>
                    <th>Waktu Mulai</th>
                    <th>Waktu Selesai</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($elections as $election)
                    <tr>
                        <td>{{ $election->id }}</td>
                        <td>{{ $election->name }}</td>
                        <td>{{ $election->description }}</td>
                        <td>{{ \Carbon\Carbon::parse($election->start_time)->format('d-m-Y H:i:s') }}</td>
                        <td>{{ \Carbon\Carbon::parse($election->end_time)->format('d-m-Y H:i:s') }}</td>

                        <td>
                            <!-- Edit -->
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                data-bs-target="#editModal{{ $election->id }}">Edit</button>

                            <!-- Hapus -->
                            <form action="{{ route('elections.destroy', $election->id) }}" method="POST"
                                class="d-inline" onsubmit="return confirm('Hapus pemilihan ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    

                    <!-- Modal Edit -->
                    <div class="modal fade" id="editModal{{ $election->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <form method="POST" action="{{ route('elections.update', $election->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Pemilihan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="text" name="name" class="form-control mb-2"
                                            placeholder="Nama" value="{{ $election->name }}" required>
                                        <textarea name="description" class="form-control mb-2" placeholder="Deskripsi">{{ $election->description }}</textarea>
                                        <input type="datetime-local" name="start_time" class="form-control mb-2"
                                            value="{{ \Carbon\Carbon::parse($election->start_time)->format('Y-m-d\TH:i') }}"
                                            required>
                                        <input type="datetime-local" name="end_time" class="form-control"
                                            value="{{ \Carbon\Carbon::parse($election->end_time)->format('Y-m-d\TH:i') }}"
                                            required>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">Belum ada pemilihan</td>
                    </tr>     
                @endforelse
            </tbody>
        </table>

        <!-- Modal Tambah -->
        <div class="modal fade" id="createModal" tabindex="-1">
            <div class="modal-dialog">
                <form method="POST" action="{{ route('elections.store') }}">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Pemilihan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <input type="text" name="name" class="form-control mb-2" placeholder="Nama" required>
                            <textarea name="description" class="form-control mb-2" placeholder="Deskripsi"></textarea>
                            <input type="datetime-local" name="start_time" class="form-control mb-2" required>
                            <input type="datetime-local" name="end_time" class="form-control" required>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
