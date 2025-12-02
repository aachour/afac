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
                    @if(isset($page_id))
                        <a href="{{ route('sections',$page_id) }}" class="btn btn-primary mb-2 text-nowrap">Sections</a>
                    @elseif(isset($entry_id))
                        <a href="{{ route('entry.sections',$entry_id) }}" class="btn btn-primary mb-2 text-nowrap">Sections</a>
                    @endif
                    
                </div>
                @endcan
            </div>
            <div class="card-datatable table-responsive" wire:ignore>
                <table class="table border-top" id="tableInputs">
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
                                    {!!$generalInput->text!!}
                                @elseif($generalInput->input_type_id==3)
                                    gallery images
                                @elseif($generalInput->input_type_id==4)
                                    {{$generalInput->video}}
                                @elseif($generalInput->input_type_id==5)
                                    {{$generalInput->button_value}}
                                @endif
                            </td>
                            <td>
                                @can('section-edit')
                                    @if($generalInput->input_type_id==3)
                                        <i  class="ti ti-wall ti-sm cursor-pointer"
                                            data-bs-target="#galleryImagesModal"
                                            data-bs-toggle="modal"
                                            wire:click="showGallery({{ $generalInput->id }} , {{ $generalInput->gallery_id }})"></i>
                                    @endif
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

        <!-- Form Inputs Modal-->
        <div wire:ignore.self class="modal fade" id="generalInputsModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $modalId ? 'Edit' : 'Add' }} Entry</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="mb-3">
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

                        <div class="mb-3">
                            <label for="input_type_id" class="form-label">Input Type</label>
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
                        
                        <!--Title-->
                        <div class="mb-3 {{ $input_type_id == 1 ? '' : 'd-none' }}">
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

                        <div class="mb-3 {{ $input_type_id == 1 ? '' : 'd-none' }}">
                            <label for="title_arabic" class="form-label">العنوان</label>
                            <input type="text"
                                class="form-control @error('title_arabic') is-invalid @enderror"
                                id="title_arabic"
                                wire:model="title_arabic"
                                placeholder="العنوان" />
                            @error('title_arabic')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!--Text-->
                        <div class="mb-3 {{ $input_type_id == 2 ? '' : 'd-none' }}">
                            <label for="ColorCode" class="form-label">Text</label>
                            <div wire:ignore>
                                <textarea
                                    class="form-control txtEditor @error('text') is-invalid @enderror"
                                    id="text"
                                    wire:model.defer="text" style="height:200px; resize:none;"></textarea>
                            </div>
                            @error('text')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 {{ $input_type_id == 2 ? '' : 'd-none' }}">
                            <label for="text_arabic" class="form-label">النص</label>
                            <div wire:ignore>
                                <textarea
                                    class="form-control txtEditor @error('text_arabic') is-invalid @enderror"
                                    id="text_arabic"
                                    wire:model.defer="text_arabic" style="height:200px; resize:none;"></textarea>
                            </div>
                            @error('text_arabic')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!--Gallery-->
                        <div class="mb-3 {{ $input_type_id == 3 ? '' : 'd-none' }}"">
                            <label for="gallery_images" class="form-label">Gallery</label>

                            <x-filepond wire:model="gallery_images"
                                :images="$gallery_images"
                                file-path="{{ @$imapegPreview }}"
                                delete-event="deleteImage"
                                is-multiple="true" />

                            @error('gallery')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                        </div>
                            
                        <!--Video-->
                        <div class="mb-3 {{ $input_type_id == 4 ? '' : 'd-none' }}">
                            <label for="video" class="form-label">Video</label>
                            <input type="text"
                                class="form-control @error('video') is-invalid @enderror"
                                id="video"
                                wire:model="video"
                                placeholder="video" />
                            @error('video')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!--Button-->
                        <div class="mb-3 {{ $input_type_id == 5 ? '' : 'd-none' }}">
                            <label for="gallery_images" class="form-label">Button Background Image</label>
                            
                            <x-filepond wire:model="button_bg_image"
                                id="button_bg_image"
                                file-path="{{ @$btnImagePreview ?? '' }}"
                                delete-event="deleteImage"
                                is-multiple="false" />
                            @if($btnImagePreview!='')
                                <img src="{{$btnImagePreview}}" width="80px" />
                            @endif
                            @error('gallery')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                        </div>

                        <div class="row">

                            <div class="col-12 col-lg-6 mb-3 {{ $input_type_id == 5 ? '' : 'd-none' }}">
                                <label for="button_value" class="form-label">Button Value</label>
                                <input type="text"
                                    class="form-control @error('button_value') is-invalid @enderror"
                                    id="button_value"
                                    wire:model="button_value" />
                                @error('button_value')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-lg-6 mb-3 {{ $input_type_id == 5 ? '' : 'd-none' }}">
                                <label for="button_value_arabic" class="form-label">نص الزر</label>
                                <input type="text"
                                    class="form-control @error('button_value_arabic') is-invalid @enderror"
                                    id="button_value_arabic"
                                    wire:model="button_value_arabic" />
                                @error('button_value')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        
                        </div>

                        <div class="row">
                            
                            <div class="col-12 col-lg-6 mb-3 {{ $input_type_id == 5 ? '' : 'd-none' }}">
                                <label for="button_shape_id" class="form-label">Button Shape</label>
                                <select
                                    wire:model="button_shape_id"
                                    id="button_shape_id"
                                    class="form-control">
                                    <option value=''>Select Shape</option>
                                    @foreach($shapes as $shape)
                                        <option value='{{$shape->id}}'>{{$shape->name}}</option>
                                    @endforeach
                                </select>
                                @error('button_shape_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-lg-6 mb-3 {{ $input_type_id == 5 ? '' : 'd-none' }}">
                                <label for="button_hover_shape_id" class="form-label">Button Hover Shape</label>
                                <select
                                    wire:model="button_hover_shape_id"
                                    id="button_hover_shape_id"
                                    class="form-control">
                                    <option value=''>Select Shape</option>
                                    @foreach($shapes as $shape)
                                        <option value='{{$shape->id}}'>{{$shape->name}}</option>
                                    @endforeach
                                </select>
                                @error('button_hover_shape_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-12 col-lg-6  mb-3 {{ $input_type_id == 5 ? '' : 'd-none' }}">
                                <label for="button_bg_color_id" class="form-label">Background Color</label>
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

                            <div class="col-12 col-lg-6  mb-3 {{ $input_type_id == 5 ? '' : 'd-none' }}">
                                <label for="button_hover_bg_color_id" class="form-label">Background Color</label>
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
                        
                        </div>

                        <div class="mb-3 {{ $input_type_id == 5 ? '' : 'd-none' }}">
                            <label for="button_link" class="form-label">Button Link</label>
                            <input type="text"
                                class="form-control @error('button_link') is-invalid @enderror"
                                id="button_link"
                                wire:model="button_link"
                                placeholder="button_link" />
                            @error('button_link')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 {{ $input_type_id == 5 ? '' : 'd-none' }}">
                            <label for="button_link_arabic" class="form-label">رابط الزر</label>
                            <input type="text"
                                class="form-control @error('button_link_arabic') is-invalid @enderror"
                                id="button_link_arabic"
                                wire:model="button_link_arabic"
                                placeholder="button_link_arabic" />
                            @error('button_link_arabic')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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

        <!-- Gallery Modal-->
        <div wire:ignore.self class="modal fade" id="galleryImagesModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Galley Images</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table border-top" id="tableGallery">
                            <thead>
                            <tr>
                                <th>Order</th>
                                <th>Image</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                                @if(count($gallery_images)>0)
                                    @foreach ($gallery_images as $key=>$gallery_image)
                                        <tr data-id="{{ @$gallery_image->id }}" style="cursor: move;">
                                            <td>{{@$gallery_image->list_order}}</td>
                                            <td>
                                                <img src="{{ asset('storage/'.@$gallery_image->image_path) }}" class="w-full h-32 object-cover rounded" width="200px" />
                                                <div class="mt-2">
                                                    <input type="text" wire:model="gallery_image_inputs.{{ $key }}.caption" placeholder="Image Caption" class="caption form-control" />
                                                </div>
                                                <div class="mt-2">
                                                    <input type="text" wire:model="gallery_image_inputs.{{ $key }}.caption_arabic" placeholder="تسمية الصورة" class="caption form-control"  style="direction:rtl;" />
                                                </div>
                                                <div class="mt-2">
                                                    <input type="text" wire:model="gallery_image_inputs.{{ $key }}.link" placeholder="Image Link" class="link form-control"/>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="#" wire:click.prevent="editGalleryImage({{@$gallery_image->id}} , {{ $key }})" class="text-body">
                                                    <i class="ti ti-check ti-sm cursor-pointer"></i>
                                                </a>
                                                <a href="#" wire:click.prevent="deleteGalleryImage({{ @$gallery_image->id }})" class="text-body">
                                                    <i class="ti ti-trash ti-sm mx-2 text-danger"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        @script
            @include('livewire.deleteConfirm')
        @endscript

        <!-- ✅ Load CKEditor -->
        <script src="https://cdn.ckeditor.com/ckeditor5/39.0.2/classic/ckeditor.js"></script>

        <script>
            
            window.ckeditors = {};
            
            document.addEventListener('livewire:init', () => {
                Livewire.on('activateCkeditor', () => { 
                    destroyEditors();
                    setTimeout(() => { 
                        initEditors();
                    },50);
                    
                });
            });

            function initEditors() {
                document.querySelectorAll('.txtEditor').forEach((el) => {
                    const id = el.getAttribute('id');
                    if (!id) return; // CKEditor must have a unique id

                    // Prevent double init
                    if (window.ckeditors[id]) return;

                    ClassicEditor.create(el)
                        .then(editor => {
                            window.ckeditors[id] = editor;

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

            function destroyEditors() {
                for (const id in window.ckeditors) {
                    if (window.ckeditors[id]) {
                        window.ckeditors[id].destroy();
                        delete window.ckeditors[id];
                    }
                }
            }

        </script>


        <style>
            .ck-editor__editable_inline {
                min-height: 250px;
            }
        </style>

        <script>
            //load table
            document.addEventListener('livewire:init', function() {
                const el = document.querySelector("#tableInputs tbody");

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

            //load gallery table
            document.addEventListener('livewire:init', function() {
                const el = document.querySelector("#tableGallery tbody");

                if (el) {
                    Sortable.create(el, {
                        handle: 'td',
                        animation: 150,
                        onEnd: function(evt) {
                            const order = [];
                            el.querySelectorAll("tr").forEach((row) => {
                                order.push(row.getAttribute("data-id"));
                            });

                            Livewire.dispatch('updateGalleryOrder', {order: order});
                        }
                    });
                }

            });

            document.addEventListener('DOMContentLoaded', function () {
                var modal = document.getElementById('generalInputsModal');

                modal.addEventListener('hidden.bs.modal', function () {
                    Livewire.dispatch('reset-modal');
                });
            });
        </script>

    </div>

</div>