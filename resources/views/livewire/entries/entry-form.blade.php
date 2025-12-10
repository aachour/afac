<div>
    <div class="row">
        <div class="col-xl">
            <form wire:submit="store" class="row g-3">

                <div class="col-12">

                    <!--Common Entries-->
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">{{ $editing ? "Edit" : "Create" }} {{$type_name}}</h5>
                            <a href="{{ route('entries',['typeId'=>$type_id]) }}" class="btn btn-primary mb-2 text-nowrap">
                                Back
                            </a>
                        </div>

                        <div class="card-body">

                            <div class="row">

                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="header_color_id">Header Color</label>
                                    <select
                                        wire:model="header_color_id"
                                        id="header_color_id"
                                        class="form-control">
                                        <option value=''>Select Background</option>
                                        @foreach($colors as $color)
                                            <option value='{{$color->id}}'>{{$color->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('header_color_id') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>
                    
                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="footer_color_id">Footer Color</label>
                                    <select
                                        wire:model="footer_color_id"
                                        id="footer_color_id"
                                        class="form-control">
                                        <option value=''>Select Background</option>
                                        @foreach($colors as $color)
                                            <option value='{{$color->id}}'>{{$color->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('footer_color_id') <div class="text-danger">{{ $message }}</div> @enderror
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

                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="category">Image Bg Color</label>
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

                                <div class="col-12 mt-3">
                                    <label class="form-label" for="image_featured">Featured Image [1000x1000px]</label>
                                    <x-filepond 
                                        wire:model="image_featured"
                                        file-path="{{ $imageFeaturedPreview ?? '' }}"
                                        delete-event="deleteImage"
                                        is-multiple="false" />
                                    @error('image_featured') 
                                        <div class="text-danger">{{ $message }}</div> 
                                    @enderror
                                </div>

                                <div class="col-12 mt-3 @if($type_id!=6 && $type_id!=7) d-none @endif">
                                    <label class="form-label" for="image_full">Full Image [1920x450px]</label>
                                    <x-filepond 
                                        wire:model="image_full"
                                        file-path="{{ $imageFullPreview ?? '' }}"
                                        delete-event="deleteImage"
                                        is-multiple="false" />
                                    @error('image_featured') 
                                        <div class="text-danger">{{ $message }}</div> 
                                    @enderror
                                </div>

                                <div class="col-12 mt-2">
                                    <label class="form-label" for="image">Image [640x900px]</label>
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


                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="button_shape_id">Button Shape </label>
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

                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="button_hover_shape_id">Button Hover Shape</label>
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

                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="button_bg_color_id">Button Color</label>
                                    <select
                                        wire:model="button_bg_color_id"
                                        id="button_bg_color_id"
                                        class="form-control">
                                        <option value=''>Select Background</option>
                                        @foreach($colors as $color)
                                            <option value='{{$color->id}}'>{{$color->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('button_bg_color_id') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                 <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="button_hover_bg_color_id">Button Hover Color</label>
                                    <select
                                        wire:model="button_hover_bg_color_id"
                                        id="button_hover_bg_color_id"
                                        class="form-control">
                                        <option value=''>Select Background</option>
                                        @foreach($colors as $color)
                                            <option value='{{$color->id}}'>{{$color->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('button_hover_bg_color_id') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

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

                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="button_link_arabic">رابط الزر</label>
                                    <input
                                        wire:model="button_link_arabic"
                                        type="text"
                                        id="button_link_arabic"
                                        class="form-control"
                                        placeholder="Link" />
                                    @error('button_link_arabic') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="w-100 d-none d-md-block"></div>

                            </div>

                        </div>

                    </div>


                    <!--Event-->
                    <div class="card mt-5 @if($type_id!=1) d-none @endif">

                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Event Details</h5>
                        </div>

                        <div class="card-body">

                            <div class="row">

                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="event_category_id">Category <span class="text-danger">*</span></label>
                                    <select
                                        wire:model="event_category_id"
                                        id="event_category_id"
                                        class="form-control">
                                        <option value=''>Select Type</option>
                                        @foreach($event_categories as $category)
                                            <option value='{{$category->id}}'>{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('event_category_id') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="w-100 d-none d-md-block"></div>

                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="event_title">Title <span class="text-danger">*</span></label>
                                    <input
                                        wire:model="event_title"
                                        type="text"
                                        id="event_title"
                                        class="form-control"
                                        placeholder="Title" />
                                    @error('event_title') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="event_title_arabic">العنوان <span class="text-danger">*</span></label>
                                    <input
                                        wire:model="event_title_arabic"
                                        type="text"
                                        id="event_title_arabic"
                                        class="form-control"
                                        placeholder="العنوان" />
                                    @error('event_title_arabic') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12 col-md-6 mt-2" wire:ignore>
                                    <label class="form-label" for="event_text">Text</label>
                                    <textarea wire:ignore
                                        wire:model="event_text"
                                        type="text"
                                        id="event_text"
                                        class="form-control txtEditor" placeholder="Text"></textarea>
                                    @error('event_text') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12 col-md-6 mt-2" wire:ignore>
                                    <label class="form-label" for="event_text_arabic">النص </label>
                                    <textarea wire:ignore
                                        wire:model="event_text_arabic"
                                        type="text"
                                        id="event_text_arabic"
                                        class="form-control txtEditor"
                                        placeholder="النص"></textarea>
                                    @error('event_text_arabic') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>


                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="event_date">Date <span class="text-danger">*</span></label>
                                    <input
                                        wire:model="event_date"
                                        type="date"
                                        id="event_date"
                                        class="form-control"
                                        placeholder="Date" />
                                    @error('event_date') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="w-100 d-none d-md-block"></div>

                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="event_start_time">From Time <span class="text-danger">*</span></label>
                                    <input
                                        wire:model="event_start_time"
                                        type="time"
                                        id="event_start_time"
                                        class="form-control"
                                        placeholder="From time" />
                                    @error('event_start_time') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="event_end_time">To Time <span class="text-danger">*</span></label>
                                    <input
                                        wire:model="event_end_time"
                                        type="time"
                                        id="event_end_time"
                                        class="form-control"
                                        placeholder="To Time" />
                                    @error('event_end_time') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                            </div>

                        </div>


                    </div>


                    <!--Program-->
                    <div class="card mt-5 @if($type_id!=2) d-none @endif">

                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Program Details</h5>
                        </div>

                        <div class="card-body">

                            <div class="row">

                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="program_title">Title <span class="text-danger">*</span></label>
                                    <input
                                        wire:model="program_title"
                                        type="text"
                                        id="program_title"
                                        class="form-control"
                                        placeholder="Title" />
                                    @error('program_title') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="program_title_arabic">العنوان <span class="text-danger">*</span></label>
                                    <input
                                        wire:model="program_title_arabic"
                                        type="text"
                                        id="program_title_arabic"
                                        class="form-control"
                                        placeholder="العنوان" />
                                    @error('program_title_arabic') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12 col-md-6 mt-2" wire:ignore>
                                    <label class="form-label" for="program_text">Text</label>
                                    <textarea wire:ignore
                                        wire:model="program_text"
                                        type="text"
                                        id="program_text"
                                        class="form-control txtEditor" placeholder="Text"></textarea>
                                    @error('program_text') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12 col-md-6 mt-2" wire:ignore>
                                    <label class="form-label" for="program_text_arabic">النص </label>
                                    <textarea wire:ignore
                                        wire:model="program_text_arabic"
                                        type="text"
                                        id="program_text_arabic"
                                        class="form-control txtEditor"
                                        placeholder="النص"></textarea>
                                    @error('program_text_arabic') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                            </div>

                        </div>


                    </div>


                    <!--Project-->
                    <div class="card mt-5 @if($type_id!=3) d-none @endif">

                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Project Details</h5>
                        </div>

                        <div class="card-body">

                            <div class="row">

                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="project_category_id">Category <span class="text-danger">*</span></label>
                                    <select
                                        wire:model="project_category_id"
                                        id="project_category_id"
                                        class="form-control">
                                        <option value=''>Select Type</option>
                                        @foreach($project_categories as $category)
                                            <option value='{{$category->id}}'>{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('project_category_id') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="w-100 d-none d-md-block"></div>

                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="project_title">Title <span class="text-danger">*</span></label>
                                    <input
                                        wire:model="project_title"
                                        type="text"
                                        id="project_title"
                                        class="form-control"
                                        placeholder="Title" />
                                    @error('project_title') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="project_title_arabic">العنوان <span class="text-danger">*</span></label>
                                    <input
                                        wire:model="project_title_arabic"
                                        type="text"
                                        id="project_title_arabic"
                                        class="form-control"
                                        placeholder="العنوان" />
                                    @error('project_title_arabic') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12 col-md-6 mt-2" wire:ignore>
                                    <label class="form-label" for="project_text">Text</label>
                                    <textarea wire:ignore
                                        wire:model="project_text"
                                        type="text"
                                        id="project_text"
                                        class="form-control txtEditor" placeholder="Text"></textarea>
                                    @error('project_text') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12 col-md-6 mt-2" wire:ignore>
                                    <label class="form-label" for="project_text_arabic">النص </label>
                                    <textarea wire:ignore
                                        wire:model="project_text_arabic"
                                        type="text"
                                        id="project_text_arabic"
                                        class="form-control txtEditor"
                                        placeholder="النص"></textarea>
                                    @error('project_text_arabic') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12 col-md-6 mt-2" wire:ignore>
                                    <label class="form-label" for="project_countries_id">Countries <span class="text-danger">*</span></label>
                                    <select
                                        wire:model="project_countries_id"
                                        id="project_countries_id"
                                        class="form-control"
                                        multiple>
                                        @foreach($countries as $country)
                                            <option value='{{$country->id}}'>{{$country->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('project_countries_id') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="w-100 d-none d-md-block"></div>

                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="program_id">Program <span class="text-danger">*</span></label>
                                    <select
                                        wire:model="program_id"
                                        wire:change="UpdateProgramYears"
                                        id="program_id"
                                        class="form-control">
                                        <option value=''>Select Program</option>
                                        @foreach($programs as $program)
                                            <option value='{{$program->id}}'>{{$program->program_title}}</option>
                                        @endforeach
                                    </select>
                                    @error('program_id') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="program_year_id">Year <span class="text-danger">*</span></label>
                                    <select
                                        wire:model="program_year_id"
                                        id="program_year_id"
                                        class="form-control">
                                        <option value=''>Select Year</option>
                                        @foreach($programYears as $year)
                                            <option value='{{$year->id}}'>{{$year->year}}</option>
                                        @endforeach
                                    </select>
                                    @error('program_year_id') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                            </div>

                        </div>

                    </div>


                    <!--Grantee-->
                    <div class="card mt-5 @if($type_id!=4) d-none @endif">

                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Grantee Details</h5>
                        </div>

                        <div class="card-body">

                            <div class="row">

                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="grantee_name">Name <span class="text-danger">*</span></label>
                                    <input
                                        wire:model="grantee_name"
                                        type="text"
                                        id="grantee_name"
                                        class="form-control"
                                        placeholder="Name" />
                                    @error('grantee_name') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="grantee_name_arabic">الإسم <span class="text-danger">*</span></label>
                                    <input
                                        wire:model="grantee_name_arabic"
                                        type="text"
                                        id="grantee_name_arabic"
                                        class="form-control"
                                        placeholder="الإسم" />
                                    @error('grantee_name_arabic') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12 col-md-6 mt-2" wire:ignore>
                                    <label class="form-label" for="grantee_text">Text</label>
                                    <textarea wire:ignore
                                        wire:model="grantee_text"
                                        type="text"
                                        id="grantee_text"
                                        class="form-control txtEditor" placeholder="Text"></textarea>
                                    @error('grantee_text') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12 col-md-6 mt-2" wire:ignore>
                                    <label class="form-label" for="grantee_text_arabic">النص </label>
                                    <textarea wire:ignore
                                        wire:model="grantee_text_arabic"
                                        type="text"
                                        id="grantee_text_arabic"
                                        class="form-control txtEditor"
                                        placeholder="النص"></textarea>
                                    @error('grantee_text_arabic') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="grantee_country_id">Country <span class="text-danger">*</span></label>
                                    <select
                                        wire:model="grantee_country_id"
                                        id="grantee_country_id"
                                        class="form-control">
                                        <option value=''>Select Country</option>
                                        @foreach($countries as $country)
                                            <option value='{{$country->id}}'>{{$country->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('grantee_country_id') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>
                                

                            </div>

                        </div>


                    </div>


                    <!--Jury-->
                    <div class="card mt-5 @if($type_id!=5) d-none @endif">

                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Jury Details</h5>
                        </div>

                        <div class="card-body">

                            <div class="row">

                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="jury_name">Name <span class="text-danger">*</span></label>
                                    <input
                                        wire:model="jury_name"
                                        type="text"
                                        id="jury_name"
                                        class="form-control"
                                        placeholder="Name" />
                                    @error('jury_name') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="jury_name_arabic">الإسم <span class="text-danger">*</span></label>
                                    <input
                                        wire:model="jury_name_arabic"
                                        type="text"
                                        id="jury_name_arabic"
                                        class="form-control"
                                        placeholder="الإسم" />
                                    @error('jury_name_arabic') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12 col-md-6 mt-2" wire:ignore>
                                    <label class="form-label" for="jury_text">Biography <span class="text-danger">*</span></label>
                                    <textarea wire:ignore
                                        wire:model="jury_text"
                                        type="text"
                                        id="jury_text"
                                        class="form-control txtEditor" placeholder="Biography"></textarea>
                                    @error('jury_text') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12 col-md-6 mt-2" wire:ignore>
                                    <label class="form-label" for="jury_text_arabic">السيرة الذاتية <span class="text-danger">*</span></label>
                                    <textarea wire:ignore
                                        wire:model="jury_text_arabic"
                                        type="text"
                                        id="jury_text_arabic"
                                        class="form-control txtEditor"
                                        placeholder="السيرة الذاتية"></textarea>
                                    @error('jury_text_arabic') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="jury_country_id">Country <span class="text-danger">*</span></label>
                                    <select
                                        wire:model="jury_country_id"
                                        id="jury_country_id"
                                        class="form-control">
                                        <option value=''>Select Country</option>
                                        @foreach($countries as $country)
                                            <option value='{{$country->id}}'>{{$country->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('jury_country_id') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                            </div>

                        </div>


                    </div>


                    <!--Resource-->
                    <div class="card mt-5 @if($type_id!=6) d-none @endif">

                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Resource Details</h5>
                        </div>

                        <div class="card-body">

                            <div class="row">

                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="resource_title">Title <span class="text-danger">*</span></label>
                                    <input
                                        wire:model="resource_title"
                                        type="text"
                                        id="resource_title"
                                        class="form-control"
                                        placeholder="Title" />
                                    @error('resource_title') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="resource_title_arabic">العنوان <span class="text-danger">*</span></label>
                                    <input
                                        wire:model="resource_title_arabic"
                                        type="text"
                                        id="resource_title_arabic"
                                        class="form-control"
                                        placeholder="العنوان" />
                                    @error('resource_title_arabic') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>


                                <div class="col-12 col-md-6 mt-2" wire:ignore>
                                    <label class="form-label" for="resource_text">Text</label>
                                    <textarea wire:ignore
                                        wire:model="resource_text"
                                        type="text"
                                        id="resource_text"
                                        class="form-control txtEditor" placeholder="Text"></textarea>
                                    @error('resource_text') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12 col-md-6 mt-2" wire:ignore>
                                    <label class="form-label" for="resource_text_arabic">النص </label>
                                    <textarea wire:ignore
                                        wire:model="resource_text_arabic"
                                        type="text"
                                        id="resource_text_arabic"
                                        class="form-control txtEditor"
                                        placeholder="النص"></textarea>
                                    @error('resource_text_arabic') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>


                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="resource_date">Date <span class="text-danger">*</span></label>
                                    <input
                                        wire:model="resource_date"
                                        type="date"
                                        id="resource_date"
                                        class="form-control"
                                        placeholder="العنوان" />
                                    @error('resource_date') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="w-100 d-none d-md-block"></div>

                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="resource_tags">Tags</label>
                                    <input
                                        wire:model="resource_tags"
                                        type="text"
                                        id="resource_tags"
                                        class="form-control"
                                        placeholder="Tags" />
                                    @error('resource_tags') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="resource_tags_arabic">Tags Arabic</label>
                                    <input
                                        wire:model="resource_tags_arabic"
                                        type="text"
                                        id="resource_tags_arabic"
                                        class="form-control"
                                        placeholder="Tags Arabic" />
                                    @error('resource_tags_arabic') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>
                                

                            </div>

                        </div>


                    </div>


                    <!--News-->
                    <div class="card mt-5 @if($type_id!=7) d-none @endif">

                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">News Details</h5>
                        </div>

                        <div class="card-body">

                            <div class="row">

                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="news_title">Title <span class="text-danger">*</span></label>
                                    <input
                                        wire:model="news_title"
                                        type="text"
                                        id="news_title"
                                        class="form-control"
                                        placeholder="Title" />
                                    @error('news_title') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="news_title_arabic">العنوان <span class="text-danger">*</span></label>
                                    <input
                                        wire:model="news_title_arabic"
                                        type="text"
                                        id="news_title_arabic"
                                        class="form-control"
                                        placeholder="العنوان" />
                                    @error('news_title_arabic') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12 col-md-6 mt-2" wire:ignore>
                                    <label class="form-label" for="news_text">Text</label>
                                    <textarea wire:ignore
                                        wire:model="news_text"
                                        type="text"
                                        id="news_text"
                                        class="form-control txtEditor" placeholder="Text"></textarea>
                                    @error('news_text') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12 col-md-6 mt-2" wire:ignore>
                                    <label class="form-label" for="news_text_arabic">النص </label>
                                    <textarea wire:ignore
                                        wire:model="news_text_arabic"
                                        type="text"
                                        id="news_text_arabic"
                                        class="form-control txtEditor"
                                        placeholder="النص"></textarea>
                                    @error('news_text_arabic') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>


                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="news_date">Date <span class="text-danger">*</span></label>
                                    <input
                                        wire:model="news_date"
                                        type="date"
                                        id="news_date"
                                        class="form-control"
                                        placeholder="العنوان" />
                                    @error('news_date') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="w-100 d-none d-md-block"></div>
                                
                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="news_tags">Tags</label>
                                    <input
                                        wire:model="news_tags"
                                        type="text"
                                        id="news_tags"
                                        class="form-control"
                                        placeholder="Tags" />
                                    @error('news_tags') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="news_tags_arabic">Tags Arabic</label>
                                    <input
                                        wire:model="news_tags_arabic"
                                        type="text"
                                        id="news_tags_arabic"
                                        class="form-control"
                                        placeholder="Tags Arabic" />
                                    @error('news_tags_arabic') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>
                                

                            </div>

                        </div>


                    </div>


                    <!--External-->
                    <div class="card mt-5 @if($type_id!=8) d-none @endif">

                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">External Details</h5>
                        </div>

                        <div class="card-body">

                            <div class="row">

                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="external_category_id">Category <span class="text-danger">*</span></label>
                                    <select
                                        wire:model="external_category_id"
                                        id="external_category_id"
                                        class="form-control">
                                        <option value=''>Select Type</option>
                                        @foreach($external_categories as $category)
                                            <option value='{{$category->id}}'>{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('external_category_id') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="w-100 d-none d-md-block"></div>

                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="external_title">Title <span class="text-danger">*</span></label>
                                    <input
                                        wire:model="external_title"
                                        type="text"
                                        id="external_title"
                                        class="form-control"
                                        placeholder="Title" />
                                    @error('external_title') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="external_title_arabic">العنوان <span class="text-danger">*</span></label>
                                    <input
                                        wire:model="external_title_arabic"
                                        type="text"
                                        id="external_title_arabic"
                                        class="form-control"
                                        placeholder="العنوان" />
                                    @error('external_title_arabic') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="external_link">Link <span class="text-danger">*</span></label>
                                    <input
                                        wire:model="external_link"
                                        type="text"
                                        id="external_link"
                                        class="form-control"
                                        placeholder="Link" />
                                    @error('external_link') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="external_link_arabic">رابط الزر<span class="text-danger">*</span></label>
                                    <input
                                        wire:model="external_link_arabic"
                                        type="text"
                                        id="external_link_arabic"
                                        class="form-control"
                                        placeholder="Link" />
                                    @error('external_link_arabic') <div class="text-danger">{{ $message }}</div> @enderror
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

    @script
    <script>
        document.addEventListener('livewire:navigated', () => {
            let el = $('#project_countries_id');

            // initialize
            el.select2({
                placeholder: "Select countries",
                allowClear: true,
                width: "100%"
            });

            // set initial values from Livewire
            el.val(@json($project_countries_id)).trigger('change');

            // handle change (update Livewire)
            el.on('change', function () {
                $wire.set('project_countries_id', $(this).val());
            });
        });
    </script>
    @endscript
  
    <!-- ✅ Load CKEditor -->
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.2/classic/ckeditor.js"></script>

    <script>

        document.addEventListener('livewire:load', function () {
            $('#project_countries_id').select2();

            $('#project_countries_id').on('change', function () {
                @this.set('project_countries_id', $(this).val());
            });
        });

        document.addEventListener('livewire:load', function () {
            // Wait until Livewire DOM is ready
            initEditors();
        });

        // ✅ Re-init CKEditor if Livewire re-renders (after save/validation)
        document.addEventListener('livewire:navigated', function () {
            initEditors();
        });

        function initEditors() {
            document.querySelectorAll('.txtEditor').forEach((el) => {
                // Prevent double init
                if (el.classList.contains('ck-loaded')) return;
                el.classList.add('ck-loaded');

                ClassicEditor.create(el)
                    .then(editor => {
                        const model = el.getAttribute('wire:model') || el.getAttribute('wire:model.defer');

                        // Sync editor → Livewire
                        editor.model.document.on('change:data', () => {
                            const component = el.closest('[wire\\:id]');
                            if (!component) return;
                            Livewire.find(component.getAttribute('wire:id'))
                                .set(model.replace('.defer', ''), editor.getData());
                        });
                    })
                    .catch(error => console.error('CKEditor init error:', error));
            });
        }
    </script>

    <style>
        .ck-editor__editable_inline {
            min-height: 250px;
        }
    </style>
    
</div>
