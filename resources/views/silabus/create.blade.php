@extends('layouts.app')
@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-lg-6">
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
                    <h5 class="mb-0">Tambah Silabus Kompetensi</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('silabus.store', $document_id) }}" method="POST" id="formSubmit">
                        @csrf

                        <!-- Row 0: Judul -->
                        <div class="row mb-3">
                            <div class="col-12 mt-1">
                                <label class="mb-2">Unit Kompetensi <span class="text-danger">*</span></label>
                                {{-- Select --}}
                                <select name="unit_kompetensi_id"
                                    class="form-select @error('unit_kompetensi_id') is-invalid @enderror" required>

                                    <option value="">Pilih Unit Kompetensi</option>

                                    @foreach ($allCompetenceCodes as $items)
                                        <option value="{{ $items->id }}">
                                            {{ $items->number }}. {{ $items->unit }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

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
