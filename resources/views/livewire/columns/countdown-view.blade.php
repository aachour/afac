<div>

    <div>
        
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-3">Countdown List</h4>
                @can('section-create')
                <div>
                    <button
                        data-bs-target="#countdownModal"
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
                        <th>Title</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($countdowns as $countdown)
                        <tr data-id="{{ $countdown->id }}" style="cursor: move;">
                            <td>{{$countdown->list_order}}</td>
                            <td>{{$countdown->title}}</td>
                            <td>{{$countdown->start_date}}</td>
                            <td>{{$countdown->end_date}}</td>
                            <td>
                                @can('section-edit')
                                    <i  class="ti ti-edit ti-sm cursor-pointer"
                                        data-bs-target="#countdownModal"
                                        data-bs-toggle="modal"
                                        wire:click="editEntry({{ $countdown->id }})"></i>
                                @endcan
                                @can('section-delete')
                                <a href="#" class="text-body delete-record delete-button" data-id="{{ $countdown->id }}"><i class="ti ti-trash ti-sm mx-2 text-danger"></i></a>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>

        <div wire:ignore.self class="modal fade" id="countdownModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $modalId ? 'Edit' : 'Add' }} Entry</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-12 col-lg-12 mb-3">
                                <label for="bg_color_id" class="form-label">Background Color</label>
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

                            <div class="col-12 col-lg-6 mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text"
                                    class="form-control @error('title') is-invalid @enderror"
                                    id="title"
                                    wire:model="title"
                                    placeholder="Title" />
                                @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-lg-6 mb-3">
                                <label for="title_arabic" class="form-label">العنوان</label>
                                <input type="text"
                                    class="form-control @error('title_arabic') is-invalid @enderror"
                                    id="title"
                                    wire:model="title_arabic"
                                    placeholder="العنوان" />
                                @error('title_arabic')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!--Dates-->
                            <div class="col-12 col-lg-6 mb-3">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date"
                                    class="form-control @error('start_date') is-invalid @enderror"
                                    id="start_date"
                                    wire:model="start_date"
                                    placeholder="Start Date" />
                                @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-lg-6 mb-3">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date"
                                    class="form-control @error('end_date') is-invalid @enderror"
                                    id="end_date"
                                    wire:model="end_date"
                                    placeholder="End Date" />
                                @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!--Time-->
                            <div class="col-12 col-lg-6 mb-3">
                                <label for="start_time" class="form-label">Start Time</label>
                                <input type="time"
                                    class="form-control @error('start_time') is-invalid @enderror"
                                    id="start_time"
                                    wire:model="start_time"
                                    placeholder="Start Time" />
                                @error('start_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-lg-6 mb-3">
                                <label for="end_time" class="form-label">End Time</label>
                                <input type="time"
                                    class="form-control @error('end_time') is-invalid @enderror"
                                    id="end_time"
                                    wire:model="end_time"
                                    placeholder="End Time" />
                                @error('end_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!--button Values-->
                            <div class="col-12 col-lg-6 mb-3">
                                <label for="button_value" class="form-label">Button Value</label>
                                <input type="text"
                                    class="form-control @error('button_value') is-invalid @enderror"
                                    id="button_value"
                                    wire:model="button_value" />
                                @error('button_value')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-lg-6 mb-3">
                                <label for="button_value_arabic" class="form-label">عنوان الزر</label>
                                <input type="text"
                                    class="form-control @error('button_value_arabic') is-invalid @enderror"
                                    id="button_value_arabic"
                                    wire:model="button_value_arabic" />
                                @error('button_value_arabic')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

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

            document.addEventListener('DOMContentLoaded', function () {
                var modal = document.getElementById('countdownModal');

                modal.addEventListener('hidden.bs.modal', function () {
                    Livewire.dispatch('reset-modal');
                });
            });

        </script>

    </div>

</div>