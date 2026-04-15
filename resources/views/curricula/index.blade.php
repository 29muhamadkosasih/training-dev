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


            <!-- Card Kurikulum -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">

                    {{-- Header --}}
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">B. KURIKULUM PELATIHAN BERBASIS KOMPETENSI</h5>

                        <a href="{{ route('documents.show', $document_id) }}" class="btn btn-secondary" wire:navigate>
                            Kembali
                        </a>
                    </div>
                    <!-- Tombol Tambah -->
                    <div class="mb-3">
                        <a href="{{ route('curricula.create', $document_id) }}" wire:navigate class="btn btn-primary">Tambah
                            Kurikulum
                        </a>
                    </div>

                    <!-- Tabel Kurikulum -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered align-middle mb-0 table-sm">
                            <thead class="bg-primary">
                                <tr>
                                    <th class="text-white" width="1%">NO</th>
                                    <th class="text-white">MATERI PELATIHAN / KODE UNIT</th>
                                    <th class="text-white">PERKIRAAN WAKTU (JP) TEORI</th>
                                    <th class="text-white">PERKIRAAN WAKTU (JP) PRAKTEK</th>
                                    <th class="text-white">JUMLAH (JP)</th>
                                    <th class="text-white" width="120px">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- KELOMPOK INTI -->
                                @php $no = 1; @endphp
                                @forelse ($curricula->where('kelompok', 'inti') as $item)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>
                                            @if ($item->competenceCode)
                                                {{ $item->competenceCode->unit ?? '-' }}<br>
                                                <small class="text-muted">{{ $item->competenceCode->kode ?? '-' }}</small>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $item->perkiraan_waktu_teori ?? 0 }}</td>
                                        <td class="text-center">{{ $item->perkiraan_waktu_praktek ?? 0 }}</td>
                                        <td class="text-center fw-bold">{{ $item->jumlah ?? 0 }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('curricula.edit', [$document_id, $item->id]) }}"
                                                wire:navigate class="btn btn-warning btn-sm btn-icon" title="Edit">
                                                <i class="ti ti-edit"></i>
                                            </a>

                                            {{-- <form action="{{ route('curricula.destroy', [$document_id, $item->id]) }}"
                                                method="POST" class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')

                                                <button type="button" class="btn btn-danger btn-sm btn-icon show_confirm">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </form> --}}
                                        </td>
                                    </tr>
                                @empty
                                @endforelse

                                <!-- Subtotal Kelompok Inti -->
                                @if ($curricula->where('kelompok', 'inti')->count() > 0)
                                    <tr class="fw-bold bg-light">
                                        <td colspan="2">Jumlah I (Kelompok Inti)</td>
                                        <td class="text-center">{{ $subtotals['inti']['teori'] }}</td>
                                        <td class="text-center">{{ $subtotals['inti']['praktek'] }}</td>
                                        <td class="text-center">{{ $subtotals['inti']['jumlah'] }}</td>
                                        <td></td>
                                    </tr>
                                @endif

                                <!-- KELOMPOK PENUNJANG -->
                                @forelse ($curricula->where('kelompok', 'penunjang') as $item)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>
                                            @if ($item->competenceCode)
                                                {{ $item->competenceCode->unit ?? '-' }}<br>
                                                <small class="text-muted">{{ $item->competenceCode->kode ?? '-' }}</small>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $item->perkiraan_waktu_teori ?? 0 }}</td>
                                        <td class="text-center">{{ $item->perkiraan_waktu_praktek ?? 0 }}</td>
                                        <td class="text-center fw-bold">{{ $item->jumlah ?? 0 }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('curricula.edit', [$document_id, $item->id]) }}"
                                                wire:navigate class="btn btn-warning btn-sm btn-icon" title="Edit">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                            {{-- <form action="{{ route('curricula.destroy', [$document_id, $item->id]) }}"
                                                method="POST" class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')

                                                <button type="button" class="btn btn-danger btn-sm btn-icon show_confirm">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </form> --}}
                                        </td>
                                    </tr>
                                @empty
                                @endforelse

                                <!-- Subtotal Kelompok Penunjang -->
                                @if ($curricula->where('kelompok', 'penunjang')->count() > 0)
                                    <tr class="fw-bold bg-light">
                                        <td colspan="2">Jumlah II (Kelompok Penunjang)</td>
                                        <td class="text-center">{{ $subtotals['penunjang']['teori'] }}</td>
                                        <td class="text-center">{{ $subtotals['penunjang']['praktek'] }}</td>
                                        <td class="text-center">{{ $subtotals['penunjang']['jumlah'] }}</td>
                                        <td></td>
                                    </tr>
                                @endif

                                <!-- Total Kelompok I & II -->
                                @if ($curricula->where('kelompok', '!=', 'ojt')->count() > 0)
                                    <tr class="fw-bold bg-light">
                                        <td colspan="2">Jumlah I & II</td>
                                        <td class="text-center">{{ $subtotals['total']['teori'] }}</td>
                                        <td class="text-center">{{ $subtotals['total']['praktek'] }}</td>
                                        <td class="text-center">{{ $subtotals['total']['jumlah'] }}</td>
                                        <td></td>
                                    </tr>
                                @endif

                                <!-- KELOMPOK OJT -->
                                <tr class="table-secondary fw-bold">
                                    <td colspan="6">III. On the Job Training (OJT) / Pendampingan</td>
                                </tr>
                                @forelse ($curricula->where('kelompok', 'ojt') as $ojt)
                                    <tr>
                                        <td>-</td>
                                        <td>On the Job Training</td>
                                        <td colspan="2" class="text-center">{{ $ojt->ojt_bulan ?? '-' }} Bulan</td>
                                        <td></td>
                                        <td class="text-center">
                                            <a href="{{ route('curricula.edit', [$document_id, $ojt->id]) }}" wire:navigate
                                                class="btn btn-warning btn-sm btn-icon" title="Edit">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                            <form action="{{ route('curricula.destroy', [$document_id, $ojt->id]) }}"
                                                method="POST" class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')

                                                <button type="button" class="btn btn-danger btn-sm btn-icon show_confirm">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">
                                            <a href="{{ route('curricula.create', $document_id) }}" wire:navigate
                                                class="btn btn-sm btn-outline-primary">
                                                Tambah OJT
                                            </a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- jQuery --}}
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
