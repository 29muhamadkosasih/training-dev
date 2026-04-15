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
                    <h5 class="mb-0">Tambah Informasi Umum</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('general-informations.store', $document_id) }}" method="POST" id="formSubmit">
                        @csrf

                        <!-- Row 0: Judul -->
                        <div class="row mb-3">
                            <div class="col-12 mt-1">
                                <label class="mb-2">Judul <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" value="{{ $competences->scheme->name ?? '-' }}"
                                    disabled>
                            </div>
                        </div>

                        <!-- Row 1: Kode -->
                        <div class="row mb-3">
                            <div class="col-12 mt-1">
                                <label class="mb-2">1. Kode <span class="text-danger">*</span></label>
                                <input type="text" name="kode"
                                    class="form-control @error('kode') is-invalid @enderror" placeholder="Masukkan kode"
                                    value="{{ old('kode') }}">
                                @error('kode')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <!-- Row 2: Jenis Program & Metode Pelatihan -->
                        <div class="row mb-3">
                            <div class="col-md-6 mt-1">
                                <label class="mb-2">2. Jenis Program</label>
                                <input type="text" name="jenis_program"
                                    class="form-control @error('jenis_program') is-invalid @enderror"
                                    placeholder="Mis: Cluster / Okupasi / Kualifikasi" value="{{ old('jenis_program') }}">
                                @error('jenis_program')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 mt-1">
                                <label class="mb-2">3. Metode Pelatihan</label>
                                <input type="text" name="metode_pelatihan"
                                    class="form-control @error('metode_pelatihan') is-invalid @enderror"
                                    placeholder="Mis: Luring / Daring / Bauran" value="{{ old('metode_pelatihan') }}">
                                @error('metode_pelatihan')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <!-- Row 3: Tujuan -->
                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="mb-2">4. Tujuan</label>
                                <textarea name="tujuan" class="form-control @error('tujuan') is-invalid @enderror" rows="3"
                                    placeholder="Masukkan tujuan pelatihan...">{{ old('tujuan') }}</textarea>
                                @error('tujuan')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <!-- Row 4: Profil Kompetensi -->
                        <div class="row mb-3">
                            <div class="col-12">
                                <h6 class="bg-light p-2 mb-3"><strong>5. Profil Kompetensi</strong></h6>
                                <div class="table-responsive">
                                    <table
                                        class="table table-striped table-hover table-bordered align-middle mb-0 table-sm">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th class="text-white" width="1%">No</th>
                                                <th class="text-white">Kode</th>
                                                <th class="text-white">Unit Kompetensi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($dataKodeUnit as $index => $kode)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $kode->kode ?? '-' }}</td>
                                                    <td>{{ $kode->unit ?? '-' }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3" class="text-center text-muted">Tidak ada
                                                        data kompetensi</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Row 5: Jenis Standart Kompetensi -->
                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="mb-2">6. Jenis Standart Kompetensi</label>
                                <input type="text" name="jenis_standart_kompetensi"
                                    class="form-control @error('jenis_standart_kompetensi') is-invalid @enderror"
                                    placeholder="Mis: SKNI / SKKNI" value="{{ old('jenis_standart_kompetensi') }}">
                                @error('jenis_standart_kompetensi')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <!-- Section: Persyaratan Peserta Pelatihan -->
                        <div class="row mb-3">
                            <div class="col-12">
                                <h6 class="bg-light p-2 mb-3"><strong>7. Persyaratan Peserta Pelatihan</strong>
                                </h6>

                                <div class="row mb-2">
                                    <div class="col-md-6 mt-1">
                                        <label class="mb-2">7.1 Pendidikan</label>
                                        <input type="text" name="persyaratan_pendidikan"
                                            class="form-control @error('persyaratan_pendidikan') is-invalid @enderror"
                                            placeholder="Mis: Minimal tamat D3 atau Sederajat"
                                            value="{{ old('persyaratan_pendidikan') }}">
                                        @error('persyaratan_pendidikan')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mt-1">
                                        <label class="mb-2">7.2 Pelatihan</label>
                                        <input type="text" name="persyaratan_pelatihan"
                                            class="form-control @error('persyaratan_pelatihan') is-invalid @enderror"
                                            placeholder="Mis: Minimal tamat D2 atau Sederajat"
                                            value="{{ old('persyaratan_pelatihan') }}">
                                        @error('persyaratan_pelatihan')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-md-6 mt-1">
                                        <label class="mb-2">7.3 Pengalaman Kerja</label>
                                        <input type="text" name="persyaratan_pengalaman_kerja"
                                            class="form-control @error('persyaratan_pengalaman_kerja') is-invalid @enderror"
                                            placeholder="Mis: Minimal 1 Tahun"
                                            value="{{ old('persyaratan_pengalaman_kerja') }}">
                                        @error('persyaratan_pengalaman_kerja')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mt-1">
                                        <label class="mb-2">7.4 Usia</label>
                                        <input type="text" name="persyaratan_usia"
                                            class="form-control @error('persyaratan_usia') is-invalid @enderror"
                                            placeholder="Mis: Minimal 18 tahun" value="{{ old('persyaratan_usia') }}">
                                        @error('persyaratan_usia')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label class="mb-2">7.5 Persyaratan Khusus</label>
                                        <textarea name="persyaratan_khusus_peserta"
                                            class="form-control @error('persyaratan_khusus_peserta') is-invalid @enderror" rows="2"
                                            placeholder="Masukkan persyaratan khusus...">{{ old('persyaratan_khusus_peserta') }}</textarea>
                                        @error('persyaratan_khusus_peserta')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section: Persyaratan Instruktur -->
                        <div class="row mb-2">
                            <div class="col-12">
                                <h6 class="bg-light p-2 mb-3"><strong>8. Persyaratan Instruktur</strong></h6>

                                <div class="row mb-2">
                                    <div class="col-md-6 mt-1">
                                        <label class="mb-2">8.1 Pendidikan Formal</label>
                                        <textarea name="instruktur_pendidikan_formal"
                                            class="form-control @error('instruktur_pendidikan_formal') is-invalid @enderror" rows="4"
                                            placeholder="Mis: Minimal tamat D3 atau Sederajat">{{ old('instruktur_pendidikan_formal') }}</textarea>
                                        @error('instruktur_pendidikan_formal')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mt-1">
                                        <label class="mb-2">8.2 Kompetensi Metodologi</label>
                                        <textarea name="instruktur_kompetensi_metodologi"
                                            class="form-control @error('instruktur_kompetensi_metodologi') is-invalid @enderror" rows="4"
                                            placeholder="Mis: Identifikasi Kemampuan Metodologi...">{{ old('instruktur_kompetensi_metodologi') }}</textarea>
                                        @error('instruktur_kompetensi_metodologi')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-md-6 mt-1">
                                        <label class="mb-2">8.3 Kompetensi Teknis</label>
                                        <textarea name="instruktur_kompetensi_teknis"
                                            class="form-control @error('instruktur_kompetensi_teknis') is-invalid @enderror" rows="4"
                                            placeholder="Mis: Memiliki Sertifikasi teknis bidang ...">{{ old('instruktur_kompetensi_teknis') }}</textarea>
                                        @error('instruktur_kompetensi_teknis')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mt-1">
                                        <label class="mb-2">8.4 Pengalaman Kerja</label>
                                        <textarea name="instruktur_pengalaman_kerja"
                                            class="form-control @error('instruktur_pengalaman_kerja') is-invalid @enderror" rows="4"
                                            placeholder="Mis: Minimal 3 Tahun atau sederajat">{{ old('instruktur_pengalaman_kerja') }}</textarea>
                                        @error('instruktur_pengalaman_kerja')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label class="mb-2">8.5 Persyaratan Khusus</label>
                                        <textarea name="instruktur_persyaratan_khusus"
                                            class="form-control @error('instruktur_persyaratan_khusus') is-invalid @enderror" rows="4"
                                            placeholder="Masukkan persyaratan khusus instruktur...">{{ old('instruktur_persyaratan_khusus') }}</textarea>
                                        @error('instruktur_persyaratan_khusus')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Button Submit & Back -->
                        <div class="row mt-0 text-end">
                            <div class="col-12">
                                <a href="{{ route('general-informations.index', $document_id) }}" wire:navigate
                                    class="btn btn-secondary btn-back me-2">
                                    Kembali
                                </a>

                                <button type="submit" class="btn btn-primary btn-submit">
                                    Submit
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
        document.getElementById('formSubmit').addEventListener('submit', function() {
            // Sembunyikan tombol submit & kembali
            this.querySelector('.btn-submit').classList.add('d-none');
            this.querySelector('.btn-back').classList.add('d-none');

            // Tampilkan loading
            this.querySelector('.btn-loading').classList.remove('d-none');
        });
    </script>
@endsection
