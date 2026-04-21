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
                    <h5 class="mb-0">Edit Rencana Pelatihan (Lesson Plan)</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('lesson-plans.update', [$document_id, $lessonPlan->id]) }}" method="POST"
                        id="formSubmit">
                        @csrf
                        @method('PUT')

                        <!-- Section 1: NAMA PROGRAM PELATIHAN & PENYAJIAN -->
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <label class="mb-2">Nama Program Pelatihan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control"
                                    value="{{ $lessonPlan->document->competence->scheme->name }}" disabled>
                            </div>
                            <div class="col-md-4">
                                <label class="mb-2">Penyajian (Hari) <span class="text-danger">*</span></label>
                                <input type="number" name="penyajian_hari" id="penyajian_hari"
                                    class="form-control @error('penyajian_hari') is-invalid @enderror"
                                    value="{{ old('penyajian_hari', $lessonPlan->penyajian_hari) }}" placeholder="2"
                                    min="1" required>
                                @error('penyajian_hari')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <!-- Section 2: UNIT KOMPETENSI -->
                        <div class="mb-4">
                            <h6 class="mb-3">Unit Kompetensi <span class="text-danger">*</span></h6>
                            <div class="row">
                                @foreach ($allCompetenceCodes as $index => $code)
                                    <div class="col-md-12 mb-2">
                                        <div class="card shadow-sm h-100">
                                            <div class="card-body">
                                                <div class="fw-bold">
                                                    {{ $code->number }}. {{ $code->unit }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Section 3: WAKTU -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label class="mb-2">Waktu (JP - Jam Pelajaran) <span class="text-danger">*</span></label>
                                <input type="number" name="waktu_jp" id="waktu_jp"
                                    class="form-control @error('waktu_jp') is-invalid @enderror"
                                    value="{{ old('waktu_jp', $lessonPlan->waktu_jp) }}" placeholder="20" min="1"
                                    required>
                                <small class="text-muted">1 JP = 45 menit</small>
                                @error('waktu_jp')
                                    <small class="text-danger d-block">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="mb-2">Durasi (Menit)</label>
                                <input type="number" name="waktu_menit" id="waktu_menit" class="form-control" readonly
                                    placeholder="900" value="{{ old('waktu_menit', $lessonPlan->waktu_menit) }}">
                                <small class="text-muted">Otomatis dihitung</small>
                            </div>
                        </div>

                        <!-- Section 5: TUJUAN INSTRUKSIONAL -->
                        <div class="mb-4">
                            <label class="mb-2">Tujuan Instruksional <span class="text-danger">*</span></label>
                            <textarea name="tujuan_instruksional" id="tujuan_instruksional"
                                class="form-control editor @error('tujuan_instruksional') is-invalid @enderror" rows="4" required>{{ old('tujuan_instruksional', $lessonPlan->tujuan_instruksional) }}</textarea>
                            <small class="text-muted">Jelaskan kompetensi yang akan dicapai peserta</small>
                            @error('tujuan_instruksional')
                                <small class="text-danger d-block">{{ $message }}</small>
                            @enderror
                        </div>


                        <!-- Section 6: METODE MENGAJAR -->
                        <div class="mb-4">
                            <label class="mb-2">Metode Mengajar <span class="text-danger">*</span></label>
                            <textarea name="metode" id="metode" class="form-control editor @error('metode') is-invalid @enderror" rows="4"
                                required>{{ old('metode', $lessonPlan->metode) }}</textarea>
                            <small class="text-muted">Contoh: Ceramah, Diskusi, Demonstrasi, Simulasi, Praktik, Studi
                                Kasus</small>
                            @error('metode')
                                <small class="text-danger d-block">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Section 7: MEDIA PEMBELAJARAN -->
                        <div class="mb-4">
                            <label class="mb-2">Media Pembelajaran <span class="text-danger">*</span></label>
                            <textarea name="media" id="media" class="form-control editor @error('media') is-invalid @enderror" rows="4"
                                required>{{ old('media', $lessonPlan->media) }}</textarea>
                            <small class="text-muted"></small>
                            @error('media')
                                <small class="text-danger d-block">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Section 8: PERSIAPAN -->
                        <div class="mb-4">
                            <label class="mb-2">Persiapan <span class="text-danger">*</span></label>
                            <textarea name="persiapan_text" id="persiapan_text"
                                class="form-control editor @error('persiapan_text') is-invalid @enderror" rows="4" required>{{ old('persiapan_text', $lessonPlan->persiapan) }}</textarea>
                            <small class="text-muted">Daftar persiapan (setiap item pada baris baru)</small>
                            @error('persiapan_text')
                                <small class="text-danger d-block">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Section 9: DETAIL PEMBELAJARAN -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0">Detail Pembelajaran (Pokok Bahasan)</h6>
                                <button type="button" class="btn btn-sm btn-success" id="addRowBtn">
                                    <i class="fas fa-plus"></i> Tambah Pokok
                                </button>
                            </div>
                            <div id="detailCardsContainer" style="display: none;">
                                <div class="card border mb-3 detail-card">
                                    <div class="card-header bg-light">
                                        <strong>Pokok Bahasan #<span class="card-number">1</span></strong>
                                    </div>
                                    <input type="hidden" name="detail_number[]" class="detail-number" value="1">
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Sub Pokok Bahasan</label>
                                                <textarea name="detail_sub_pokok[]" class="form-control editor detail-textarea" rows="2" placeholder="Masukkan Sub Pokok Bahasan"></textarea>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Media</label>
                                                <input type="text" name="detail_media[]" class="form-control" placeholder="Contoh: Slide, Video">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-9">
                                                <label class="form-label">Uraian / Kegiatan</label>
                                                <textarea name="detail_uraian[]" class="form-control editor detail-textarea" rows="3" placeholder="Masukkan Uraian/Kegiatan"></textarea>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Waktu (Menit)</label>
                                                <input type="number" name="detail_waktu[]" class="form-control" min="1" placeholder="30">
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <button type="button" class="btn btn-sm btn-danger deleteCardBtn" style="display: none;">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="detailCardsDisplay">
                                @if ($lessonPlanDetails && $lessonPlanDetails->count() > 0)
                                    @foreach ($lessonPlanDetails as $index => $detail)
                                            <div class="card border mb-3 detail-card">
                                            <div class="card-header bg-light">
                                                <strong>Pokok Bahasan #<span class="card-number">{{ $index + 1 }}</span></strong>
                                            </div>
                                            <input type="hidden" name="detail_number[]" class="detail-number" value="{{ $index + 1 }}">
                                            <div class="card-body">
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label">Sub Pokok Bahasan</label>
                                                        <textarea name="detail_sub_pokok[]" class="form-control editor detail-textarea" rows="2" placeholder="Masukkan Sub Pokok Bahasan">{{ $detail->sub_pokok }}</textarea>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Media</label>
                                                        <input type="text" name="detail_media[]" class="form-control" placeholder="Contoh: Slide, Video" value="{{ $detail->media }}">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-9">
                                                        <label class="form-label">Uraian / Kegiatan</label>
                                                        <textarea name="detail_uraian[]" class="form-control editor detail-textarea" rows="3" placeholder="Masukkan Uraian/Kegiatan">{{ $detail->uraian }}</textarea>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label">Waktu (Menit)</label>
                                                        <input type="number" name="detail_waktu[]" class="form-control" min="1" placeholder="30" value="{{ $detail->waktu }}">
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-end">
                                                    <button type="button" class="btn btn-sm btn-danger deleteCardBtn">
                                                        <i class="fas fa-trash"></i> Hapus
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('lesson-plans.index', $document_id) }}" wire:navigate
                                class="btn btn-secondary btn-back">Kembali</a>
                            <button type="submit" class="btn btn-primary btn-submit">Update Rencana Pelatihan</button>


                            <button class="btn btn-primary btn-loading d-none" type="button" disabled>
                                <span class="spinner-grow spinner-grow-sm"></span>
                                <span class="ms-1">Loading...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto calculate waktu_menit
        document.getElementById('waktu_jp').addEventListener('change', function() {
            const jp = parseInt(this.value) || 0;
            const menit = jp * 45;
            document.getElementById('waktu_menit').value = menit;
        });

        // Trigger calculation on page load
        if (document.getElementById('waktu_jp').value) {
            document.getElementById('waktu_jp').dispatchEvent(new Event('change'));
        }
    </script>

    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

    <script>
        const editors = {};

        function initEditor(element) {
            if (!element.id) {
                element.id = 'editor_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
            }
            
            ClassicEditor.create(element)
                .then(editor => {
                    editors[element.id] = editor;
                })
                .catch(error => {
                    console.error('CKEditor init error:', error);
                });
        }

        // Init all editors on page load (exclude template container)
        document.querySelectorAll('.editor:not(#detailCardsContainer .editor)').forEach(el => initEditor(el));
    </script>

    <script>
        document.getElementById('formSubmit').addEventListener('submit', function() {
            // Sembunyikan tombol submit & kembali
            this.querySelector('.btn-submit').classList.add('d-none');
            this.querySelector('.btn-back').classList.add('d-none');

            // Tampilkan loading
            this.querySelector('.btn-loading').classList.remove('d-none');
        });

        // Detail Pembelajaran - Add Card
        document.getElementById('addRowBtn').addEventListener('click', function(e) {
            e.preventDefault();
            const templateContainer = document.getElementById('detailCardsContainer');
            const displayContainer = document.getElementById('detailCardsDisplay');
            const templateCard = templateContainer.querySelector('.detail-card');
            const newCard = templateCard.cloneNode(true);

            // Generate unique IDs and clear values
            const timestamp = Date.now();
            const random = Math.random().toString(36).substr(2, 9);
            
            newCard.querySelectorAll('input, textarea').forEach((input, idx) => {
                // Don't clear hidden number input, clear other inputs
                if (!input.classList.contains('detail-number')) {
                    input.value = '';
                }
                if (input.classList.contains('editor')) {
                    input.id = 'editor_' + timestamp + '_' + random + '_' + idx;
                }
            });

            displayContainer.appendChild(newCard);
            updateCardNumbers();
            updateDeleteButtons();

            // Init CKEditor for new editors after DOM update
            setTimeout(() => {
                newCard.querySelectorAll('.editor').forEach(el => initEditor(el));
            }, 100);
        });

        // Delete card functionality
        document.addEventListener('click', function(e) {
            if (e.target.closest('.deleteCardBtn')) {
                e.preventDefault();
                const card = e.target.closest('.detail-card');
                
                // Destroy CKEditor instances before removing
                card.querySelectorAll('.editor').forEach(el => {
                    if (el.id && editors[el.id]) {
                        editors[el.id].destroy().then(() => {
                            delete editors[el.id];
                        });
                    }
                });
                
                card.remove();
                updateDeleteButtons();
            }
        });

        // Update card numbers
        function updateCardNumbers() {
            const cards = document.querySelectorAll('#detailCardsDisplay .detail-card');
            cards.forEach((card, idx) => {
                const numberSpan = card.querySelector('.card-number');
                if (numberSpan) {
                    numberSpan.textContent = idx + 1;
                }
                // Update hidden number input
                const numberInput = card.querySelector('.detail-number');
                if (numberInput) {
                    numberInput.value = idx + 1;
                }
            });
        }

        // Update delete button visibility
        function updateDeleteButtons() {
            const displayContainer = document.getElementById('detailCardsDisplay');
            const cards = displayContainer.querySelectorAll('.detail-card');
            cards.forEach(card => {
                const deleteBtn = card.querySelector('.deleteCardBtn');
                if (cards.length > 1) {
                    deleteBtn.style.display = 'inline-block';
                } else {
                    deleteBtn.style.display = 'none';
                }
            });
        }

        // Initialize on page load
        updateCardNumbers();
        updateDeleteButtons();
    </script>
@endsection
