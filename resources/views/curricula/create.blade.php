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
                    <h5 class="mb-0">Tambah Kurikulum Pelatihan</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('curricula.store', $document_id) }}" method="POST" id="formSubmit">
                        @csrf

                        <!-- Row 1: Pilih Kelompok -->
                        <div class="row mb-4">
                            <div class="col-12 mt-1">
                                <label class="mb-2">Kelompok <span class="text-danger">*</span></label>
                                <select name="kelompok" id="kelompok"
                                    class="form-select @error('kelompok') is-invalid @enderror">
                                    <option value="">-- Pilih Kelompok --</option>
                                    <option value="inti" {{ old('kelompok') === 'inti' ? 'selected' : '' }}>
                                        I. Inti
                                    </option>
                                    <option value="penunjang" {{ old('kelompok') === 'penunjang' ? 'selected' : '' }}>
                                        II. Penunjang
                                    </option>
                                    <option value="ojt" {{ old('kelompok') === 'ojt' ? 'selected' : '' }}>
                                        III. On the Job Training (OJT)
                                    </option>
                                </select>
                                @error('kelompok')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <!-- Section Inti & Penunjang (All Units) -->
                        <div id="section-inti-penunjang" style="display: none;">
                            <div class="table-responsive mb-3">
                                <table class="table table-bordered align-middle mb-0 table-sm">
                                    <thead class="bg-light">
                                        <tr>
                                            <th width="3%">#</th>
                                            <th width="37%">Unit Kompetensi</th>
                                            <th width="20%" class="text-center">Teori (JP)</th>
                                            <th width="20%" class="text-center">Praktek (JP)</th>
                                            <th width="20%" class="text-center">Jumlah (JP)</th>
                                        </tr>
                                    </thead>
                                    <tbody id="unitsTableBody">
                                        <!-- Units will be populated here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Section OJT -->
                        <div id="section-ojt" style="display: none;">
                            <div class="row mb-3">
                                <div class="col-12 mt-1">
                                    <label class="mb-2">Durasi OJT (Bulan) <span class="text-danger">*</span></label>
                                    <input type="text" name="ojt_bulan" id="ojt_bulan"
                                        class="form-control @error('ojt_bulan') is-invalid @enderror"
                                        placeholder="Contoh: 1 Bulan, 2 Bulan, dll" value="{{ old('ojt_bulan') }}">
                                    @error('ojt_bulan')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Button Submit & Back -->
                        <div class="row mt-0 text-end ">
                            <div class="col-12">

                                <a href="{{ route('curricula.index', $document_id) }}" wire:navigate
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
        const allCodes = @json($allCompetenceCodes);
        const usedCodesByKelompok = @json($usedCodesByKelompok);

        function populateUnitsTable(selectedKelompok) {
            const tbody = document.getElementById('unitsTableBody');
            tbody.innerHTML = '';

            const used = usedCodesByKelompok[selectedKelompok] || [];
            const usedIds = used.map(u => typeof u === 'object' ? u.id : u);

            const availableCodes = allCodes.filter(code => !usedIds.includes(code.id));

            availableCodes.forEach((code, index) => {
                const rowHtml = `
                <tr>
                    <td class="text-center">${index + 1}</td>
                    <td>
                        <strong>${code.kode}</strong><br>
                        <small class="text-muted">${code.unit}</small>
                    </td>
                    <td>
                        <input type="hidden" name="items[${code.id}][urutan]" value="${index + 1}">
                        <input type="number" name="items[${code.id}][perkiraan_waktu_teori]" 
                               class="form-control form-control-sm jp-teori" 
                               placeholder="0" value="0" min="0" data-code-id="${code.id}">
                    </td>
                    <td>
                        <input type="number" name="items[${code.id}][perkiraan_waktu_praktek]" 
                               class="form-control form-control-sm jp-praktek" 
                               placeholder="0" value="0" min="0" data-code-id="${code.id}">
                    </td>
                    <td class="text-center">
                        <span class="jumlah-jp">0</span>
                    </td>
                </tr>
            `;
                tbody.insertAdjacentHTML('beforeend', rowHtml);
            });

            // Add event listeners for auto-calculate jumlah
            setupJumlahCalculation();
        }

        function setupJumlahCalculation() {
            const teoriInputs = document.querySelectorAll('.jp-teori');
            const praktekInputs = document.querySelectorAll('.jp-praktek');

            [...teoriInputs, ...praktekInputs].forEach(input => {
                input.addEventListener('change', function() {
                    const row = this.closest('tr');
                    const teori = parseInt(row.querySelector('.jp-teori').value) || 0;
                    const praktek = parseInt(row.querySelector('.jp-praktek').value) || 0;
                    const jumlah = teori + praktek;
                    row.querySelector('.jumlah-jp').textContent = jumlah;
                });
            });
        }

        document.getElementById('kelompok').addEventListener('change', function() {
            const sectionIntiPenunjang = document.getElementById('section-inti-penunjang');
            const sectionOjt = document.getElementById('section-ojt');

            if (this.value === 'ojt') {
                sectionIntiPenunjang.style.display = 'none';
                sectionOjt.style.display = 'block';
            } else if (this.value) {
                sectionIntiPenunjang.style.display = 'block';
                sectionOjt.style.display = 'none';
                populateUnitsTable(this.value);
            } else {
                sectionIntiPenunjang.style.display = 'none';
                sectionOjt.style.display = 'none';
            }
        });

        document.getElementById('formSubmit').addEventListener('submit', function() {
            // Sembunyikan tombol submit & kembali
            this.querySelector('.btn-submit').classList.add('d-none');
            this.querySelector('.btn-back').classList.add('d-none');

            // Tampilkan loading
            this.querySelector('.btn-loading').classList.remove('d-none');
        });
    </script>
@endsection
