<div>

    <div>
        
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-3">Pattern List</h4>
                @can('section-create')
                <div>
                    <button
                        data-bs-target="#patternModal"
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
                        <th>Shape</th>
                        <th>Shape Hover</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($patterns as $pattern)
                        <tr data-id="{{ $pattern->id }}" style="cursor: move;">
                            <td>{{$pattern->list_order}}</td>
                            <td>{{$pattern->button_text}}</td>
                            <td>{{$pattern->shape->name}}</td>
                            <td>{{$pattern->shapeHover->name}}</td>
                            <td>
                                @can('section-edit')
                                    <i  class="ti ti-edit ti-sm cursor-pointer"
                                        data-bs-target="#patternModal"
                                        data-bs-toggle="modal"
                                        wire:click="editEntry({{ $pattern->id }})"></i>
                                @endcan
                                @can('section-delete')
                                <a href="#" class="text-body delete-record delete-button" data-id="{{ $pattern->id }}"><i class="ti ti-trash ti-sm mx-2 text-danger"></i></a>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>

        <div wire:ignore.self class="modal fade" id="patternModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $modalId ? 'Edit' : 'Add' }} Entry</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        
                        <div class="row">

                            <div class="col-12 col-lg-6 mb-3">
                                <label for="button_text" class="form-label">Title</label>
                                <input type="text"
                                    class="form-control @error('button_text') is-invalid @enderror"
                                    id="button_text"
                                    wire:model="button_text"
                                    placeholder="Text" />
                                @error('button_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-lg-6 mb-3">
                                <label for="button_text_arabic" class="form-label">نص الزر</label>
                                <input type="text"
                                    class="form-control @error('button_text_arabic') is-invalid @enderror"
                                    id="title"
                                    wire:model="button_text_arabic"
                                    placeholder="نص الزر" />
                                @error('button_text_arabic')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!--Shape-->
                            <div class="col-12 col-lg-6 mb-3">
                                <label for="button_shape_id" class="form-label">Button shape</label>
                                <select
                                    wire:model="button_shape_id"
                                    id="button_shape_id"
                                    class="form-control">
                                    <option value=''>Select Shape</option>
                                    @foreach($shapes as $shape)
                                        <option value='{{$shape->id}}'>{{$shape->name}}</option>
                                    @endforeach
                                </select>
                                @error('button_shape_id') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12 col-lg-6 mb-3">
                                <label for="button_hover_shape_id" class="form-label">Button hover shape</label>
                                <select
                                    wire:model="button_hover_shape_id"
                                    id="button_hover_shape_id"
                                    class="form-control">
                                    <option value=''>Select Shape</option>
                                    @foreach($shapes as $shape)
                                        <option value='{{$shape->id}}'>{{$shape->name}}</option>
                                    @endforeach
                                </select>
                                @error('button_hover_shape_id') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <!--Text Color-->
                            <div class="col-12 col-lg-6 mb-3">
                                <label for="button_color_id" class="form-label">Button Text Color</label>
                                <select
                                    wire:model="button_color_id"
                                    id="button_color_id"
                                    class="form-control">
                                    <option value=''>Select Color</option>
                                    @foreach($colors as $color)
                                        <option value='{{$color->id}}'>{{$color->name}}</option>
                                    @endforeach
                                </select>
                                @error('button_color_id') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12 col-lg-6 mb-3">
                                <label for="button_hover_color_id" class="form-label">Button Hover Text Color</label>
                                <select
                                    wire:model="button_hover_color_id"
                                    id="button_hover_color_id"
                                    class="form-control">
                                    <option value=''>Select Color</option>
                                    @foreach($colors as $color)
                                        <option value='{{$color->id}}'>{{$color->name}}</option>
                                    @endforeach
                                </select>
                                @error('button_hover_color_id') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                            
                            <!--BG-->
                            <div class="col-12 col-lg-6 mb-3">
                                <label for="button_bg_color_id" class="form-label">Button Background Color</label>
                                <select
                                    wire:model="button_bg_color_id"
                                    id="button_bg_color_id"
                                    class="form-control">
                                    <option value=''>Select Color</option>
                                    @foreach($colors as $color)
                                        <option value='{{$color->id}}'>{{$color->name}}</option>
                                    @endforeach
                                </select>
                                @error('button_bg_color_id') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12 col-lg-6 mb-3">
                                <label for="button_hover_bg_color_id" class="form-label">Button hover Background Color</label>
                                <select
                                    wire:model="button_hover_bg_color_id"
                                    id="button_hover_bg_color_id"
                                    class="form-control">
                                    <option value=''>Select Color</option>
                                    @foreach($colors as $color)
                                        <option value='{{$color->id}}'>{{$color->name}}</option>
                                    @endforeach
                                </select>
                                @error('button_hover_bg_color_id') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <!--links-->
                            <div class="col-12 col-lg-6 mb-3">
                                <label for="button_link" class="form-label">Button Link</label>
                                <input type="text"
                                    class="form-control @error('button_link') is-invalid @enderror"
                                    id="button_link"
                                    wire:model="button_link"
                                    placeholder="Button Link" />
                                @error('button_link')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-lg-6 mb-3">
                                <label for="button_link_arabic" class="form-label">رابط الزر</label>
                                <input type="text"
                                    class="form-control @error('button_link_arabic') is-invalid @enderror"
                                    id="button_link_arabic"
                                    wire:model="button_link_arabic"
                                    placeholder="Button Link" />
                                @error('button_link_arabic')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                        <button 
                            type="button"
                            wire:click="saveEntry"
                            wire:loading.attr="disabled"
                            wire:target="saveEntry"
                            class="btn btn-primary"
                        >
                            <span wire:loading.remove wire:target="saveEntry">
                                {{ $modalId ? 'Update' : 'Save' }}
                            </span>

                            <span wire:loading wire:target="saveEntry">
                                Saving...
                            </span>
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

            document.addEventListener('DOMContentLoaded', function () {
                var modal = document.getElementById('patternModal');

                modal.addEventListener('hidden.bs.modal', function () {
                    Livewire.dispatch('reset-modal');
                });
            });


        </script>

    </div>

</div>