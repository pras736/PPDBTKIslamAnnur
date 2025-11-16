@extends('layouts.app')

@section('title', 'Edit Kelas')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Edit Data Kelas</h2>
            <a href="{{ route('admin.kelas.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-brand text-white">
                <h5 class="mb-0">Form Edit Kelas</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.kelas.update', $kelas->id_kelas) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nama_kelas" class="form-label">Nama Kelas <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_kelas') is-invalid @enderror" id="nama_kelas" name="nama_kelas" value="{{ old('nama_kelas', $kelas->nama_kelas) }}" required>
                            @error('nama_kelas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="id_guru" class="form-label">Wali Kelas (Guru)</label>
                            <select class="form-select @error('id_guru') is-invalid @enderror" id="id_guru" name="id_guru">
                                <option value="">Pilih Guru (Opsional)</option>
                                @foreach($gurus as $guru)
                                    <option value="{{ $guru->id_guru }}" {{ old('id_guru', $kelas->id_guru) == $guru->id_guru ? 'selected' : '' }}>
                                        {{ $guru->akun->username ?? '-' }} - {{ $guru->NIP }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_guru')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nama_guru" class="form-label">Nama Guru</label>
                            <input type="text" class="form-control @error('nama_guru') is-invalid @enderror" id="nama_guru" name="nama_guru" value="{{ old('nama_guru', $kelas->nama_guru) }}" placeholder="Opsional">
                            @error('nama_guru')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Jika tidak memilih wali kelas, isi manual nama guru</small>
                        </div>
                    </div>

                    @if($kelas->murids->count() > 0)
                        <div class="alert alert-info">
                            <strong>Info:</strong> Kelas ini memiliki {{ $kelas->murids->count() }} murid.
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-brand">Update</button>
                            <a href="{{ route('admin.kelas.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-brand text-white">
                <h5 class="mb-0">Manajemen Murid di Kelas</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Murid di Kelas Ini ({{ $kelas->murids->count() }})</h6>
                        @if($kelas->murids->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-sm table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Lengkap</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($kelas->murids as $index => $murid)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $murid->nama_lengkap }}</td>
                                                <td>
                                                    <span class="badge {{ $murid->status_siswa === 'terdaftar' ? 'bg-success' : 'bg-warning' }}">
                                                        {{ ucfirst($murid->status_siswa) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <form action="{{ route('admin.kelas.removeMurid', [$kelas->id_kelas, $murid->id_murid]) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus murid dari kelas ini?')">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            <i class="bi bi-x-circle"></i> Keluarkan
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted">Belum ada murid di kelas ini.</p>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <h6>Tambah Murid ke Kelas</h6>
                        <form action="{{ route('admin.kelas.assignMurid', $kelas->id_kelas) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Cari Murid Terdaftar (belum ada kelas):</label>
                                <div class="input-group mb-2">
                                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                                    <input type="text" 
                                           id="searchMurid" 
                                           class="form-control" 
                                           placeholder="Cari nama murid..." 
                                           onkeyup="filterMurid()"
                                           oninput="filterMurid()">
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <small class="text-info">
                                        <strong>Total:</strong> <span id="totalMurid">{{ $muridsTerdaftar->whereNull('id_kelas')->count() }}</span> | 
                                        <strong>Tampil:</strong> <span id="filteredCount">{{ $muridsTerdaftar->whereNull('id_kelas')->count() }}</span>
                                    </small>
                                    @if($muridsTerdaftar->whereNull('id_kelas')->count() > 0)
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-secondary" 
                                                onclick="selectAllVisible()"
                                                title="Pilih semua murid yang ditampilkan">
                                            <i class="bi bi-check-all"></i> Pilih Semua
                                        </button>
                                    @endif
                                </div>
                                <select name="murid_ids[]" id="muridSelect" class="form-select" multiple size="10" required>
                                    @foreach($muridsTerdaftar->whereNull('id_kelas') as $murid)
                                        <option value="{{ $murid->id_murid }}" 
                                                data-nama="{{ strtolower($murid->nama_lengkap) }}" 
                                                data-nisn="{{ strtolower($murid->nisn ?? '') }}">
                                            {{ $murid->nama_lengkap }} 
                                            @if($murid->nisn) - {{ $murid->nisn }} @endif
                                            ({{ $murid->status_siswa }})
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted d-block mt-2">
                                    <i class="bi bi-info-circle"></i> Tekan <strong>Ctrl</strong> (atau <strong>Cmd</strong> di Mac) untuk memilih beberapa murid
                                </small>
                                @if($muridsTerdaftar->whereNull('id_kelas')->count() > 0)
                                    <div class="mt-2">
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-danger" 
                                                onclick="deselectAll()"
                                                title="Batalkan semua pilihan">
                                            <i class="bi bi-x-circle"></i> Batal Pilih Semua
                                        </button>
                                    </div>
                                @endif
                            </div>
                            @if($muridsTerdaftar->whereNull('id_kelas')->count() > 0)
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-plus-circle"></i> Tambah ke Kelas
                                </button>
                            @else
                                <p class="text-muted">Tidak ada murid terdaftar yang belum memiliki kelas.</p>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function filterMurid() {
    const searchInput = document.getElementById('searchMurid');
    const searchTerm = searchInput.value.toLowerCase().trim();
    const select = document.getElementById('muridSelect');
    const options = select.querySelectorAll('option');
    let visibleCount = 0;

    options.forEach(option => {
        const nama = option.getAttribute('data-nama') || '';
        const text = option.textContent.toLowerCase();
        
        // Cari di nama atau seluruh teks
        if (searchTerm === '' || 
            nama.includes(searchTerm) || 
            text.includes(searchTerm)) {
            option.style.display = '';
            visibleCount++;
        } else {
            option.style.display = 'none';
        }
    });

    // Update counter
    document.getElementById('filteredCount').textContent = visibleCount;
    
    // Highlight jika tidak ada hasil
    if (visibleCount === 0 && searchTerm !== '') {
        searchInput.classList.add('is-invalid');
    } else {
        searchInput.classList.remove('is-invalid');
    }
}

function selectAllVisible() {
    const select = document.getElementById('muridSelect');
    const options = select.querySelectorAll('option');
    let selectedCount = 0;
    
    options.forEach(option => {
        if (option.style.display !== 'none') {
            option.selected = true;
            selectedCount++;
        }
    });
    
    // Show feedback
    if (selectedCount > 0) {
        const btn = event.target;
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="bi bi-check-circle-fill"></i> ' + selectedCount + ' Dipilih!';
        btn.classList.add('btn-success');
        btn.classList.remove('btn-outline-secondary');
        
        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.classList.remove('btn-success');
            btn.classList.add('btn-outline-secondary');
        }, 2000);
    }
}

function deselectAll() {
    const select = document.getElementById('muridSelect');
    const options = select.querySelectorAll('option');
    
    options.forEach(option => {
        option.selected = false;
    });
    
    // Clear search
    document.getElementById('searchMurid').value = '';
    filterMurid();
}

// Clear search on form submit (optional)
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[action*="assignMurid"]');
    if (form) {
        form.addEventListener('submit', function() {
            // Optionally clear search
            // document.getElementById('searchMurid').value = '';
        });
    }
});
</script>
@endsection

