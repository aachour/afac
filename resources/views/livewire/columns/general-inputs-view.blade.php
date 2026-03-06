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
                                    wire:model.defer="text"
                                    style="height:200px; resize:none;">{{ $text }}</textarea>
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
                                    wire:model.defer="text_arabic"
                                    style="height:200px; resize:none;">{{ $text_arabic }}</textarea>
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
                                <label for="button_color_id" class="form-label">Text Color</label>
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

                            <div class="col-12 col-lg-6  mb-3 {{ $input_type_id == 5 ? '' : 'd-none' }}">
                                <label for="button_hover_color_id" class="form-label">Hover Text Color</label>
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
                                <label for="button_hover_bg_color_id" class="form-label">Hover Background Color</label>
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
        <script src="https://cdn.ckeditor.com/ckeditor5/39.0.2/super-build/ckeditor.js"></script>

        <script>
            document.addEventListener('livewire:load', () => {
                initEditors();

                Livewire.hook('message.processed', () => {
                    initEditors();
                    syncEditorData();
                });
            });

            document.addEventListener('livewire:navigated', () => {
                initEditors();
                syncEditorData();
            });

            function getEditorValue(el) {
                return el.value || '';
            }

            function initEditors() {
                document.querySelectorAll('.txtEditor').forEach((el) => {
                    if (el.dataset.editorInitialized === 'true') return;

                    const model =
                        el.getAttribute('wire:model') ||
                        el.getAttribute('wire:model.live') ||
                        el.getAttribute('wire:model.blur') ||
                        el.getAttribute('wire:model.defer');

                    if (!model) return;

                    CKEDITOR.ClassicEditor.create(el, {
                        toolbar: {
                            items: [
                                'heading',
                                '|',
                                'bold', 'italic', 'underline', 'strikethrough',
                                '|',
                                'alignment',
                                '|',
                                'bulletedList', 'numberedList', 'outdent', 'indent',
                                '|',
                                'link', 'blockQuote', 'insertTable',
                                '|',
                                'undo', 'redo',
                                '|',
                                'sourceEditing'
                            ],
                            shouldNotGroupWhenFull: true
                        },
                        heading: {
                            options: [
                                {
                                    model: 'paragraph',
                                    title: 'Paragraph',
                                    class: 'ck-heading_paragraph'
                                },
                                {
                                    model: 'heading1',
                                    view: 'h1',
                                    title: 'Heading 1',
                                    class: 'ck-heading_heading1'
                                },
                                {
                                    model: 'heading2',
                                    view: 'h2',
                                    title: 'Heading 2',
                                    class: 'ck-heading_heading2'
                                },
                                {
                                    model: 'heading3',
                                    view: 'h3',
                                    title: 'Heading 3',
                                    class: 'ck-heading_heading3'
                                }
                            ]
                        },
                        link: {
                            decorators: {
                                openInNewTab: {
                                    mode: 'manual',
                                    label: 'Open in a new tab',
                                    attributes: {
                                        target: '_blank',
                                        rel: 'noopener noreferrer'
                                    }
                                }
                            }
                        },
                        htmlSupport: {
                            allow: [
                                { name: /.*/, attributes: true, classes: true, styles: true }
                            ]
                        },
                        removePlugins: [
                            'PasteFromOfficeEnhanced',
                            'TableOfContents',
                            'CloudServices',
                            'CKBox',
                            'CKFinder',
                            'EasyImage',
                            'ExportPdf',
                            'ExportWord',
                            'DocumentOutline',
                            'AIAssistant',
                            'PresenceList',
                            'Comments',
                            'TrackChanges',
                            'TrackChangesData',
                            'RevisionHistory',
                            'Pagination',
                            'WProofreader',
                            'RealTimeCollaborativeComments',
                            'RealTimeCollaborativeTrackChanges',
                            'RealTimeCollaborativeRevisionHistory',
                            'MathType',
                            'SlashCommand',
                            'Template',
                            'FormatPainter'
                        ]
                    })
                    .then((editor) => {
                        el.dataset.editorInitialized = 'true';
                        el.editorInstance = editor;

                        editor.setData(getEditorValue(el));

                        editor.model.document.on('change:data', () => {
                            const componentEl = el.closest('[wire\\:id]');
                            if (!componentEl) return;

                            const component = Livewire.find(componentEl.getAttribute('wire:id'));
                            if (!component) return;

                            component.set(model, editor.getData());
                        });
                    })
                    .catch((error) => {
                        console.error('CKEditor init error:', error);
                    });
                });
            }

            function syncEditorData() {
                document.querySelectorAll('.txtEditor').forEach((el) => {
                    if (!el.editorInstance) return;

                    const newValue = getEditorValue(el);
                    if (el.editorInstance.getData() !== newValue) {
                        el.editorInstance.setData(newValue);
                    }
                });
            }
        </script>

        <script>
            window.addEventListener('open-general-input-modal', () => {
                const modalEl = document.getElementById('generalInputsModal');
                const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                modal.show();
            });

            window.addEventListener('fill-editors', (event) => {
                const data = event.detail[0] || event.detail;

                setTimeout(() => {
                    const textEl = document.getElementById('text');
                    const textArabicEl = document.getElementById('text_arabic');

                    if (textEl?.editorInstance) {
                        textEl.editorInstance.setData(data.text || '');
                    }

                    if (textArabicEl?.editorInstance) {
                        textArabicEl.editorInstance.setData(data.text_arabic || '');
                    }
                }, 300);
            });
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