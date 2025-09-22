<div>

    <div>
        
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-3">Sections List</h4>
                @can('section-create')
                <div>
                    <a class="btn btn-primary h-50" href="{{ route('sections.create',$page_id) }}">Add Section</a>
                    &nbsp;&nbsp;
                    <button wire:click="openModal()" class="btn btn-primary h-50">
                        Add Collection
                    </button>
                </div>
                @endcan
            </div>
            <div class="card-datatable table-responsive" wire:ignore>
                <table class="table dataTable border-top" id="table">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Type</th>
                        <th>In Menu</th>
                        <th>Published</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($pageSections as $pageSection)
                        <tr>
                            <td>{{ $pageSection->id }}</td>
                            <td>{{ $pageSection->name }}</td>
                            
                            <td>
                                @can('page-view')
                                <a href="{{ route('pages.view', $page_id) }}" class="text-body view-user-button"><i class="ti ti-eye ti-sm"></i></a>
                                @endcan
                                @can('section-edit')
                                <a href="{{ route('sections.edit', $page_id , $pageSection->id) }}" class="text-body edit-user-button"><i class="ti ti-edit ti-sm"></i></a>
                                @endcan
                                @can('section-delete')
                                <a href="#" class="text-body delete-record delete-button" data-id="{{ $pageSection->id }}"><i class="ti ti-trash ti-sm mx-2 text-danger"></i></a>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>

        @if($showModal)
            <div class="modal fade show" tabindex="-1" style="display: block; background-color: rgba(0,0,0,0.5)">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ $modalTitle }}</h5>
                            <button type="button" wire:click="closeModal" class="btn-close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3" wire:ignore>
                                <label for="type_id" class="form-label">Type</label>
                                <select id="type_id" class="form-control">
                                    <option value="">All Types</option>
                                    @foreach($types as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3" wire:ignore>
                                <label for="collection_id" class="form-label">Name</label>
                                <select id="collection_id" class="form-control">
                                    <option value="">Select Collection</option>
                                    @foreach($collections as $collection)
                                        <option value="{{ $collection->id }}">{{ $collection->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" wire:click="closeModal" class="btn btn-secondary">Cancel</button>
                            <button type="button" wire:click="saveType" class="btn btn-primary">
                                {{ $editingId ? 'Update' : 'Save' }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif


        @push('scripts')
            <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>

            <script>
                document.addEventListener('livewire:load', function () {
                    Livewire.on('modalOpened', () => {
                        console.log("!");
                        initSelect2();
                    });
                });

                function initSelect2() {
                    if ($('#type_id').hasClass("select2-hidden-accessible")) {
                        $('#type_id').select2('destroy');
                    }
                    if ($('#collection_id').hasClass("select2-hidden-accessible")) {
                        $('#collection_id').select2('destroy');
                    }

                    // Type select
                    $('#type_id').select2({
                        dropdownParent: $('#type_id').closest('.modal'),
                        width: '100%',
                        placeholder: "All Types",
                        allowClear: true
                    }).on('change', function () {
                        @this.set('type_id', $(this).val());
                    });

                    // Collection select
                    $('#collection_id').select2({
                        dropdownParent: $('#collection_id').closest('.modal'),
                        width: '100%',
                        placeholder: "Select Collection",
                        allowClear: true
                    }).on('change', function () {
                        @this.set('collection_id', $(this).val());
                    });
                }
            </script>
        @endpush


        @script
            @include('livewire.deleteConfirm')
        @endscript

    </div>

</div>