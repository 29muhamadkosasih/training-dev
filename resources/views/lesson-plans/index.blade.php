@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-lg-12">

            <!-- Alert Error -->
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <div class="d-flex">
                        <div>
                            {{ session('error') }}
                        </div>
                    </div>
                    <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                </div>
            @endif

            <!-- Card Lesson Plan -->
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    {{-- Header --}}
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h5 class="mb-0">Rencana Pembelajaran (Lesson Plan)</h5>
                            <small class="text-muted">{{ $dataDocument->name ?? 'Document' }}</small>
                        </div>
                        <a href="{{ route('documents.show', $document_id) }}" wire:navigate class="btn btn-secondary">
                            Kembali
                        </a>
                    </div>

                    <!-- Data Display -->
                    @if ($lessonPlans)
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="card-title">Nama Program Pelatihan</h6>
                                        <p class="mb-0 fw-bold">{{ $lessonPlans->document->competence->scheme->name }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="card-title">Penyajian</h6>
                                        <p class="mb-0 fw-bold">{{ $lessonPlans->penyajian_hari ?? '-' }} Hari</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="card-title">Waktu (JP)</h6>
                                        <p class="mb-0 fw-bold">{{ $lessonPlans->waktu_jp ?? '-' }} JP</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="card-title">Durasi</h6>
                                        <p class="mb-0 fw-bold">{{ $lessonPlans->waktu_menit ?? '-' }} Menit</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="card-title">Tujuan Instruksional</h6>
                                        <p class="mb-0">{!! $lessonPlans->tujuan_instruksional ?? '-' !!}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="card-title">Metode Mengajar</h6>
                                        @if ($lessonPlans->metode)
                                            <p class="mb-0 text-break">{!! $lessonPlans->metode !!}</p>
                                        @else
                                            <p class="mb-0 text-muted">-</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="card-title">Media Pembelajaran</h6>
                                        @if ($lessonPlans->media)
                                            <p class="mb-0 text-break">{!! $lessonPlans->media !!}</p>
                                        @else
                                            <p class="mb-0 text-muted">-</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="card-title">Persiapan</h6>
                                        @if ($lessonPlans->persiapan)
                                            <p class="mb-0 text-break">{!! $lessonPlans->persiapan !!}</p>
                                        @else
                                            <p class="mb-0 text-muted">-</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Detail Pembelajaran -->
                        @if ($lessonPlanDetails && $lessonPlanDetails->count() > 0)
                            <div class="mb-3">
                                <h6 class="mb-3">Detail Pembelajaran (Pokok Bahasan)</h6>
                                @foreach ($lessonPlanDetails as $detail)
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <div class="row mb-2">
                                                <div class="col-md-5">
                                                    <small class="text-muted">Sub Pokok Bahasan</small>
                                                    <p class="mb-0 fw-bold">{!! $detail->sub_pokok ?? '-' !!}</p>
                                                </div>
                                                <div class="col-md-4">
                                                    <small class="text-muted">Media</small>
                                                    <p class="mb-0 fw-bold">{!! $detail->media ?? '-' !!}</p>
                                                </div>
                                                <div class="col-md-3">
                                                    <small class="text-muted">Number</small>
                                                    <p class="mb-0 fw-bold">{!! $detail->number ?? '-' !!}</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-9">
                                                    <small class="text-muted">Uraian / Kegiatan</small>
                                                    <p class="mb-0">{!! $detail->uraian ?? '-' !!}</p>
                                                </div>
                                                <div class="col-md-3">
                                                    <small class="text-muted">Waktu (Menit)</small>
                                                    <p class="mb-0 fw-bold">{!! $detail->waktu ?? '-' !!}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                
                                <!-- Total Waktu -->
                                @if ($lessonPlanDetails->count() > 0)
                                    <div class="card border-success mb-3" style="background-color: #f0f8f5;">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-9">
                                                    <h6 class="mb-0 fw-bold">TOTAL</h6>
                                                </div>
                                                <div class="col-md-3">
                                                    <h6 class="mb-0 fw-bold text-success">{{ $lessonPlanDetails->sum('waktu') }} menit</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif

                        <!-- Action Buttons -->
                        <div class="d-flex gap-2">
                            @if ($lessonPlans->metode)
                                <a href="{{ route('lesson-plans.edit', [$document_id, $lessonPlans->id]) }}"
                                    class="btn btn-primary"> Edit Rencana Pembelajaran
                                </a>
                            @else
                                <a href="{{ route('lesson-plans.create', $document_id) }}" class="btn btn-primary">Buat
                                    Rencana Pembelajaran
                                </a>
                            @endif
                        </div>
                    @else
                        <div class="alert alert-info">
                            <p class="mb-0">Belum ada rencana pembelajaran. <a
                                    href="{{ route('lesson-plans.create', $document_id) }}">Buat sekarang</a></p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        var jq = jQuery.noConflict();

        jq(document).ready(function() {
            jq(document).on("click", ".show_confirm", function(e) {
                e.preventDefault();

                let form = jq(this).closest("form");

                if (typeof Swal !== "undefined") {
                    Swal.fire({
                        title: "Yakin?",
                        text: "Data yang dihapus tidak bisa dikembalikan!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Ya, hapus!",
                        cancelButtonText: "Batal",
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#6c757d",
                        buttonsStyling: false,
                        customClass: {
                            confirmButton: "btn btn-danger",
                            cancelButton: "btn btn-secondary"
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                } else {
                    alert('Yakin ingin menghapus?');
                    form.submit();
                }
            });
        });
    </script>
@endsection
