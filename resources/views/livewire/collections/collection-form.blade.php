<div>
    <div class="row">
        <div class="col-xl">

            <form wire:submit="store" class="row g-3">

                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">{{ $editing ? "Edit" : "Create" }} Collection</h5>
                            <a href="{{ route('collections') }}" class="btn btn-primary mb-2 text-nowrap">
                                Collections
                            </a>
                        </div>
                    </div>

                    @foreach ($errors->all() as $error)
                        {{$error}}
                    @endforeach

                    <div class="card mt-4">

                        <div class="card-body">

                            <div class="row">

                                <h5>General Info</h5>

                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="name">Type <span class="text-danger">*</span></label>
                                    <select
                                        wire:model="type_id"
                                        id="type_id"
                                        class="form-control">
                                        <option value=''>Select Type</option>
                                        @foreach($types as $type)
                                            <option value='{{$type->id}}'>{{$type->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('type_id') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="w-100 d-none d-md-block"></div>

                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="name">Name <span class="text-danger">*</span></label>
                                    <input
                                        wire:model="name"
                                        type="text"
                                        id="name"
                                        class="form-control"
                                        placeholder="Collection Name" />
                                    @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="name_arabic">اسم الصفحة <span class="text-danger">*</span></label>
                                    <input
                                        wire:model="name_arabic"
                                        type="text"
                                        id="name_arabic"
                                        class="form-control"
                                        placeholder="اسم المجموعة" />
                                    @error('name_arabic') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>


                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="name">Description</label>
                                    <textarea
                                        wire:model="description"
                                        id="description"
                                        class="form-control"
                                        placeholder="Description"></textarea>
                                    @error('description') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="name">الوصف</label>
                                    <textarea
                                        wire:model="description_arabic"
                                        id="description_arabic"
                                        class="form-control"
                                        placeholder="الوصف"></textarea>
                                    @error('description_arabic') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12 mt-2">
                                    <label class="form-label" for="name">Description Position</label>

                                    <div class="form-check mt-1">
                                        <input wire:model="description_position" type="radio" id="description_position_top" class="form-check-input" value="0" checked>
                                        <label for="description_position" class="form-check-label">Top</label>
                                    </div>

                                    <div class="form-check mt-1">
                                        <input wire:model="description_position" type="radio" id="description_position_bottom" class="form-check-input" value="1">
                                        <label for="description_position" class="form-check-label">Bottom</label>
                                    </div>
                                </div>

                                <div class="w-100 d-none d-md-block"></div>


                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="name">Background Color</label>
                                    <select
                                        wire:model="background_color_id"
                                        id="background_color_id"
                                        class="form-control">
                                        <option value=''>Select Color</option>
                                        @foreach($colors as $color)
                                            <option value='{{$color->id}}'>{{$color->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('background_color_id') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                            </div>

                        </div>

                    </div>
                    
                    <div class="card mt-4">

                        <div class="card-body">

                            <div class="row">

                                <h5>Style Info</h5>

                                <div class="col-12">
                                    <label class="form-label" for="name">With Filter? <span class="text-danger">*</span></label>

                                    <div class="form-check mt-1">
                                        <input wire:model="with_filters" type="radio" id="with_filters_no" class="form-check-input" value="0" checked>
                                        <label for="with_filters_no" class="form-check-label">No</label>
                                    </div>

                                    <div class="form-check mt-1">
                                        <input wire:model="with_filters" type="radio" id="with_filters_yes" class="form-check-input" value="1">
                                        <label for="with_filters_yes" class="form-check-label">Yes</label>
                                    </div>

                                </div>

                                <div class="col-12 mt-3">
                                    <label class="form-label" for="name">Title Position <span class="text-danger">*</span></label>

                                    <div class="form-check mt-1">
                                        <input wire:model="title_position" type="radio" id="title_position_top" class="form-check-input" value="0" checked>
                                        <label for="title_position_top" class="form-check-label">Top</label>
                                    </div>

                                    <div class="form-check mt-1">
                                        <input wire:model="title_position" type="radio" id="title_position_bottom" class="form-check-input" value="1">
                                        <label for="title_position_bottom" class="form-check-label">Bottom</label>
                                    </div>

                                </div>

                                <div class="col-12 mt-3">
                                    <label class="form-label" for="name">Show Labels <span class="text-danger">*</span></label>

                                    <div class="form-check mt-1">
                                        <input wire:model="with_label" type="radio" id="with_label" class="form-check-input" value="0" checked>
                                        <label for="with_label" class="form-check-label">No</label>
                                    </div>

                                    <div class="form-check mt-1">
                                        <input wire:model="with_label" type="radio" id="with_label" class="form-check-input" value="1">
                                        <label for="with_label" class="form-check-label">Yes</label>
                                    </div>

                                </div>

                            </div>
                        
                        </div>
                    
                    </div>

                    <div class="card mt-4">

                        <div class="card-body">

                            <div class="row">

                                <h5>Entries Info</h5>

                                <div class="col-12">
                                    <label class="form-label">Entries Selection <span class="text-danger">*</span></label>

                                    <div class="form-check mt-2">
                                        <input 
                                            wire:model.live="entries_selection" 
                                            type="radio" 
                                            name="entries_selection" 
                                            id="custom_entries" 
                                            class="form-check-input" 
                                            value="1"
                                        />
                                        <label for="custom_entries" class="form-check-label">Custom Entries</label>
                                    </div>

                                    <div class="form-check mt-2">
                                        <input 
                                            wire:model.live="entries_selection" 
                                            type="radio"  
                                            name="entries_selection" 
                                            id="system_entries" 
                                            class="form-check-input" 
                                            value="2"
                                        />
                                        <label for="system_entries" class="form-check-label">System Entries</label>
                                    </div>

                                </div>

                                <!-- Show fields if System Entries is selected -->
                                @if($entries_selection == 2)
                                    <div class="col-12 col-md-6 mt-3">
                                        <label class="form-label" for="entries_number">Number of Entries <span class="text-danger">*</span></label>
                                        <input
                                        wire:model.live="entries_number"
                                        type="text"
                                        id="entries_number"
                                        class="form-control"
                                        placeholder="Number of Entries" />
                                        
                                        @error('entries_number') 
                                            <div class="text-danger">{{ $message }}</div> 
                                        @enderror
                                    </div>

                                    <div class="col-12 mt-3">
                                        <label class="form-label">With Expired Entries? <span class="text-danger">*</span></label>

                                        <div class="form-check mt-2">
                                            <input 
                                                wire:model.live="entries_with_expired" 
                                                type="radio" 
                                                name="entries_with_expired" 
                                                id="custom_entries" 
                                                class="form-check-input" 
                                                value="0"
                                            />
                                            <label for="custom_entries" class="form-check-label">No</label>
                                        </div>

                                        <div class="form-check mt-2">
                                            <input 
                                                wire:model.live="entries_with_expired" 
                                                type="radio"  
                                                name="entries_with_expired" 
                                                id="system_entries" 
                                                class="form-check-input" 
                                                value="1"
                                            />
                                            <label for="entries_with_expired" class="form-check-label">Yes</label>
                                        </div>

                                        <div class="col-12 col-md-6 mt-3">
                                            <label class="form-label" for="name">Entries Order <span class="text-danger">*</span></label>
                                            <select
                                                wire:model.live="entries_order"
                                                id="entries_order"
                                                class="form-control">
                                                <option value=''>Select Order</option>
                                                @foreach($entries_order_options as $key=>$value)
                                                    <option value='{{$key}}'>{{$value}}</option>
                                                @endforeach
                                            </select>
                                            @error('entries_order') <div class="text-danger">{{ $message }}</div> @enderror
                                        </div>

                                    </div>
                                @endif
                            </div>

                        </div>

                    </div>

                    <div class="card mt-4">

                        <div class="card-body">

                            <div class="row">

                                <h5>Collection Layout</h5>

                                <div class="col-12">
                                    <label class="form-label">Layout View <span class="text-danger">*</span></label>

                                    <div class="form-check mt-2">
                                        <input 
                                            wire:model="entries_layout" 
                                            type="radio" 
                                            name="entries_layout" 
                                            id="listing_view" 
                                            class="form-check-input" 
                                            value="1"
                                        />
                                        <label for="custom_entries" class="form-check-label">Layout View</label>
                                    </div>

                                    <div class="form-check mt-2">
                                        <input 
                                            wire:model="entries_layout" 
                                            type="radio"  
                                            name="entries_layout" 
                                            id="slider_view" 
                                            class="form-check-input" 
                                            value="2"
                                        />
                                        <label for="system_entries" class="form-check-label">Slider View</label>
                                    </div>

                                </div>

                                <div class="col-12 col-md-6 mt-3">
                                    <label class="form-label" for="entries_number">Entries Per Row <span class="text-danger">*</span></label>
                                    <input
                                    wire:model.live="entries_per_row"
                                    type="text"
                                    id="entries_per_row"
                                    class="form-control"
                                    placeholder="Entries Per Raw" />
                                    
                                    @error('entries_per_row') 
                                        <div class="text-danger">{{ $message }}</div> 
                                    @enderror
                                </div>

                                <div class="col-12 mt-3">
                                    <label class="form-label">With Feautured Entry? <span class="text-danger">*</span></label>

                                    <div class="form-check mt-2">
                                        <input 
                                            wire:model.live="with_featured_image" 
                                            type="radio" 
                                            name="with_featured_image" 
                                            id="with_featured_image_no" 
                                            class="form-check-input" 
                                            value="0"
                                        />
                                        <label for="with_featured_image" class="form-check-label">No</label>
                                    </div>

                                    <div class="form-check mt-2">
                                        <input 
                                            wire:model.live="with_featured_image" 
                                            type="radio"  
                                            name="with_featured_image" 
                                            id="with_featured_image_yes" 
                                            class="form-check-input" 
                                            value="1"
                                        />
                                        <label for="with_featured_image" class="form-check-label">Yes</label>
                                    </div>

                                </div>

                                <!-- Show fields if System Entries is selected -->
                                @if($with_featured_image == 1)

                                    <div class="col-12 col-md-6 mt-3">
                                        <label class="form-label" for="name">Featured Image Width <span class="text-danger">*</span></label>
                                        <select
                                            wire:model.live="featured_image_width"
                                            id="featured_image_width"
                                            class="form-control">
                                            <option value=''>Select Width</option>
                                            @foreach($featured_image_width_options as $key=>$value)
                                                <option value='{{$key}}'>{{$value}}</option>
                                            @endforeach
                                        </select>
                                        @error('featured_image_width') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="w-100 d-none d-md-block"></div>

                                    <div class="col-12 col-md-6 mt-2">
                                        <label class="form-label" for="name">Featured Background Color</label>
                                        <select
                                            wire:model="featured_image_background_color_id"
                                            id="featured_image_background_color_id"
                                            class="form-control">
                                            <option value=''>Select Color</option>
                                            @foreach($colors as $color)
                                                <option value='{{$color->id}}'>{{$color->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('featured_image_background_color_id') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="w-100 d-none d-md-block"></div>

                                    <div class="col-12 col-md-6 mt-2">
                                        <label class="form-label" for="name">Featured Decription</label>
                                        <textarea
                                            wire:model="featured_image_description"
                                            id="featured_image_description"
                                            class="form-control"
                                            placeholder="Decription"></textarea>
                                        @error('featured_image_description') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-12 col-md-6 mt-2">
                                        <label class="form-label" for="name">الوصف</label>
                                        <textarea
                                            wire:model="featured_image_description_arabic"
                                            id="featured_image_description_arabic"
                                            class="form-control"
                                            placeholder="الوصف"></textarea>
                                        @error('featured_image_description_arabic') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>


                                    <div class="col-12 mt-2">
                                        <label class="form-label" for="name">Featured Description Position</label>

                                        <div class="form-check mt-1">
                                            <input wire:model="featured_image_description_position" type="radio" id="featured_image_description_position_top" class="form-check-input" value="0" checked>
                                            <label for="featured_image_description_position" class="form-check-label">Top</label>
                                        </div>

                                        <div class="form-check mt-1">
                                            <input wire:model="featured_image_description_position" type="radio" id="featured_image_description_bottom" class="form-check-input" value="1">
                                            <label for="featured_image_description_position" class="form-check-label">Bottom</label>
                                        </div>
                                    </div>

                                    
                                    
                                @endif
                            </div>

                        </div>

                    </div>

                </div>


                <div class="col-12 text-end mt-4">
                    <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                </div>

            </form>

        </div>
    </div>

</div>
