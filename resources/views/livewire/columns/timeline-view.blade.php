<div>

    <div>
        
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-3">Timeline List</h4>
                @can('section-create')
                <div>
                    <button
                        data-bs-target="#timelineModal"
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
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($timelines as $timeline)
                        <tr data-id="{{ $timeline->id }}" style="cursor: move;">
                            <td>{{$timeline->list_order}}</td>
                            <td>{{$timeline->date}}</td>
                            <td>
                                @can('section-edit')
                                    <i  class="ti ti-edit ti-sm cursor-pointer"
                                        data-bs-target="#timelineModal"
                                        data-bs-toggle="modal"
                                        wire:click="editEntry({{ $timeline->id }})"></i>
                                @endcan
                                @can('section-delete')
                                <a href="#" class="text-body delete-record delete-button" data-id="{{ $timeline->id }}"><i class="ti ti-trash ti-sm mx-2 text-danger"></i></a>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>

        <div wire:ignore.self class="modal fade" id="timelineModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $modalId ? 'Edit' : 'Add' }} Entry</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="ColorName" class="form-label">Date</label>
                            <input type="text"
                                class="form-control @error('date') is-invalid @enderror"
                                id="date"
                                wire:model="date"
                                placeholder="Date" />
                            @error('date')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @foreach($entries as $key=>$entry)

                            <div class="mt-3 mb-3 d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Timeline {{$key + 1}}</h5>
                                @if($key >= 1)
                                    <button type="button" wire:click="deleteEntry({{$key}})" class="btn btn-danger btn-sm">Delete</button>
                                @endif
                            </div>

                            <div class="row">

                                <div class="mb-3" wire:ignore>
                                    <label for="text" class="form-label">Text</label>
                                    <div wire:ignore>
                                        <textarea
                                        class="form-control txtEditor @error('text') is-invalid @enderror"
                                        id="entries.{{$key}}.text"
                                        wire:model.defer="entries.{{$key}}.text"
                                        style="height:150px; resize:none;"></textarea>
                                    </div>
                                    @error('entries.{{$key}}.text')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3" wire:ignore>
                                    <label for="text_arabic" class="form-label">النص</label>
                                    <div wire:ignore>
                                        <textarea
                                        class="form-control txtEditor @error('text_arabic') is-invalid @enderror"
                                        id="entries.{{$key}}.text_arabic"
                                        wire:model.defer="entries.{{$key}}.text_arabic"
                                        style="height:150px; resize:none;"></textarea>
                                    </div>
                                    @error('entries.{{$key}}.text_arabic')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="small text-danger mb-1">Note: Skip Pattern Shape and Percentage if text only</div>

                                <div class="col-12 col-lg-12 mb-3">
                                    <label for="entries.{{$key}}.shape_id" class="form-label">Pattern Shape</label>
                                    <select
                                        wire:model="entries.{{$key}}.shape_id"
                                        id="entries.{{$key}}.shape_id"
                                        class="form-control">
                                        <option value=''>Select Shape</option>
                                        @foreach($shapes as $shape)
                                            <option value='{{$shape->id}}'>{{$shape->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('entries.{{$key}}.shape_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 col-lg-6 mb-3">
                                    <label for="entries.{{$key}}.percentage" class="form-label">Pattern Percentage</label>
                                    <input type="text"
                                        class="form-control @error('percentage') is-invalid @enderror"
                                        id="entries.{{$key}}.percentage"
                                        wire:model="entries.{{$key}}.percentage"
                                        placeholder="Percentage" />
                                    @error('entries.{{$key}}.percentage')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 col-lg-6 mb-3">
                                    <label for="entries.{{$key}}.percentage_color_id" class="form-label">Pattern Color</label>
                                    <select
                                        wire:model="entries.{{$key}}.percentage_color_id"
                                        id="entries.{{$key}}.percentage_color_id"
                                        class="form-control">
                                        <option value=''>Select Color</option>
                                        @foreach($colors as $color)
                                            <option value='{{$color->id}}'>{{$color->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('percentage_color_id') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                            </div>

                        @endforeach
                        
                        <div class="mb-3">
                            <button type="button" wire:click="addEntry" class="btn btn-primary">Add Row</button>
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
        </script>

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
                    if (!id) return;

                    // Prevent double init
                    if (window.ckeditors[id]) return;

                    ClassicEditor.create(el, {
                        toolbar: [
                            'sourceEditing',  
                            '|',
                            'heading',
                            'style',
                            '|',
                            'bold',
                            'italic',
                            'link',
                            'bulletedList',
                            'numberedList',
                            '|',
                            'undo',
                            'redo'
                        ],

                        heading: {
                            options: [
                                { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                                { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                                { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                                { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                                { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                                { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading4' },
                                { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading4' },
                            ]
                        },

                        style: {
                            definitions: [
                                {
                                    name: 'Body Medium',
                                    element: 'p',
                                    classes: ['body-medium']
                                }
                            ]
                        }
                    })
                    .then(editor => {
                        window.ckeditors[id] = editor;

                        const model = el.getAttribute('wire:model') || el.getAttribute('wire:model.defer');

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

            document.addEventListener('DOMContentLoaded', function () {
                var modal = document.getElementById('timelineModal');

                modal.addEventListener('hidden.bs.modal', function () {
                    Livewire.dispatch('reset-modal');
                });
            });


        </script>


        <style>
            .ck-editor__editable_inline {
                min-height: 250px;
            }
        </style>

    </div>

</div>