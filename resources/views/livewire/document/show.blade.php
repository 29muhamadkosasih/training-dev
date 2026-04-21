<div>
    <div class="row justify-content-center">
        <div class="col-12 col-lg-12">
            <!-- Card Detail Document -->
            <div class="card shadow-sm mb-3">
                <div class="card-header">
                    <h5 class="mb-0 text-center">Detail Document</h5>
                </div>
                <div class="card-body">
                    @if ($data)

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <strong>Skema Kompetensi:</strong>
                            </div>
                            <div class="col-md-9">
                                {{ $data->competence->scheme->name ?? '-' }}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <strong>Competence ID:</strong>
                            </div>
                            <div class="col-md-9">
                                {{ $data->competence_id }}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <strong>Dibuat:</strong>
                            </div>
                            <div class="col-md-9">
                                {{ $data->created_at?->format('d M Y H:i') ?? '-' }}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <strong>Diperbarui:</strong>
                            </div>
                            <div class="col-md-9">
                                {{ $data->updated_at?->format('d M Y H:i') ?? '-' }}
                            </div>
                        </div>

                        <div class="text-end mt-4">
                            <a href="{{ route('documents.index') }}" class="btn btn-secondary me-2" wire:navigate>
                                Kembali
                            </a>
                            <a href="{{ route('documents.pdf', $data->id) }}" class="btn btn-primary" target="_blank">
                                PDF
                            </a>
                        </div>
                    @else
                        <div class="alert alert-warning" role="alert">
                            Data tidak ditemukan
                        </div>
                    @endif
                </div>
            </div>

            <div class="row">

                <div class="col-md-6 mb-3">
                    <div class="card shadow-sm mb-4 h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">A. INFORMASI UMUM</h6>
                            <a href="{{ route('general-informations.index', $data->id) }}" wire:navigate
                                class="btn btn-primary btn-sm">
                                Kelola
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="card shadow-sm mb-4 h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">B. KURIKULUM</h6>
                            <a href="{{ route('curricula.index', $data->id) }}" wire:navigate
                                class="btn btn-primary btn-sm">
                                Kelola
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="card shadow-sm mb-4 h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">C. SILABUS</h6>
                            <a href="{{ route('silabus.index', $data->id) }}" wire:navigate
                                class="btn btn-primary btn-sm">
                                Kelola
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="card shadow-sm mb-4 h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">D. RENCANA PELAKSANAAN PEMBELAJARAN</h6>
                            <a href="{{ route('lesson-plans.index', $data->id) }}" wire:navigate
                                class="btn btn-primary btn-sm">
                                Kelola
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card shadow-sm mb-4 h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">E.	DAFTAR PERALATAN YANG DIGUNAKAN</h6>
                            <a href="{{ route('equipments.index', $data->id) }}" wire:navigate
                                class="btn btn-primary btn-sm">
                                Kelola
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card shadow-sm mb-4 h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">F. DAFTAR PERLENGKAPAN YANG DIBUTUHKAN</h6>
                            <a href="{{ route('supplys.index', $data->id) }}" wire:navigate
                                class="btn btn-primary btn-sm">
                                Kelola
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
