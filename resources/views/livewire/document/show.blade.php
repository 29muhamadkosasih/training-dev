<div>
    <div class="row justify-content-center">
        <div class="col-12 col-lg-12">
            <!-- Card Detail Document -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0 text-center">Detail Document</h5>
                </div>
                <div class="card-body">
                    @if ($data)
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <strong>ID Document:</strong>
                            </div>
                            <div class="col-md-9">
                                {{ $data->id }}
                            </div>
                        </div>

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
                            <a href="{{ route('documents.index') }}" class="btn btn-secondary" wire:navigate>
                                Kembali
                            </a>
                        </div>
                    @else
                        <div class="alert alert-warning" role="alert">
                            Data tidak ditemukan
                        </div>
                    @endif
                </div>
            </div>

            <!-- Card Informasi Umum -->
            <div class="card shadow-sm mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">A. INFORMASI UMUM</h5>
                    <a href="{{ route('general-informations.index', $data->id) }}" wire:navigate class="btn btn-primary">
                        Kelola Informasi Umum
                    </a>
                </div>
            </div>
            <!-- Card Kurikulum -->
            <div class="card shadow-sm mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">B. KURIKULUM PELATIHAN BERBASIS KOMPETENSI</h5>
                    <a href="{{ route('curricula.index', $data->id) }}" wire:navigate class="btn btn-primary">
                        Kelola Kurikulum
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
