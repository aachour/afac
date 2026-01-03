<div>

    <div>
        
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-3">Entries List</h4>
                @can('section-create')
                <div>
                    <button
                        data-bs-target="#entryModal"
                        data-bs-toggle="modal"
                        class="btn btn-primary mb-2 text-nowrap" 
                        style="margin-top:8px;"
                        >Add Entry
                    </button>
                    &nbsp;&nbsp;
                    <a class="btn btn-primary h-50" href="{{ route('collections') }}">Back</a>
                </div>
                @endcan
            </div>
            <div class="card-datatable table-responsive" wire:ignore>
                <table class="table border-top" id="table">
                    <thead>
                    <tr>
                        <th>Order</th>
                        <th>Type</th>
                        <th>Title/Name</th>
                        <th>Title/Name Arabic</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($collection_entries as $collectionEntry)
                        <tr data-id="{{ $collectionEntry->id }}" style="cursor: move;">
                            <td>{{$collectionEntry->list_order}}</td>
                            <td>{{$collectionEntry->collection->type->name}}</td>
                            @if($collection_type_id==1)
                                <td>{{$collectionEntry->entry->event_title}}</td>
                                <td>{{$collectionEntry->entry->event_title_arabic}}</td>
                            @elseif($collection_type_id==2)
                                <td>{{$collectionEntry->entry->program_title}}</td>
                                <td>{{$collectionEntry->entry->program_title_arabic}}</td>
                            @elseif($collection_type_id==3)
                                <td>{{$collectionEntry->entry->project_title}}</td>
                                <td>{{$collectionEntry->entry->project_title_arabic}}</td>
                            @elseif($collection_type_id==4)
                                <td>{{$collectionEntry->entry->grantee_name}}</td>
                                <td>{{$collectionEntry->entry->grantee_name_arabic}}</td>
                            @elseif($collection_type_id==5)
                                <td>{{$collectionEntry->entry->jury_name}}</td>
                                <td>{{$collectionEntry->entry->jury_name_arabic}}</td>
                            @elseif($collection_type_id==6)
                                <td>{{$collectionEntry->entry->resource_title}}</td>
                                <td>{{$collectionEntry->entry->resource_title_arabic}}</td>
                            @elseif($collection_type_id==7)
                                <td>{{$collectionEntry->entry->news_title}}</td>
                                <td>{{$collectionEntry->entry->news_title_arabic}}</td>
                            @elseif($collection_type_id==8)
                                <td>{{$collectionEntry->entry->external_title}}</td>
                                <td>{{$collectionEntry->entry->external_title_arabic}}</td>
                            @elseif($collection_type_id==9)
                                <td>{{$collectionEntry->entry->team_name}}</td>
                                <td>{{$collectionEntry->entry->team_name_arabic}}</td>
                            @elseif($collection_type_id==10)
                                <td>{{$collectionEntry->entry->board_name}}</td>
                                <td>{{$collectionEntry->entry->board_name_arabic}}</td>
                            @endif
                            <td>
                                @can('collection-delete')
                                <a href="#" class="text-body delete-record delete-button" data-id="{{ $collectionEntry->id }}"><i class="ti ti-trash ti-sm mx-2 text-danger"></i></a>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div wire:ignore.self class="modal fade" id="entryModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $modalId ? 'Edit' : 'Add' }} Entries</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="entry_id" class="form-label">Entry</label>
                            <select wire:model="entry_id" id="entry_id" class="form-control">
                                <option value="">Select Entry</option>
                                @foreach($entries as $entry)
                                    @if($collection_type_id==1)
                                    <option value="{{ $entry->id }}">{{ $entry->event_title }}</option>
                                    @elseif($collection_type_id==2)
                                    <option value="{{ $entry->id }}">{{ $entry->program_title }}</option>
                                    @elseif($collection_type_id==3)
                                    <option value="{{ $entry->id }}">{{ $entry->project_title }}</option>
                                    @elseif($collection_type_id==4)
                                    <option value="{{ $entry->id }}">{{ $entry->grantee_name }}</option>
                                    @elseif($collection_type_id==5)
                                    <option value="{{ $entry->id }}">{{ $entry->jury_name}}</option>
                                    @elseif($collection_type_id==6)
                                    <option value="{{ $entry->id }}">{{ $entry->resource_title }}</option>
                                    @elseif($collection_type_id==7)
                                    <option value="{{ $entry->id }}">{{ $entry->news_title }}</option>
                                    @elseif($collection_type_id==8)
                                    <option value="{{ $entry->id }}">{{ $entry->external_title }}</option>
                                    @elseif($collection_type_id==9)
                                    <option value="{{ $entry->id }}">{{ $entry->team_name }}</option>
                                    @elseif($collection_type_id==10)
                                    <option value="{{ $entry->id }}">{{ $entry->board_name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                        <button type="button" wire:click="saveEntry" class="btn btn-primary">
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

            function InitiateTypesSelect2() {

                $('#entry_id').select2({
                    placeholder: 'Select Entry',
                    allowClear: true,
                    width: '100%',
                    dropdownParent: $('.modal-content') // Important for modal compatibility
                }).on('change', function(e) {
                    // Update Livewire property 
                    let selectedValue = $(this).val();
                    $wire.setEntryId(selectedValue);
                });

            }

        </script>
        @endscript

    </div>

</div>