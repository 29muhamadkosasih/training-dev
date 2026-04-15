<div>
    {{-- TABEL DATA --}}
    <div class="col-12 col-lg-12">
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <div class="row align-items-center">
                    {{-- Kolom kiri: Judul --}}
                    <div class="col-md-6 col-12 mb-3 mb-md-0">
                        <h5 class="mb-0">Data Skema</h5>
                    </div>
                    {{-- Kolom kanan: Search & tombol --}}
                    <div class="col-md-6 col-12">
                        <div class="row g-2 align-items-center">
                            <div class="col-7">
                                <input type="text" wire:model.live="search" class="form-control form-control-sm"
                                    placeholder="Cari skema...">
                            </div>
                            <div class="col-5">
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
                                <th class="text-white">Nama</th>
                                <th class="text-white">No Skema</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($datas as $index => $listData)
                                <tr>
                                    <td class="text-center">{{ $datas->firstItem() + $index }}</td>
                                    <td>{{ $listData->name }}</td>
                                    <td>{{ $listData->no_scheme }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-3">
                                        Tidak ada data role ditemukan
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
</div>
