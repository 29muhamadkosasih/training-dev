@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-lg-12">
            <!-- Error Alert -->
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

            <!-- Card Supply -->
            <div class="card shadow-sm mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">F. DAFTAR PERLENGKAPAN YANG DIBUTUHKAN</h5>
                    <div class="d-flex gap-2">
                        <a href="{{ route('documents.show', $document_id) }}" wire:navigate class="btn btn-secondary">
                            Kembali
                        </a>
                        @if ($supply->isEmpty())
                            <a href="{{ route('supplys.create', $document_id) }}" wire:navigate
                                class="btn btn-primary">Tambah
                            </a>
                        @else
                            <a href="{{ route('supplys.edit', ['document_id' => $document_id, 'id' => $supply->first()->id]) }}"
                                wire:navigate class="btn btn-warning">Edit
                            </a>
                            <form action="{{ route('supplys.destroy-all', $document_id) }}" method="POST"
                                style="display:inline;" class="form-delete-all">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger show_confirm_all" title="Hapus Semua"> Hapus
                                    Semua
                                </button>
                            </form>
                        @endif

                    </div>
                </div>

                <div class="card-body">
                    @if ($supply->isEmpty())
                        <div class="alert alert-info" role="alert">
                            <i class="ti ti-info-circle"></i> Belum ada data perlangkapan yang dibutuhkan.
                        </div>
                    @else
                        @foreach ($supply as $item)
                            <!-- Supply Header -->
                            <div class="mb-3">
                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="mb-0 text-muted">Perkiraan Waktu Pelatihan</label>
                                            <div class="form-control-plaintext">
                                                <strong>{{ $item->perkiraan_waktu_pelatihan }}</strong>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="mb-0 text-muted">Jumlah Peserta</label>
                                            <div class="form-control-plaintext">
                                                <strong>{{ $item->jumlah_peserta }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="mb-0 text-muted">Metode Pelatihan</label>
                                            <div class="form-control-plaintext">
                                                <strong>{{ $item->metode_pelatihan }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Supply Details Table -->
                                <div class="table-responsive">
                                    <table
                                        class="table table-striped table-hover table-bordered align-middle mb-0 table-sm">
                                        <thead class="bg-light">
                                            <tr>
                                                <th width="5%">NO</th>
                                                <th>Nama Bahan/Barang</th>
                                                <th>Spesifikasi</th>
                                                <th width="15%">Satuan</th>
                                                <th width="10%">Jumlah</th>
                                                <th width="120px">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($item->details->isEmpty())
                                                <tr>
                                                    <td colspan="6" class="text-center text-muted py-3">
                                                        Tidak ada detail bahan/barang
                                                    </td>
                                                </tr>
                                            @else
                                                @foreach ($item->details as $detail)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $detail->nama_barang }}</td>
                                                        <td>{{ $detail->spesifikasi }}</td>
                                                        <td>{{ $detail->satuan }}</td>
                                                        <td class="text-center">{{ $detail->jumlah }}</td>
                                                        <td>
                                                            <div class="btn-group btn-group-sm" role="group">
                                                                <form
                                                                    action="{{ route('supplys.destroy-detail', ['document_id' => $document_id, 'supply_id' => $item->id, 'detail_id' => $detail->id]) }}"
                                                                    method="POST" style="display:inline;"
                                                                    class="form-delete-detail">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="button"
                                                                        class="btn btn-danger btn-sm btn-icon show_confirm"
                                                                        title="Hapus Detail">
                                                                        <i class="ti ti-trash"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            @if (!$loop->last)
                                <hr>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- jQuery --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
        var jq = jQuery.noConflict();

        jq(document).ready(function() {
            // Delete single detail
            jq(document).on("click", ".show_confirm", function(e) {
                e.preventDefault();

                let form = jq(this).closest("form");

                if (typeof Swal !== "undefined") {
                    Swal.fire({
                        title: "Yakin?",
                        text: "Detail bahan/barang akan dihapus!",
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
                    if (confirm('Yakin ingin menghapus detail?')) {
                        form.submit();
                    }
                }
            });

            // Delete all supply
            jq(document).on("click", ".show_confirm_all", function(e) {
                e.preventDefault();

                let form = jq(this).closest("form");

                if (typeof Swal !== "undefined") {
                    Swal.fire({
                        title: "Hapus Semua Bahan/Barang?",
                        text: "PERHATIAN! Semua data bahan/barang dan detailnya akan dihapus dan tidak bisa dikembalikan!",
                        icon: "error",
                        showCancelButton: true,
                        confirmButtonText: "Ya, hapus semua!",
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
                    if (confirm('PERHATIAN! Semua bahan/barang akan dihapus. Yakin?')) {
                        form.submit();
                    }
                }
            });
        });
    </script>
@endsection
