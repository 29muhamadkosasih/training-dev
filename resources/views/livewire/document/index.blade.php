<div>
    @include('livewire.component-alert')

    {{-- TABEL DATA --}}
    <div class="col-12 col-lg-12">
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <div class="row align-items-center">
                    {{-- Kolom kiri: Judul --}}
                    <div class="col-md-6 col-12 mb-3 mb-md-0">
                        <h5 class="mb-0">Data Dokumen Training</h5>
                    </div>
                    {{-- Kolom kanan: Search & tombol --}}
                    <div class="col-md-6 col-12">
                        <div class="row g-2 align-items-center">
                            <div class="col-6">
                                <input type="text" wire:model.live="search" class="form-control form-control-sm"
                                    placeholder="Cari dokumen...">
                            </div>
                            <div class="col-3">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text">Per Page</span>
                                    <select wire:model.live="perPage" class="form-select form-select-sm">
                                        <option value="">All</option>
                                        <option value="10">10</option>
                                        <option value="15">15</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-3">
                                <a href="{{ route('documents.create') }}" class="btn btn-sm btn-primary" wire:navigate>
                                    Tambah
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered align-middle mb-0">
                        <thead class="bg-primary">
                            <tr>
                                <th width="5px" class="text-center text-white">No</th>
                                <th class="text-white">Skema</th>
                                <th class="text-white">No Skema</th>
                                <th class="text-white">No SKKNI</th>
                                <th class="text-white text-center">Jumlah Kompetensi</th>
                                <th width="100px" class="text-center text-white">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($datas as $index => $listData)
                                <tr>
                                    <td class="text-center">{{ $datas->firstItem() + $index }}</td>
                                    <td>{{ $listData->competence->scheme?->name ?? 'N/A' }}</td>
                                    <td>{{ $listData->competence->scheme?->no_scheme ?? 'N/A' }}</td>
                                    <td>{{ Str::limit($listData->competence->no_skkni, 100) ?? 'N/A' }}</td>
                                    <td class="text-center">{{ $listData->competence->competence_codes_count ?? 0 }}
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group gap-1" role="group">
                                            <a href="{{ route('documents.show', $listData->id) }}" class="btn btn-sm btn-icon btn-secondary" wire:navigate title="Lihat">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                            <button type="button" wire:click="confirmDelete('{{ $listData->id }}')"
                                                class="btn btn-sm btn-icon btn-danger" title="Hapus">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-3">
                                        Tidak ada data dokumen ditemukan
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-3">
                        {{ $datas->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL DELETE --}}
    <div class="modal fade @if ($showConfirm) show d-block @endif" tabindex="-1" role="dialog"
        @if ($showConfirm) style="background-color: rgba(0,0,0,0.5);" @endif
        aria-hidden="{{ $showConfirm ? 'false' : 'true' }}">

        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg">
                <div class="modal-header">
                    <h5 class="modal-title text-danger fw-bold">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" wire:click="closeModal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus dokumen ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeModal">Batal</button>
                    <button type="button" class="btn btn-danger" wire:click="delete">Hapus</button>
                </div>
            </div>
        </div>
    </div>
</div>
