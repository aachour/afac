<div>

    <div>

        @if(session()->has('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-header border-bottom">
                <h4 class="card-title mb-0">Footer</h4>
            </div>
            <div class="card-body mt-4">
                <div class="row g-4">

                    {{-- Column 1 --}}
                    <div class="col-md-4">
                        <div class="card border h-100">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Column 1</h6>
                                <button type="button" wire:click="openModal(1)" class="btn btn-sm btn-primary">
                                    Add / Edit
                                </button>
                            </div>
                            <div class="card-body">
                                <p class="fw-semibold mb-1">{{ $footer->col1 ?? '—' }}</p>
                                <p class="text-muted mb-2">{{ $footer->col1_arabic ?? '—' }}</p>
                                @php $links1 = $footer->col1_links ?? []; @endphp
                                @if(count($links1))
                                    <ul class="list-unstyled mb-0">
                                        @foreach($links1 as $l)
                                            <li><a href="{{ $l['link'] ?? '#' }}" target="_blank">{{ $l['title'] ?? '' }}</a></li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Column 2 --}}
                    <div class="col-md-4">
                        <div class="card border h-100">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Column 2</h6>
                                <button type="button" wire:click="openModal(2)" class="btn btn-sm btn-primary">
                                    Add / Edit
                                </button>
                            </div>
                            <div class="card-body">
                                <p class="fw-semibold mb-1">{{ $footer->col2 ?? '—' }}</p>
                                <p class="text-muted mb-2">{{ $footer->col2_arabic ?? '—' }}</p>
                                @php $links2 = $footer->col2_links ?? []; @endphp
                                @if(count($links2))
                                    <ul class="list-unstyled mb-0">
                                        @foreach($links2 as $l)
                                            <li><a href="{{ $l['link'] ?? '#' }}" target="_blank">{{ $l['title'] ?? '' }}</a></li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Column 3 --}}
                    <div class="col-md-4">
                        <div class="card border h-100">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Column 3</h6>
                                <button type="button" wire:click="openModal(3)" class="btn btn-sm btn-primary">
                                    Add / Edit
                                </button>
                            </div>
                            <div class="card-body">
                                <p class="fw-semibold mb-1">{{ $footer->col3 ?? '—' }}</p>
                                <p class="text-muted mb-2">{{ $footer->col3_arabic ?? '—' }}</p>
                                @php $links3 = $footer->col3_links ?? []; @endphp
                                @if(count($links3))
                                    <ul class="list-unstyled mb-0">
                                        @foreach($links3 as $l)
                                            <li><a href="{{ $l['link'] ?? '#' }}" target="_blank">{{ $l['title'] ?? '' }}</a></li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>


        {{-- Shared Edit Modal --}}
        @if($showModal)
            <div class="modal fade show" tabindex="-1" style="display: block; background-color: rgba(0,0,0,0.5);">
                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title">Edit Column {{ $editingCol }}</h5>
                            <button type="button" wire:click="closeModal" class="btn-close"></button>
                        </div>

                        <div class="modal-body">

                            {{-- English text --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Column Text (English)</label>
                                <input type="text"
                                       class="form-control"
                                       wire:model="colText"
                                       placeholder="English column title">
                            </div>

                            {{-- Arabic text --}}
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Column Text (Arabic)</label>
                                <input type="text"
                                       class="form-control"
                                       wire:model="colTextArabic"
                                       placeholder="Arabic column title"
                                       dir="rtl">
                            </div>

                            <hr>

                            {{-- English Links --}}
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label class="form-label fw-semibold mb-0">English Links</label>
                                    <button type="button" wire:click="addLink" class="btn btn-sm btn-outline-primary">
                                        + Add Link
                                    </button>
                                </div>

                                @forelse($colLinks as $i => $link)
                                    <div class="row g-2 mb-2 align-items-center">
                                        <div class="col">
                                            <input type="text"
                                                   class="form-control form-control-sm"
                                                   wire:model="colLinks.{{ $i }}.title"
                                                   placeholder="Link title">
                                        </div>
                                        <div class="col">
                                            <input type="text"
                                                   class="form-control form-control-sm"
                                                   wire:model="colLinks.{{ $i }}.link"
                                                   placeholder="URL">
                                        </div>
                                        <div class="col-auto">
                                            <button type="button"
                                                    wire:click="removeLink({{ $i }})"
                                                    class="btn btn-sm btn-outline-danger">
                                                &times;
                                            </button>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-muted small mb-0">No English links yet. Click "+ Add Link" to add one.</p>
                                @endforelse
                            </div>

                            <hr>

                            {{-- Arabic Links --}}
                            <div class="mb-2">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label class="form-label fw-semibold mb-0">Arabic Links</label>
                                    <button type="button" wire:click="addArabicLink" class="btn btn-sm btn-outline-primary">
                                        + Add Link
                                    </button>
                                </div>

                                @forelse($colLinksArabic as $i => $link)
                                    <div class="row g-2 mb-2 align-items-center" dir="rtl">
                                        <div class="col">
                                            <input type="text"
                                                   class="form-control form-control-sm"
                                                   wire:model="colLinksArabic.{{ $i }}.title"
                                                   placeholder="عنوان الرابط">
                                        </div>
                                        <div class="col">
                                            <input type="text"
                                                   class="form-control form-control-sm"
                                                   wire:model="colLinksArabic.{{ $i }}.link"
                                                   placeholder="الرابط">
                                        </div>
                                        <div class="col-auto">
                                            <button type="button"
                                                    wire:click="removeArabicLink({{ $i }})"
                                                    class="btn btn-sm btn-outline-danger">
                                                &times;
                                            </button>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-muted small mb-0">No Arabic links yet. Click "+ Add Link" to add one.</p>
                                @endforelse
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="button" wire:click="closeModal" class="btn btn-secondary">Cancel</button>
                            <button type="button"
                                    wire:click="save"
                                    wire:loading.attr="disabled"
                                    wire:target="save"
                                    class="btn btn-primary">
                                <span wire:loading.remove wire:target="save">Save</span>
                                <span wire:loading wire:target="save">Saving…</span>
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        @endif

        @script
            @include('livewire.deleteConfirm')
        @endscript

    </div>

</div>

