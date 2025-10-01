<div>

    <div>
        
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-3">General Inputs List</h4>
                @can('section-create')
                <div>
                    <button
                        data-bs-target="#generalInputsModal"
                        data-bs-toggle="modal"
                        class="btn btn-primary mb-2 text-nowrap" 
                        style="margin-top:2px;"
                        >Add Entry
                    </button>
                    <a href="{{ route('sections',$page_id) }}" class="btn btn-primary mb-2 text-nowrap">
                        Sections
                    </a>
                </div>
                @endcan
            </div>
            <div class="card-datatable table-responsive" wire:ignore>
                <table class="table border-top" id="table">
                    <thead>
                    <tr>
                        <th>Order</th>
                        <th>Type</th>
                        <th>Data</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($generalInputs as $generalInput)
                        <tr data-id="{{ $generalInput->id }}" style="cursor: move;">
                            <td>{{$generalInput->list_order}}</td>
                            <td>{{$generalInput->inputType?->name}}</td>
                            <td>
                                @if($generalInput->input_type_id==1)
                                    {{$generalInput->title}}
                                @elseif($generalInput->input_type_id==2)
                                    {{$generalInput->text}}
                                @elseif($generalInput->input_type_id==3)
                                    gallery images
                                @elseif($generalInput->input_type_id==4)
                                    {{$generalInput->video}}
                                @elseif($generalInput->input_type_id==5)
                                    {{$generalInput->percentage}}
                                @elseif($generalInput->input_type_id==6)
                                    {{$generalInput->button_value}}
                                @endif
                            </td>
                            <td>
                                @can('section-edit')
                                    <i  class="ti ti-edit ti-sm cursor-pointer"
                                        data-bs-target="#generalInputsModal"
                                        data-bs-toggle="modal"
                                        wire:click="editEntry({{ $generalInput->id }})"></i>
                                @endcan
                                @can('section-delete')
                                <a href="#" class="text-body delete-record delete-button" data-id="{{ $generalInput->id }}"><i class="ti ti-trash ti-sm mx-2 text-danger"></i></a>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>

        <div wire:ignore.self class="modal fade" id="generalInputsModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $modalId ? 'Edit' : 'Add' }} Entry</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="ColorName" class="form-label">Background Color</label>
                            <select
                                wire:model="bg_color_id"
                                id="bg_color_id"
                                class="form-control">
                                <option value=''>Select Color</option>
                                @foreach($colors as $color)
                                    <option value='{{$color->id}}'>{{$color->name}}</option>
                                @endforeach
                            </select>
                            @error('bg_color_id') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="ColorName" class="form-label">Input Type</label>
                            <select
                                wire:model.live="input_type_id"
                                id="input_type_id "
                                class="form-control" {{ $modalId ? 'disabled' : '' }}>
                                <option value=''>Select Input Type</option>
                                @foreach($inputTypes as $inputType)
                                    <option value='{{$inputType->id}}'>{{$inputType->name}}</option>
                                @endforeach
                            </select>
                            @error('input_type_id') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                        
                        @if($input_type_id==1)
                        <div class="mb-3">
                            <label for="ColorName" class="form-label">Title</label>
                            <input type="text"
                                class="form-control @error('title') is-invalid @enderror"
                                id="title"
                                wire:model="title"
                                placeholder="Title" />
                            @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        @endif

                        @if($input_type_id==2)
                        <div class="mb-3">
                            <label for="ColorCode" class="form-label">Text</label>
                            <textarea
                                class="form-control @error('text') is-invalid @enderror"
                                id="text"
                                wire:model="text"
                                placeholder="Text" style="height:200px; resize:none;"></textarea>
                            @error('text')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        @endif

                        @if($input_type_id==4)
                        <div class="mb-3">
                            <label for="ColorName" class="form-label">Video</label>
                            <input type="text"
                                class="form-control @error('video') is-invalid @enderror"
                                id="video"
                                wire:model="video"
                                placeholder="video" />
                            @error('video')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        @endif

                        @if($input_type_id==5)
                        <div class="mb-3">
                            <label for="ColorName" class="form-label">Pattern Percentage</label>
                            <input type="text"
                                class="form-control @error('percentage') is-invalid @enderror"
                                id="percentage"
                                wire:model="percentage"
                                placeholder="Percentage" />
                            @error('percentage')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        @endif

                        @if($input_type_id==6)
                        <div class="mb-3">
                            <label for="ColorName" class="form-label">Button Value</label>
                            <input type="text"
                                class="form-control @error('button_value') is-invalid @enderror"
                                id="button_value"
                                wire:model="button_value"
                                placeholder="button_value" />
                            @error('button_value')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="ColorName" class="form-label">Button Shape</label>
                            <input type="text"
                                class="form-control @error('button_shape') is-invalid @enderror"
                                id="button_shape"
                                wire:model="button_shape"
                                placeholder="button_shape" />
                            @error('button_shape')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="ColorName" class="form-label">Button Link</label>
                            <input type="text"
                                class="form-control @error('button_link') is-invalid @enderror"
                                id="button_link"
                                wire:model="button_link"
                                placeholder="button_link" />
                            @error('button_link')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        @endif

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