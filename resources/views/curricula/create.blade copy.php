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
                        <div class="row mb-3">
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

                        <!-- Section Inti & Penunjang -->
                        <div id="section-inti-penunjang">
                            <!-- Row 2: Unit Kompetensi -->
                            <div class="row mb-3">
                                <div class="col-12 mt-1">
                                    <label class="mb-2">Unit Kompetensi <span class="text-danger">*</span></label>
                                    <select name="competence_code_id" id="competence_code_id"
                                        class="form-select @error('competence_code_id') is-invalid @enderror">
                                        <option value="">-- Pilih Unit Kompetensi --</option>
                                        @forelse ($allCompetenceCodes as $code)
                                            <option value="{{ $code->id }}" 
                                                data-unit="{{ $code->unit }}"
                                                data-inti="{{ in_array($code->id, $usedCodesByKelompok['inti']) ? 'true' : 'false' }}"
                                                data-penunjang="{{ in_array($code->id, $usedCodesByKelompok['penunjang']) ? 'true' : 'false' }}"
                                                {{ old('competence_code_id') === $code->id ? 'selected' : '' }}>
                                                {{ $code->kode }} - {{ $code->unit }}
                                            </option>
                                        @empty
                                        @endforelse
                                    </select>
                                    @error('competence_code_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <!-- Row 3: JP Teori & Praktek -->
                            <div class="row mb-3">
                                <div class="col-md-6 mt-1">
                                    <label class="mb-2">Perkiraan Waktu Teori (JP) <span
                                            class="text-danger">*</span></label>
                                    <input type="number" name="perkiraan_waktu_teori" id="teori"
                                        class="form-control @error('perkiraan_waktu_teori') is-invalid @enderror"
                                        placeholder="Masukkan jam pelajaran" value="{{ old('perkiraan_waktu_teori') }}"
                                        min="0">
                                    @error('perkiraan_waktu_teori')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6 mt-1">
                                    <label class="mb-2">Perkiraan Waktu Praktek (JP) <span
                                            class="text-danger">*</span></label>
                                    <input type="number" name="perkiraan_waktu_praktek" id="praktek"
                                        class="form-control @error('perkiraan_waktu_praktek') is-invalid @enderror"
                                        placeholder="Masukkan jam pelajaran" value="{{ old('perkiraan_waktu_praktek') }}"
                                        min="0">
                                    @error('perkiraan_waktu_praktek')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
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
                        <div class="row mt-0 text-end">
                            <div class="col-12">
                                <a href="{{ route('curricula.index', $document_id) }}" class="btn btn-back btn-secondary me-2"
                                    wire:navigate>Kembali
                                </a>
                                <button type="submit" class="btn btn-primary btn-submit"> Simpan
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
        document.getElementById('kelompok').addEventListener('change', function() {
            const sectionIntiPenunjang = document.getElementById('section-inti-penunjang');
            const sectionOjt = document.getElementById('section-ojt');
            const selectedKelompok = this.value;
            const options = document.querySelectorAll('#competence_code_id option:not(:first-child)');

            if (this.value === 'ojt') {
                sectionIntiPenunjang.style.display = 'none';
                sectionOjt.style.display = 'block';
            } else {
                sectionIntiPenunjang.style.display = 'block';
                sectionOjt.style.display = 'none';

                // Filter options based on kelompok
                options.forEach(option => {
                    const isUsed = option.dataset[selectedKelompok] === 'true';
                    option.hidden = isUsed;
                });

                // Reset selection if current selected is hidden
                const currentSelect = document.getElementById('competence_code_id');
                if (currentSelect.options[currentSelect.selectedIndex].hidden) {
                    currentSelect.value = '';
                }
            }
        });

        document.getElementById('formSubmit').addEventListener('submit', function() {
            // Sembunyikan tombol submit & kembali
            this.querySelector('.btn-submit').classList.add('d-none');
            this.querySelector('.btn-back').classList.add('d-none');

            // Tampilkan loading
            this.querySelector('.btn-loading').classList.remove('d-none');
        });

        // Trigger on page load
        document.getElementById('kelompok').dispatchEvent(new Event('change'));
    </script>
@endsection
