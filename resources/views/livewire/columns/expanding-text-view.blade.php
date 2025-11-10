<div>

    <div>
        
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-3">Expand Text List</h4>
                @can('section-create')
                <div>
                    <button
                        data-bs-target="#expandtextModal"
                        data-bs-toggle="modal"
                        class="btn btn-primary mb-2 text-nowrap" 
                        style="margin-top:2px;"
                        >Add Entry
                    </button>
                    @if(isset($page_id))
                        <a href="{{ route('sections',$page_id) }}" class="btn btn-primary mb-2 text-nowrap">Sections</a>
                    @elseif(isset($entry_id))
                        <a href="{{ route('entry.sections',$entry_id) }}" class="btn btn-primary mb-2 text-nowrap">Sections</a>
                    @endif
                </div>
                @endcan
            </div>
            <div class="card-datatable table-responsive" wire:ignore>
                <table class="table border-top" id="table">
                    <thead>
                    <tr>
                        <th>Order</th>
                        <th>Text</th>
                        <th>Visible</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($expandingTexts as $expandingText)
                        <tr data-id="{{ $expandingText->id }}" style="cursor: move;">
                            <td>{{$expandingText->list_order}}</td>
                            <td>{{$expandingText->text}}</td>
                            <td>{{$expandingText->visible}}</td>
                            <td>
                                @can('section-edit')
                                    <i  class="ti ti-edit ti-sm cursor-pointer"
                                        data-bs-target="#expandtextModal"
                                        data-bs-toggle="modal"
                                        wire:click="editEntry({{ $expandingText->id }})"></i>
                                @endcan
                                @can('section-delete')
                                <a href="#" class="text-body delete-record delete-button" data-id="{{ $expandingText->id }}"><i class="ti ti-trash ti-sm mx-2 text-danger"></i></a>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>

        <div wire:ignore.self class="modal fade" id="expandtextModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $modalId ? 'Edit' : 'Add' }} Entry</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-12 col-lg-12 mb-3">
                                <label for="text" class="form-label">Text</label>
                                <input type="text"
                                    class="form-control @error('text') is-invalid @enderror"
                                    id="text"
                                    wire:model="text"
                                    placeholder="text" />
                                @error('text')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-lg-12 mb-3">
                                <label for="text" class="form-label">Visible</label><br />
                                <input class="form-check-input" type="radio" id="visibleYes" value="1" wire:model="visible">
                                <label class="form-check-label" for="visibleYes">
                                    Yes
                                </label>
                                &nbsp;&nbsp;
                                <input class="form-check-input" type="radio" id="visibleNo" value="0" 
                                    wire:model="visible">
                                <label class="form-check-label" for="visibleNo">
                                    No
                                </label>
                                @error('text')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


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

    </div>

</div>