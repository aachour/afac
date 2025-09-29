<div>

    <div>
        
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-3">Sections List</h4>
                @can('section-create')
                <div>
                    <a class="btn btn-primary h-50" href="{{ route('sections.create',$page_id) }}">Add Section</a>
                    &nbsp;&nbsp;
                    <button
                        data-bs-target="#sectionModal"
                        data-bs-toggle="modal"
                        class="btn btn-primary mb-2 text-nowrap" 
                        style="margin-top:8px;"
                        >Add Collection
                    </button>
                </div>
                @endcan
            </div>
            <div class="card-datatable table-responsive" wire:ignore>
                <table class="table border-top" id="table">
                    <thead>
                    <tr>
                        <th>Order</th>
                        <th>Page</th>
                        <th>Type</th>
                        <th>Name</th>
                        <th>Columns</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($pageSections as $pageSection)
                        <tr data-id="{{ $pageSection->id }}" style="cursor: move;">
                            <td>{{$pageSection->list_order}}</td>
                            <td>{{$pageSection->page->name}}</td>
                            <td>
                                @if($pageSection->section_id!='')
                                    Section
                                @else
                                    Collection / {{$pageSection->collection->type->name}}
                                @endif
                            </td>
                            <td>
                                @if($pageSection->section_id!='')
                                    {{$pageSection->section->name}}
                                @else
                                    {{$pageSection->collection->name}}
                                @endif
                            </td>
                            <td>
                                @can('section-edit')
                                    @if($pageSection->section_id!='')
                                        @foreach($pageSection->sections->columns as $key=>$column)
                                        @if($column->type_id==1)
                                            <div class="mb-1"><a href="{{ route('general.inputs.view', [$page_id , $pageSection->section_id , $column->id]) }}" class="text-body edit-user-button">Column {{$key + 1}} <i class="ti ti-edit ti-sm"></i></a></div>
                                        @elseif($column->type_id==2)
                                            <div class="mb-1"><a href="{{ route('timeline.view', [$page_id , $pageSection->section_id , $column->id]) }}" class="text-body edit-user-button">Column {{$key + 1}} <i class="ti ti-edit ti-sm"></i></a></div>
                                        @elseif($column->type_id==3)
                                            <div class="mb-1"><a href="{{ route('accordion.view', [$page_id , $pageSection->section_id , $column->id]) }}" class="text-body edit-user-button">Column {{$key + 1}} <i class="ti ti-edit ti-sm"></i></a></div>
                                        @endif
                                        @endforeach
                                    @endif
                                @endcan
                            </td>
                            <td>
                                @can('page-view')
                                <a href="{{ route('pages.view', $page_id) }}" class="text-body view-user-button"><i class="ti ti-eye ti-sm"></i></a>
                                @endcan
                                @can('section-edit')
                                    @if($pageSection->section_id!='')
                                        <a href="{{ route('sections.edit', [$page_id , $pageSection->section_id]) }}" class="text-body edit-user-button"><i class="ti ti-edit ti-sm"></i></a>
                                    @else
                                        <i  class="ti ti-edit ti-sm cursor-pointer"
                                            data-bs-target="#sectionModal"
                                            data-bs-toggle="modal"
                                            wire:click="editCollection({{ $pageSection->id }},{{ $pageSection->collection_id }})"></i>
                                    @endif
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

        <div wire:ignore.self class="modal fade" id="sectionModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $modalId ? 'Edit' : 'Add' }} Collection</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="type_id" class="form-label">Type</label>
                            <select wire:model="type_id" id="type_id" class="form-control">
                                <option value="">All Types</option>
                                @foreach($types as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="collection_id" class="form-label">Name</label>
                            <select wire:model="collection_id" id="collection_id" class="form-control">
                                <option value="">Select Collection</option>
                                @foreach($collections as $collection)
                                    <option value="{{ $collection->id }}">{{ $collection->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                        <button type="button" wire:click="saveCollection" class="btn btn-primary">
                            {{ $modalId ? 'Update' : 'Save' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>


        @script
            @include('livewire.deleteConfirm')
        @endscript

        <script>
            //load table
            document.addEventListener('livewire:init', function() {
                const el = document.querySelector("tbody");

                if (el) {
                    Sortable.create(el, {
                        handle: 'td',
                        animation: 150,
                        onEnd: function(evt) {
                            const order = [];
                            el.querySelectorAll("tr").forEach((row) => {
                                order.push(row.getAttribute("data-id"));
                            });

                            Livewire.dispatch('updateOrder', {order: order});
                        }
                    });
                }
            });
        </script>
        
        @script
        <script>

            InitiateTypesSelect2();
            InitiateCollectionsSelect2();
            

            function InitiateTypesSelect2() {

                $('#type_id').select2({
                    placeholder: 'Select Collection Type',
                    allowClear: true,
                    width: '100%',
                    dropdownParent: $('.modal-content') // Important for modal compatibility
                }).on('change', function(e) {
                    // Update Livewire property 
                    let selectedValue = $(this).val();
                    $wire.setTypeId(selectedValue);
                });

            }

            function InitiateCollectionsSelect2(){

                $('#collection_id').select2({
                    placeholder: 'Select Collection',
                    allowClear: true,
                    width: '100%',
                    dropdownParent: $('.modal-content') // Important for modal compatibility
                }).on('change', function(e) {
                    // Update Livewire property 
                    let selectedValue = $(this).val();
                    $wire.setCollectionId(selectedValue);
                });

            }

            let prevTypeId = null;

            // Reinitialize Select2 after Livewire updates
            Livewire.hook('morph.updated', ({ el }) => {

                let newTypeId = $('#type_id').val();
                
                if (newTypeId !== prevTypeId) {
                    
                    prevTypeId = newTypeId;
                
                    // Destroy
                    if ($('#collection_id').hasClass("select2-hidden-accessible")) {
                        $('#collection_id').select2('destroy');
                    }
                    
                    // Re-initialize
                    setTimeout(() => {
                        InitiateCollectionsSelect2();
                    },100);

                }
                
            });

            //update collection value on edit
            document.addEventListener('EditCollection', (e) => {
                var collection_id=e.detail.collection_id;
                setTimeout(() => {
                    $("#collection_id").val(collection_id).trigger('change.select2');
                },100);
            });

        </script>
        @endscript

    </div>

</div>