<div>

    <div>
        
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-3">Timeline List</h4>
                @can('section-create')
                <div>
                    <button
                        data-bs-target="#timelineModal"
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
                        <th>Date</th>
                        <th>Content</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($timelines as $timeline)
                        <tr data-id="{{ $timeline->id }}" style="cursor: move;">
                            <td>{{$timeline->list_order}}</td>
                            <td>{{$timeline->date}}</td>
                            <td>
                                @if(count($timeline->percentages)>0)
                                    @foreach($timeline->percentages as $percentage)
                                        {{ !empty($percentage->title) ? 'Title: '.$percentage->title : '' }} <br />
                                    @endforeach
                                @endif
                            </td>
                            <td>
                                @can('section-edit')
                                    <i  class="ti ti-edit ti-sm cursor-pointer"
                                        data-bs-target="#timelineModal"
                                        data-bs-toggle="modal"
                                        wire:click="editEntry({{ $timeline->id }})"></i>
                                @endcan
                                @can('section-delete')
                                <a href="#" class="text-body delete-record delete-button" data-id="{{ $timeline->id }}"><i class="ti ti-trash ti-sm mx-2 text-danger"></i></a>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>

        <div wire:ignore.self class="modal fade" id="timelineModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $modalId ? 'Edit' : 'Add' }} Entry</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="ColorName" class="form-label">Date</label>
                            <input type="text"
                                class="form-control @error('date') is-invalid @enderror"
                                id="date"
                                wire:model="date"
                                placeholder="Date" />
                            @error('date')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @foreach($entries as $key=>$entry)

                            <div class="mt-3 mb-3 d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Timeline {{$key + 1}}</h5>
                                @if($key >= 1)
                                    <button type="button" wire:click="deleteEntry({{$key}})" class="btn btn-danger btn-sm">Delete</button>
                                @endif
                            </div>

                            <div class="row">
                                <div class="col-12 col-lg-4 mb-3">
                                    <label for="ColorName" class="form-label">Title</label>
                                    <input type="text"
                                        class="form-control @error('date') is-invalid @enderror"
                                        id="entries.{{$key}}.title"
                                        wire:model="entries.{{$key}}.title"
                                        placeholder="Title" />
                                    @error('entries.{{$key}}.title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 col-lg-4 mb-3">
                                    <label for="ColorName" class="form-label">Pattern Shape</label>
                                    <select
                                        wire:model="entries.{{$key}}.shape_id"
                                        id="entries.{{$key}}.shape_id"
                                        class="form-control">
                                        <option value=''>Select Shape</option>
                                        @foreach($shapes as $shape)
                                            <option value='{{$shape->id}}'>{{$shape->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('entries.{{$key}}.shape_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 col-lg-4 mb-3">
                                    <label for="ColorName" class="form-label">Pattern Percentage</label>
                                    <input type="text"
                                        class="form-control @error('percentage') is-invalid @enderror"
                                        id="entries.{{$key}}.percentage"
                                        wire:model="entries.{{$key}}.percentage"
                                        placeholder="Percentage" />
                                    @error('entries.{{$key}}.percentage')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="ColorCode" class="form-label">Text</label>
                                    <textarea
                                        class="form-control @error('text') is-invalid @enderror"
                                        id="entries.{{$key}}.text"
                                        wire:model="entries.{{$key}}.text"
                                        placeholder="Text" style="height:150px; resize:none;"></textarea>
                                    @error('entries.{{$key}}.text')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        @endforeach
                        
                        <div class="mb-3">
                            <button type="button" wire:click="addEntry" class="btn btn-primary">Add Percentage</button>
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