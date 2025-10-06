<div>
    <div class="row">
        <div class="col-xl">
            <form wire:submit="store" class="row g-3">

                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">{{ $editing ? "Edit" : "Create" }} Event</h5>
                            <a href="{{ route('events') }}" class="btn btn-primary mb-2 text-nowrap">
                                Events
                            </a>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                
                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="category">Category <span class="text-danger">*</span></label>
                                    <select
                                        wire:model="category_id"
                                        id="category_id"
                                        class="form-control">
                                        <option value=''>Select Type</option>
                                        @foreach($categories as $category)
                                            <option value='{{$category->id}}'>{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="w-100 d-none d-md-block"></div>

                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="title">Title <span class="text-danger">*</span></label>
                                    <input
                                        wire:model="title"
                                        type="text"
                                        id="title"
                                        class="form-control"
                                        placeholder="Title" />
                                    @error('title') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="title_arabic">العنوان <span class="text-danger">*</span></label>
                                    <input
                                        wire:model="title_arabic"
                                        type="text"
                                        id="title_arabic"
                                        class="form-control"
                                        placeholder="العنوان" />
                                    @error('title_arabic') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>


                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="date">Date <span class="text-danger">*</span></label>
                                    <input
                                        wire:model="date"
                                        type="date"
                                        id="date"
                                        class="form-control"
                                        placeholder="Date" />
                                    @error('date') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="w-100 d-none d-md-block"></div>

                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="start_time">From Time <span class="text-danger">*</span></label>
                                    <input
                                        wire:model="start_time"
                                        type="time"
                                        id="start_time"
                                        class="form-control"
                                        placeholder="From time" />
                                    @error('start_time') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="end_time">To Time <span class="text-danger">*</span></label>
                                    <input
                                        wire:model="end_time"
                                        type="time"
                                        id="end_time"
                                        class="form-control"
                                        placeholder="To Time" />
                                    @error('end_time') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>


                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="category">Background Color</label>
                                    <select
                                        wire:model="background_color_id"
                                        id="background_color_id"
                                        class="form-control">
                                        <option value=''>Select Background</option>
                                        @foreach($colors as $color)
                                            <option value='{{$color->id}}'>{{$color->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('background_color_id') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="image_width">Image Width</label>
                                    <select
                                        wire:model="image_width"
                                        id="image_width"
                                        class="form-control">
                                        <option value=''>Select Type</option>
                                        @foreach($image_width_options as $key=>$value)
                                            <option value='{{$key}}'>{{$value}}</option>
                                        @endforeach
                                    </select>
                                    @error('image_width') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12 mt-2">
                                    <label class="form-label" for="image">Image</label>
                                    <x-filepond 
                                        wire:model="image"
                                        file-path="{{ $imagePreview ?? '' }}"
                                        delete-event="deleteImage"
                                        is-multiple="false" />
                                    @error('image') 
                                        <div class="text-danger">{{ $message }}</div> 
                                    @enderror
                                </div>


                                <div class="w-100 d-none d-md-block"></div>

                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="button_link">Button Link </label>
                                    <input
                                        wire:model="button_link"
                                        type="text"
                                        id="button_link"
                                        class="form-control"
                                        placeholder="Link" />
                                    @error('button_link') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="w-100 d-none d-md-block"></div>

                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="button_value">Button Text </label>
                                    <input
                                        wire:model="button_value"
                                        type="text"
                                        id="button_value"
                                        class="form-control"
                                        placeholder="Link" />
                                    @error('button_value') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="button_value_arabic">نص الزر</label>
                                    <input
                                        wire:model="button_value_arabic"
                                        type="text"
                                        id="button_value_arabic"
                                        class="form-control"
                                        placeholder="Link" />
                                    @error('button_value_arabic') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

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

    <script>
       
    </script>
</div>
