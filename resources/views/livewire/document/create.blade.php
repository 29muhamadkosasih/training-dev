<div>
    <div class="row justify-content-center">
        <div class="col-12 col-lg-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0 text-center">Tambah Data</h5>
                </div>

                <div class="card-body">
                    <form wire:submit.prevent='store'>
                        <div class="mb-2">
                            <label class="mb-2">Skema Kompetensi</label>

                            {{-- Search Livewire --}}
                            <input type="text"
                                class="form-control mb-2"
                                placeholder="Cari nama skema..."
                                wire:model.live="search">

                            {{-- Select --}}
                            <select name="competence_id"
                                wire:model="competence_id"
                                class="form-select @error('competence_id') is-invalid @enderror"
                                required>

                                <option value="">Pilih Skema Kompetensi</option>

                                @foreach ($competence as $items)
                                    <option value="{{ $items->id }}">
                                        {{ $items->scheme->name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('competence_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="text-end mt-3">
                            <a href="{{ route('documents.index') }}" class="btn btn-secondary me-2" wire:navigate>
                                Kembali
                            </a>
                            <button type="button" class="btn btn-outline-secondary me-2" wire:click="resetInput">
                                Reset
                            </button>
                            <button type="submit" class="btn btn-primary">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>