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
                    <a class="btn btn-primary h-50" href="{{ route('collections') }}">Collections</a>
                </div>
                @endcan
            </div>
            <div class="card-datatable table-responsive" wire:ignore>
                <table class="table border-top" id="table">
                    <thead>
                    <tr>
                        <th>Order</th>
                        <th>Type</th>
                        <th>Title</th>
                        <th>Title Arabic</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($collection_entries as $entry)
                        <tr data-id="{{ $entry->id }}" style="cursor: move;">
                            <td>{{$entry->list_order}}</td>
                            <td>{{$entry->collection->type->name}}</td>
                            @if($collection_type_id==1)
                            <td>{{$entry->event->title}}</td>
                            <td>{{$entry->event->title_arabic}}</td>
                            @endif
                            <td>
                                @can('collection-delete')
                                <a href="#" class="text-body delete-record delete-button" data-id="{{ $entry->id }}"><i class="ti ti-trash ti-sm mx-2 text-danger"></i></a>
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
                            <label for="entry_id" class="form-label">Type</label>
                            <select wire:model="entry_id" id="entry_id" class="form-control">
                                <option value="">Select Entry</option>
                                @foreach($entries as $entry)
                                    <option value="{{ $entry->id }}">{{ $entry->title }}</option>
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