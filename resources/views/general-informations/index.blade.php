@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">

            <div class="card shadow-sm mb-4">
                <div class="card-body">

                    {{-- Header --}}
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">A. INFORMASI UMUM</h5>

                        <a href="{{ route('documents.show', $document_id) }}" class="btn btn-secondary" wire:navigate>
                            Kembali
                        </a>
                    </div>

                    {{-- Tabel --}}
                    @if ($generalInformation)
                        <div class="table-responsive mt-3">
                            <table class="table table-striped table-hover table-bordered align-middle mb-0 table-sm">
                                <thead class="bg-primary">
                                    <tr>
                                        <th class="text-white">Kode</th>
                                        <th class="text-white">Jenis Program</th>
                                        <th class="text-white text-center" width="150">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $generalInformation->kode ?? '-' }}</td>
                                        <td>{{ $generalInformation->jenis_program ?? '-' }}</td>
                                        <td class="text-center">

                                            {{-- Edit --}}
                                            <a href="{{ route('general-informations.edit', [$document_id, $generalInformation->id]) }}" wire:navigate
                                                class="btn btn-warning btn-sm btn-icon">
                                                <i class="ti ti-edit"></i>
                                            </a>

                                            {{-- Delete --}}
                                            <form
                                                action="{{ route('general-informations.destroy', [$document_id, $generalInformation->id]) }}"
                                                method="POST" class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')

                                                <button type="button" class="btn btn-danger btn-sm btn-icon show_confirm">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </form>

                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info mt-3">
                            Belum ada informasi umum.
                            <a href="{{ route('general-informations.create', $document_id) }}" wire:navigate>
                                <em>Tambah Informasi Umum</em>
                            </a>
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
