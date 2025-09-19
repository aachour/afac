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
                        <div class="card-body">

                            <div class="row">

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


                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="name">Background Color <span class="text-danger">*</span></label>
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

                                <div class="col-12 mt-3">
                                    <label class="form-label" for="name">With Filter? <span class="text-danger">*</span></label>

                                    <div class="form-check mt-1">
                                        <input wire:model="with_filters" type="radio" id="with_filters_yes" class="form-check-input" value="1">
                                        <label for="with_filters_yes" class="form-check-label">Yes</label>
                                    </div>

                                    <div class="form-check mt-1">
                                        <input wire:model="with_filters" type="radio" id="with_filters_no" class="form-check-input" value="0" checked>
                                        <label for="with_filters_no" class="form-check-label">No</label>
                                    </div>
                                </div>

                                <div class="col-12 mt-3">
                                    <label class="form-label">Entries Selection <span class="text-danger">*</span></label>

                                    <!-- Custom Entries -->
                                    <div class="form-check mt-2">
                                        <input 
                                            wire:model="entries_selection" 
                                            type="radio" 
                                            name="entries_selection" 
                                            id="custom_entries" 
                                            class="form-check-input" 
                                            value="1"
                                        />
                                        <label for="custom_entries" class="form-check-label">Custom Entries</label>
                                    </div>

                                    <!-- System Entries -->
                                    <div class="form-check mt-2">
                                        <input 
                                            wire:model="entries_selection" 
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
                                    <div class="col-12 col-md-6 mt-2">
                                        <label class="form-label" for="entries_number">Number of Entries <span class="text-danger">*</span></label>
                                        <input
                                        wire:model="entries_number"
                                        type="text"
                                        id="entries_number"
                                        class="form-control"
                                        placeholder="Number of Entries" />
                                        
                                        @error('entries_number') 
                                            <div class="text-danger">{{ $message }}</div> 
                                        @enderror
                                    </div>
                                @endif

                                {{$entries_selection}}

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
