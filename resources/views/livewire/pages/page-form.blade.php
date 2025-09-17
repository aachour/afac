<div>
    <div class="row">
        <div class="col-xl">
            <form wire:submit="store" class="row g-3">

                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">{{ $editing ? "Edit" : "Create" }} Page</h5>
                            <a href="{{ route('pages') }}" class="btn btn-primary mb-2 text-nowrap">
                                Pages
                            </a>
                        </div>
                        <div class="card-body">

                            <div class="row">

                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="name">Page Name <span class="text-danger">*</span></label>
                                    <input
                                        wire:model="name"
                                        type="text"
                                        id="name"
                                        class="form-control"
                                        placeholder="Page Name" />
                                    @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="name_arabic">اسم الصفحة <span class="text-danger">*</span></label>
                                    <input
                                        wire:model="name_arabic"
                                        type="text"
                                        id="name_arabic"
                                        class="form-control"
                                        placeholder="اسم الصفحة" />
                                    @error('name_arabic') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="name">Meta Title <span class="text-danger">*</span></label>
                                    <input
                                        wire:model="meta_title"
                                        type="text"
                                        id="meta_title"
                                        class="form-control"
                                        placeholder="Meta Title" />
                                    @error('meta_title') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="name">عنوان الميتا  <span class="text-danger">*</span></label>
                                    <input
                                        wire:model="meta_title_arabic"
                                        type="text"
                                        id="meta_title_arabic"
                                        class="form-control"
                                        placeholder="عنوان الميتا " />
                                    @error('meta_title_arabic') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="name">Meta Description <span class="text-danger">*</span></label>
                                    <textarea
                                        wire:model="meta_description"
                                        id="meta_description"
                                        class="form-control"
                                        placeholder="Meta Description"></textarea>
                                    @error('meta_description') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="name">وصف الميتا <span class="text-danger">*</span></label>
                                    <textarea
                                        wire:model="meta_description_arabic"
                                        id="meta_description_arabic"
                                        class="form-control"
                                        placeholder="وصف الميتا"></textarea>
                                    @error('meta_description_arabic') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>


                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="name">Meta Keywords</label>
                                    <input
                                        wire:model="meta_keywords"
                                        type="text"
                                        id="meta_keywords"
                                        class="form-control"
                                        placeholder="Meta Keywords" />
                                    @error('meta_keywords') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="name">كلمات الميتا </label>
                                    <input
                                        wire:model="meta_keywords_arabic"
                                        type="text"
                                        id="meta_keywords_arabic"
                                        class="form-control"
                                        placeholder="كلمات الميتا " />
                                    @error('meta_keywords') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="name">Header Color <span class="text-danger">*</span></label>
                                    <select
                                        wire:model="header_color_id"
                                        id="header_color_id"
                                        class="form-control">
                                        <option value=''>Select Color</option>
                                        @foreach($colors as $color)
                                            <option value='{{$color->id}}'>{{$color->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('header_color_id') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="name">Footer Color <span class="text-danger">*</span></label>
                                    <select
                                        wire:model="footer_color_id"
                                        id="footer_color_id"
                                        class="form-control">
                                        <option value=''>Select Color</option>
                                        @foreach($colors as $color)
                                            <option value='{{$color->id}}'>{{$color->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('footer_color_id') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12 mt-4">
                                    <div class="form-check">
                                        <input wire:model="in_menu" type="checkbox" id="in_menu" class="form-check-input" @if($in_menu) checked @endif />
                                        <label for="in_menu" class="form-check-label">In Menu</label>
                                    </div>
                                </div>

                                <div class="col-12 mt-2">
                                    <div class="form-check">
                                        <input wire:model="published" type="checkbox" id="published" class="form-check-input" @if($published) checked @endif />
                                        <label for="published" class="form-check-label">Published</label>
                                    </div>
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
