<div>
    <div class="row">
        <div class="col-xl">
            <form wire:submit="store" class="row g-3">

                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">{{ $editing ? "Edit" : "Create" }} Event</h5>
                            <a href="{{ route('events') }}" class="btn btn-primary mb-2 text-nowrap">
                                Pages
                            </a>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                
                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="name">Category <span class="text-danger">*</span></label>
                                    <select
                                        wire:model="category_id"
                                        id="category_id"
                                        class="form-control">
                                        <option value=''>Select Type</option>
                                        @foreach($eventCategories as $category)
                                            <option value='{{$category->id}}'>{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="w-100 d-none d-md-block"></div>

                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="name">Title <span class="text-danger">*</span></label>
                                    <input
                                        wire:model="title"
                                        type="text"
                                        id="title"
                                        class="form-control"
                                        placeholder="Title" />
                                    @error('title') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="name">العنوان <span class="text-danger">*</span></label>
                                    <input
                                        wire:model="title_arabic"
                                        type="text"
                                        id="title_arabic"
                                        class="form-control"
                                        placeholder="العنوان" />
                                    @error('title_arabic') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>


                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="name">Date <span class="text-danger">*</span></label>
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
                                    <label class="form-label" for="name">From Time <span class="text-danger">*</span></label>
                                    <input
                                        wire:model="from_time"
                                        type="time"
                                        id="from_time"
                                        class="form-control"
                                        placeholder="From time" />
                                    @error('from_time') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="name">To Time <span class="text-danger">*</span></label>
                                    <input
                                        wire:model="to_time"
                                        type="time"
                                        id="to_time"
                                        class="form-control"
                                        placeholder="To Time" />
                                    @error('to_time') <div class="text-danger">{{ $message }}</div> @enderror
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
