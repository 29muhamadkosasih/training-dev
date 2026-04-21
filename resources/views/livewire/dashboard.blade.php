<div>
    <div class="row">
        <!-- Statistics Cards -->
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Total Skema</h6>
                            <h3 class="mb-0">{{ $totalSchemes }}</h3>
                        </div>
                        <div class="icon-container">
                            <i class="ti ti-clipboard-list fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Total Document</h6>
                            <h3 class="mb-0">{{ $totalDocuments }}</h3>
                        </div>
                        <div class="icon-container">
                            <i class="ti ti-file text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Latest Data Section -->
    <div class="row mt-0">
        <!-- Latest Schemes -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between pb-0">
                    <h5 class="card-title mb-0">Skema Terbaru</h5>
                    @if ($totalSchemes > 0)
                        <a href="{{ route('schemes.index') }}" wire:navigate class="btn btn-sm btn-primary">Lihat Semua</a>
                    @endif
                </div>
                <div class="card-body">
                    @if (count($latestSchemes) > 0)
                        <div class="list-group list-group-flush">
                            @foreach ($latestSchemes as $scheme)
                                <div
                                    class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                                    <div>
                                        <h6 class="mb-0">{{ $scheme['name'] ?? 'N/A' }}</h6>
                                        <small class="text-muted">No: {{ $scheme['no_scheme'] ?? '-' }}</small>
                                    </div>
                                    <small class="text-muted">
                                        {{ isset($scheme['created_at']) ? \Carbon\Carbon::parse($scheme['created_at'])->diffForHumans() : 'N/A' }}
                                    </small>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted text-center py-3">Tidak ada data Scheme Kompetensi</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Latest Documents -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between pb-0">
                    <h5 class="card-title mb-0">Document Terbaru</h5>
                    @if ($totalDocuments > 0)
                        <a href="{{ route('documents.index') }}" wire:navigate class="btn btn-sm btn-success">Lihat Semua</a>
                    @endif
                </div>
                <div class="card-body">
                    @if (count($latestDocuments) > 0)
                        <div class="list-group list-group-flush">
                            @foreach ($latestDocuments as $document)
                                <div
                                    class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                                    <div>
                                        <h6 class="mb-0">{{ $document['name'] ?? ($document['id'] ?? 'N/A') }}</h6>
                                        <small class="text-muted">
                                            @if (isset($document['competence']))
                                                Kompetensi: {{ $document['competence']['name'] ?? 'N/A' }}
                                            @else
                                                No kompetensi
                                            @endif
                                        </small>
                                    </div>
                                    <small class="text-muted">
                                        {{ isset($document['created_at']) ? \Carbon\Carbon::parse($document['created_at'])->diffForHumans() : 'N/A' }}
                                    </small>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted text-center py-3">Tidak ada data Document</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>

        .list-group-item {
            border-bottom: 1px solid #f0f0f0;
        }

        .list-group-item:last-child {
            border-bottom: none;
        }
    </style>
</div>
