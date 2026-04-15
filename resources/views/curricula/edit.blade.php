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
                    <h5 class="mb-0">Edit Kurikulum Pelatihan</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('curricula.update', [$document_id, $curriculum->id]) }}" method="POST"
                        id="formSubmit">
                        @csrf
                        @method('PUT')

                        <!-- Display Kelompok (Read-only) -->
                        <div class="row mb-4">
                            <div class="col-12 mt-1">
                                <label class="mb-2">Kelompok</label>
                                <div class="form-control-plaintext">
                                    <strong>
                                        @if ($curriculum->kelompok === 'inti')
                                            I. Inti
                                        @elseif($curriculum->kelompok === 'penunjang')
                                            II. Penunjang
                                        @else
                                            III. On the Job Training (OJT)
                                        @endif
                                    </strong>
                                </div>
                                <input type="hidden" name="kelompok" value="{{ $curriculum->kelompok }}">
                            </div>
                        </div>

                        <!-- Display Unit if not OJT -->
                        @if ($curriculum->kelompok !== 'ojt' && $curriculum->competenceCode)
                            <div class="row mb-4">
                                <div class="col-12 mt-1">
                                    <label class="mb-2">Unit Kompetensi</label>
                                    <div class="form-control-plaintext">
                                        <strong>{{ $curriculum->competenceCode->kode }}</strong><br>
                                        <small class="text-muted">{{ $curriculum->competenceCode->unit }}</small>
                                    </div>
                                    <input type="hidden" name="competence_code_id"
                                        value="{{ $curriculum->competence_code_id }}">
                                    <input type="hidden" name="urutan" value="{{ $curriculum->urutan }}">
                                </div>
                            </div>
                        @endif

                        <!-- Form based on Kelompok -->
                        @if ($curriculum->kelompok === 'ojt')
                            <!-- OJT Form -->
                            <div class="row mb-3">
                                <div class="col-12 mt-1">
                                    <label class="mb-2">Durasi OJT (Bulan) <span class="text-danger">*</span></label>
                                    <input type="text" name="ojt_bulan" id="ojt_bulan"
                                        class="form-control @error('ojt_bulan') is-invalid @enderror"
                                        placeholder="Contoh: 1 Bulan, 2 Bulan, dll"
                                        value="{{ old('ojt_bulan', $curriculum->ojt_bulan) }}">
                                    @error('ojt_bulan')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        @else
                            <!-- Inti/Penunjang Form -->
                            <div class="row mb-3">
                                <div class="col-md-6 mt-1">
                                    <label class="mb-2">Perkiraan Waktu Teori (JP) <span
                                            class="text-danger">*</span></label>
                                    <input type="number" name="perkiraan_waktu_teori"
                                        class="form-control @error('perkiraan_waktu_teori') is-invalid @enderror"
                                        placeholder="0"
                                        value="{{ old('perkiraan_waktu_teori', $curriculum->perkiraan_waktu_teori) }}"
                                        min="0">
                                    @error('perkiraan_waktu_teori')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6 mt-1">
                                    <label class="mb-2">Perkiraan Waktu Praktek (JP) <span
                                            class="text-danger">*</span></label>
                                    <input type="number" name="perkiraan_waktu_praktek"
                                        class="form-control @error('perkiraan_waktu_praktek') is-invalid @enderror"
                                        placeholder="0"
                                        value="{{ old('perkiraan_waktu_praktek', $curriculum->perkiraan_waktu_praktek) }}"
                                        min="0">
                                    @error('perkiraan_waktu_praktek')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-12">
                                    <label class="mb-2">Jumlah (JP)</label>
                                    <div class="form-control-plaintext">
                                        <strong id="jumlah-display">{{ $curriculum->jumlah }}</strong>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Button Submit & Back -->
                        <div class="row mt-0 text-end">
                            <div class="col-12">
                                <a href="{{ route('curricula.index', $document_id) }}" wire:navigate
                                    class="btn btn-secondary me-2 btn-back"> Kembali
                                </a>
                                <button type="submit" class="btn btn-primary btn-submit">Update
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
        @if ($curriculum->kelompok !== 'ojt')
            function updateJumlah() {
                const teori = parseInt(document.querySelector('input[name="perkiraan_waktu_teori"]').value) || 0;
                const praktek = parseInt(document.querySelector('input[name="perkiraan_waktu_praktek"]').value) || 0;
                const jumlah = teori + praktek;
                document.getElementById('jumlah-display').textContent = jumlah;
            }

            document.querySelector('input[name="perkiraan_waktu_teori"]').addEventListener('change', updateJumlah);
            document.querySelector('input[name="perkiraan_waktu_praktek"]').addEventListener('change', updateJumlah);
        @endif


        document.getElementById('formSubmit').addEventListener('submit', function() {
            // Sembunyikan tombol submit & kembali
            this.querySelector('.btn-submit').classList.add('d-none');
            this.querySelector('.btn-back').classList.add('d-none');

            // Tampilkan loading
            this.querySelector('.btn-loading').classList.remove('d-none');
        });
    </script>
@endsection
