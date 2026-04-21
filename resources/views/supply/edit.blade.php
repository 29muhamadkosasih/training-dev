@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-lg-12">
            <!-- Alert -->
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <div class="d-flex">
                        <div>
                            <h4 class="alert-title">Terdapat Kesalahan</h4>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                </div>
            @endif

            <!-- Card Form -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Edit Daftar Perlangkapan yang dibutuhkan</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('supplys.update', ['document_id' => $document_id, 'id' => $supply->id]) }}"
                        method="POST" id="formSubmit">
                        @csrf
                        @method('PUT')

                        <!-- Row: Info Pelatihan -->
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3">
                                <label class="mb-2">Judul/Nama Pelatihan</label>
                                <input type="text" class="form-control"
                                    value="{{ $dataDocument->competence->scheme->name ?? '' }}" disabled>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="mb-2">Perkiraan Waktu Pelatihan </label>
                                <input type="text" name="perkiraan_waktu_pelatihan"
                                    class="form-control @error('perkiraan_waktu_pelatihan') is-invalid @enderror"
                                    placeholder="20 JP @45 menit "
                                    value="{{ old('perkiraan_waktu_pelatihan', $supply->perkiraan_waktu_pelatihan) }}">
                                @error('perkiraan_waktu_pelatihan')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="mb-2">Jumlah Peserta </label>
                                <input type="text" name="jumlah_peserta"
                                    class="form-control @error('jumlah_peserta') is-invalid @enderror"
                                    placeholder="10 Orang (1 Batch)"
                                    value="{{ old('jumlah_peserta', $supply->jumlah_peserta) }}">
                                @error('jumlah_peserta')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="mb-2">Metode Pelatihan </label>
                                <input type="text" name="metode_pelatihan"
                                    class="form-control @error('metode_pelatihan') is-invalid @enderror"
                                    placeholder="Mis: Luring / Daring / Bauran"
                                    value="{{ old('metode_pelatihan', $supply->metode_pelatihan) }}">
                                @error('metode_pelatihan')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <!-- Detail -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="mb-0">Detail Perlangkapan yang dibutuhkan</h5>
                                    <button type="button" class="btn btn-sm btn-success" id="addItemBtn">Tambah Baris
                                    </button>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="supplyTable">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="width: 5%;">No</th>
                                                <th>Nama Daftar Bahan</th>
                                                <th>Spesifikasi</th>
                                                <th style="width: 15%;">Satuan</th>
                                                <th style="width: 10%;">Jumlah</th>
                                                <th style="width: 8%;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="itemsContainer">
                                            @forelse ($supplyDetails as $index => $detail)
                                                <tr class="item-row">
                                                    <td class="row-number">{{ $index + 1 }}</td>
                                                    <td>
                                                        <input type="text"
                                                            name="items[{{ $index }}][nama_peralatan]"
                                                            class="form-control @error('items.' . $index . '.nama_peralatan') is-invalid @enderror"
                                                            value="{{ old('items.' . $index . '.nama_peralatan', $detail->nama_peralatan) }}"
                                                            placeholder="Nama Bahan/Barang" required>
                                                        @error('items.' . $index . '.nama_peralatan')
                                                            <small class="text-danger d-block">{{ $message }}</small>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <input type="text"
                                                            name="items[{{ $index }}][spesifikasi]"
                                                            class="form-control @error('items.' . $index . '.spesifikasi') is-invalid @enderror"
                                                            value="{{ old('items.' . $index . '.spesifikasi', $detail->spesifikasi) }}"
                                                            placeholder="Spesifikasi" required>
                                                        @error('items.' . $index . '.spesifikasi')
                                                            <small class="text-danger d-block">{{ $message }}</small>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <input type="text" name="items[{{ $index }}][satuan]"
                                                            class="form-control @error('items.' . $index . '.satuan') is-invalid @enderror"
                                                            value="{{ old('items.' . $index . '.satuan', $detail->satuan) }}"
                                                            placeholder="Satuan" required>
                                                        @error('items.' . $index . '.satuan')
                                                            <small class="text-danger d-block">{{ $message }}</small>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <input type="number" name="items[{{ $index }}][jumlah]"
                                                            class="form-control @error('items.' . $index . '.jumlah') is-invalid @enderror"
                                                            value="{{ old('items.' . $index . '.jumlah', $detail->jumlah) }}"
                                                            min="1" placeholder="Jumlah" required>
                                                        @error('items.' . $index . '.jumlah')
                                                            <small class="text-danger d-block">{{ $message }}</small>
                                                        @enderror
                                                    </td>
                                                    <td style="width: 8%; text-align: center;">
                                                        <button type="button"
                                                            class="btn btn-sm btn-icon btn-danger remove-item"
                                                            style="display:{{ count($supplyDetails) > 1 ? 'inline-block' : 'none' }};">
                                                            <i class="ti ti-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr class="item-row">
                                                    <td class="row-number">1</td>
                                                    <td>
                                                        <input type="text" name="items[0][nama_peralatan]"
                                                            class="form-control @error('items.0.nama_peralatan') is-invalid @enderror"
                                                            value="{{ old('items.0.nama_peralatan') }}"
                                                            placeholder="Nama Bahan/Barang" required>
                                                        @error('items.0.nama_peralatan')
                                                            <small class="text-danger d-block">{{ $message }}</small>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <input type="text" name="items[0][spesifikasi]"
                                                            class="form-control @error('items.0.spesifikasi') is-invalid @enderror"
                                                            value="{{ old('items.0.spesifikasi') }}"
                                                            placeholder="Spesifikasi" required>
                                                        @error('items.0.spesifikasi')
                                                            <small class="text-danger d-block">{{ $message }}</small>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <input type="text" name="items[0][satuan]"
                                                            class="form-control @error('items.0.satuan') is-invalid @enderror"
                                                            value="{{ old('items.0.satuan') }}" placeholder="Satuan"
                                                            required>
                                                        @error('items.0.satuan')
                                                            <small class="text-danger d-block">{{ $message }}</small>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <input type="number" name="items[0][jumlah]"
                                                            class="form-control @error('items.0.jumlah') is-invalid @enderror"
                                                            value="{{ old('items.0.jumlah') }}" min="1"
                                                            placeholder="Jumlah" required>
                                                        @error('items.0.jumlah')
                                                            <small class="text-danger d-block">{{ $message }}</small>
                                                        @enderror
                                                    </td>
                                                    <td style="width: 8%; text-align: center;">
                                                        <button type="button"
                                                            class="btn btn-sm btn-icon btn-danger remove-item"
                                                            style="display:none;">
                                                            <i class="ti ti-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Button Submit & Back -->
                        <div class="row mt-0 text-end ">
                            <div class="col-12">

                                <a href="{{ route('supplys.index', $document_id) }}"
                                    class="btn btn-secondary me-2 btn-back">Kembali
                                </a>
                                <button type="submit" class="btn btn-primary btn-submit">Simpan
                                </button>

                                <button class="btn btn-primary btn-loading d-none" type="button" disabled>
                                    <span class="spinner-grow spinner-grow-sm"></span>
                                    <span class="ms-1">Loading...</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        let itemCount = {{ count($supplyDetails) }};

        // Add new row
        document.getElementById('addItemBtn').addEventListener('click', function() {
            const container = document.getElementById('itemsContainer');
            const newRow = document.createElement('tr');
            newRow.className = 'item-row';
            newRow.innerHTML = `
                <td class="row-number">${itemCount + 1}</td>
                <td>
                    <input type="text" name="items[${itemCount}][nama_peralatan]"  placeholder="Nama Bahan/Barang"
                        class="form-control" value="" required>
                </td>
                <td>
                    <input type="text" name="items[${itemCount}][spesifikasi]"  placeholder="Spesifikasi"
                        class="form-control" value="" required>
                </td>
                <td>
                    <input type="text" name="items[${itemCount}][satuan]" placeholder="Satuan"
                        class="form-control" value="" required>
                </td>
                <td>
                    <input type="number" name="items[${itemCount}][jumlah]" placeholder="Jumlah"
                        class="form-control" value="" min="1" required>
                </td>
                <td style="width: 8%; text-align: center;">
                    <button type="button" class="btn btn-sm btn-icon btn-danger remove-item">
                        <i class="ti ti-trash"></i>
                    </button>
                </td>
            `;
            container.appendChild(newRow);
            itemCount++;
            updateRowNumbers();
            attachRemoveListener(newRow.querySelector('.remove-item'));
            updateRemoveButtons();
        });

        // Remove row
        function attachRemoveListener(button) {
            button.addEventListener('click', function() {
                this.closest('tr').remove();
                updateRowNumbers();
                updateRemoveButtons();
            });
        }

        // Attach remove listeners to initial rows
        document.querySelectorAll('.remove-item').forEach(button => {
            attachRemoveListener(button);
        });

        // Update row numbers
        function updateRowNumbers() {
            document.querySelectorAll('.row-number').forEach((el, index) => {
                el.textContent = index + 1;
            });
        }

        // Show/hide remove button based on row count
        function updateRemoveButtons() {
            const rows = document.querySelectorAll('.item-row');
            rows.forEach((row, index) => {
                const removeBtn = row.querySelector('.remove-item');
                if (rows.length > 1) {
                    removeBtn.style.display = 'inline-block';
                } else {
                    removeBtn.style.display = 'none';
                }
            });
        }

        // Initialize
        updateRemoveButtons();

        // Form submit
        document.getElementById('formSubmit').addEventListener('submit', function() {
            // Sembunyikan tombol submit & kembali
            this.querySelector('.btn-submit').classList.add('d-none');
            this.querySelector('.btn-back').classList.add('d-none');

            // Tampilkan loading
            this.querySelector('.btn-loading').classList.remove('d-none');
        });
    </script>
@endsection
