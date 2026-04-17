@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">

            <div class="card shadow-sm mb-4">
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        {{-- Kiri --}}
                        <h5 class="mb-0">C. SILABUS PELATIHAN BERBASIS KOMPETENSI</h5>

                        {{-- Kanan --}}
                        <div class="d-flex gap-2">
                            <a href="{{ route('documents.show', $document_id) }}" class="btn btn-secondary" wire:navigate>
                                Kembali
                            </a>

                            <a href="{{ route('silabus.create', $document_id) }}" class="btn btn-primary" wire:navigate>
                                Tambah Silabus
                            </a>
                        </div>

                    </div>
                    {{-- Tabel --}}
                    @if ($silabus)
                        <div class="table-responsive mt-3">
                            <table class="table table-striped table-hover table-bordered align-middle mb-0 table-sm">
                                <thead class="bg-primary">
                                    <tr>
                                        <th width="1px" class="text-white">No. </th>
                                        <th class="text-white">Unit Kompetensi</th>
                                        <th class="text-white">Elemen Kompetensi</th>
                                        <th class="text-white text-center" width="150">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($silabus as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->unitKompetensi->unit ?? '-' }}</td>
                                            <td>
                                                @php
                                                    $elemenList = \App\Models\CompetenceCodeElement::where(
                                                        'competence_code_id',
                                                        $item->unitKompetensi->id,
                                                    )
                                                        ->orderBy('number', 'asc')
                                                        ->get();

                                                @endphp

                                                @foreach ($elemenList as $element)
                                                    <span class="badge bg-info mb-1">{{ $element->element }}</span><br>
                                                @endforeach
                                            </td>
                                            <td class="text-center">
                                                {{-- Edit --}}
                                                <a href="{{ route('silabus.edit.unit', [$document_id, $item->unit_kompetensi_id]) }}"
                                                    class="btn btn-primary btn-sm btn-icon" title="Edit">
                                                    <i class="ti ti-pencil"></i>
                                                </a>

                                                {{-- Delete --}}
                                                <form
                                                    action="{{ route('silabus.destroy.unit', [$document_id, $item->unit_kompetensi_id]) }}"
                                                    method="POST" class="d-inline delete-form">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="button"
                                                        class="btn btn-danger btn-sm btn-icon show_confirm" title="Hapus">
                                                        <i class="ti ti-trash"></i>
                                                    </button>
                                                </form>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info mt-3">
                            Belum ada informasi silabus.
                        </div>
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
