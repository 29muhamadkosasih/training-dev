@extends('layouts.app')

@section('content')
    <!-- Error Alerts -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <h4 class="alert-heading">{{ __('Validation Errors') }}</h4>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
        </div>
    @endif
    <!-- Card Form -->
    <div class="card shadow-sm mb-4">
        <div class="card-header">
            <h5 class="mb-0">Tambah Detail Silabus Kompetensi</h5>
        </div>
        <div class="card-body">
            <form
                action="{{ route('silabus.store.unit', ['document_id' => $document_id, 'unit_kompetensi_id' => $unit_kompetensi_id]) }}"
                method="POST" id="formSubmit">
                @csrf

                <!-- Unit Information Card -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h6 class="mb-0">Informasi Unit</h6>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="mb-2">Unit Kompetensi</label>
                                <input type="text" class="form-control" value="{{ $competenceCodes->unit ?? '-' }}"
                                    disabled>
                            </div>
                            <div class="col-md-6">
                                <label class="mb-2">Kode Unit</label>
                                <input type="text" class="form-control" value="{{ $competenceCodes->kode ?? '-' }}"
                                    disabled>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Training Details Card -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h6 class="mb-0">Detail Pelatihan</h6>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="mb-2">Perkiraan Waktu Pelatihan</label>
                                <input type="text" class="form-control" name="waktu_pelatihan"
                                    value="{{ old('waktu_pelatihan') }}" placeholder="Contoh: 5 JP @ 45 menit">
                            </div>
                            <div class="col-md-4">
                                <label class="mb-2">Metode Pelatihan</label>
                                <input type="text" class="form-control" name="metode_pelatihan"
                                    value="{{ old('metode_pelatihan') }}" placeholder="Contoh: Luring/Daring/Bauran">
                            </div>
                            <div class="col-md-4">
                                <label class="mb-2">Capaian Unit Kompetensi</label>
                                <textarea class="form-control" name="capaian_unit_kompetensi" rows="3"
                                    placeholder="Setelah mengikuti pelatihan ini, peserta diharapkan mampu...">{{ old('capaian_unit_kompetensi') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                @foreach ($element as $item)
                    @php
                        $getKuk = \App\Models\CompetenceKuk::where('competence_code_element_id', $item->id)
                            ->orderBy('created_at', 'asc')
                            ->orderBy('number', 'asc')
                            ->get();

                        $number = $loop->iteration;
                    @endphp

                    <div class="card mb-4 shadow-sm">

                        {{-- Header Card --}}
                        <div class="card-header">
                            <strong>{{ $item->number }}. {{ $item->element }}</strong>
                        </div>

                        <div class="card-body">

                            {{-- KUK --}}
                            <div class="mb-3">
                                <label class="mb-2">Kriteria Unjuk Kerja:</label>
                                <ul class="mb-0">
                                    @foreach ($getKuk as $kuk)
                                        <li>
                                            {{ $number }}.{{ $loop->iteration }}. {{ $kuk->kuk }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            {{-- Form Input --}}
                            <div class="row">

                                <div class="col-md-4 mb-3">
                                    <label class="mb-2">Indikator Unjuk Kerja</label>
                                    <textarea class="form-control editor" name="indikator_{{ $item->id }}" rows="3"
                                        placeholder="Pisahkan dengan titik koma (;)">{{ old('indikator_' . $item->id) }}</textarea>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="mb-2">Pengetahuan</label>
                                    <textarea class="form-control editor" name="pengetahuan_{{ $item->id }}" rows="3"
                                        placeholder="Pisahkan dengan titik koma (;)">{{ old('pengetahuan_' . $item->id) }}</textarea>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="mb-2">Keterampilan & Sikap</label>
                                    <textarea class="form-control editor" name="keterampilan_sikap_{{ $item->id }}" rows="3"
                                        placeholder="Pisahkan dengan titik koma (;)">{{ old('keterampilan_sikap_' . $item->id) }}</textarea>
                                </div>

                                <div class="col-md-2">
                                    <label class="mb-2">Durasi (Menit)</label>
                                    <input type="text" class="form-control" name="durasi_{{ $item->id }}"
                                        value="{{ old('durasi_' . $item->id) }}" placeholder="75">
                                </div>

                            </div>

                            <input type="hidden" name="element_id_{{ $item->id }}" value="{{ $item->id }}">
                            <input type="hidden" name="number_{{ $item->id }}" value="{{ $item->number }}">

                        </div>
                    </div>
                @endforeach

                <br>

                <!-- Button Submit & Back -->
                <div class="row mt-0 text-end">
                    <div class="col-12">
                        <a href="{{ route('silabus.index', $document_id) }}" wire:navigate
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
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

    <script>
        document.getElementById('formSubmit').addEventListener('submit', function() {
            // Sembunyikan tombol submit & kembali
            this.querySelector('.btn-submit').classList.add('d-none');
            this.querySelector('.btn-back').classList.add('d-none');

            // Tampilkan loading
            this.querySelector('.btn-loading').classList.remove('d-none');
        });

        const editors = {};

        function initEditor(element) {
            ClassicEditor.create(element)
                .then(editor => {
                    editors[element.id] = editor;
                })
                .catch(error => {
                    console.error('CKEditor init error:', error);
                });
        }

        document.querySelectorAll('.editor').forEach(el => initEditor(el));
    </script>
@endsection
