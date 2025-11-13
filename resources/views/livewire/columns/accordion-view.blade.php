<div>

    <div>
        
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-3">Accordion List</h4>
                @can('section-create')
                <div>
                    <button
                        data-bs-target="#accordionModal"
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
                        <th>Text</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($accordions as $accordion)
                        <tr data-id="{{ $accordion->id }}" style="cursor: move;">
                            <td>{{$accordion->list_order}}</td>
                            <td>{{$accordion->title}}</td>
                            <td>{!!$accordion->text!!}</td>
                            <td>
                                @can('section-edit')
                                    <i  class="ti ti-edit ti-sm cursor-pointer"
                                        data-bs-target="#accordionModal"
                                        data-bs-toggle="modal"
                                        wire:click="editEntry({{ $accordion->id }})"></i>
                                @endcan
                                @can('section-delete')
                                <a href="#" class="text-body delete-record delete-button" data-id="{{ $accordion->id }}"><i class="ti ti-trash ti-sm mx-2 text-danger"></i></a>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>

        <div wire:ignore.self class="modal fade" id="accordionModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $modalId ? 'Edit' : 'Add' }} Entry</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="ColorName" class="form-label">Title</label>
                            <input type="text"
                                class="form-control @error('title') is-invalid @enderror"
                                id="title"
                                wire:model="title"
                                placeholder="Title" />
                            @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3" wire:ignore>
                            <label for="ColorCode" class="form-label">Text</label>
                            <textarea
                                class="form-control txtEditor @error('text') is-invalid @enderror"
                                id="text"
                                wire:model.defer="text"
                                placeholder="Text" style="height:200px; resize:none;"></textarea>
                            @error('text')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="title_arabic" class="form-label">العنوان</label>
                            <input type="text"
                                class="form-control @error('title_arabic') is-invalid @enderror"
                                id="title_arabic"
                                wire:model="title_arabic"/>
                            @error('title_arabic')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3" wire:ignore>
                            <label for="text_arabic" class="form-label">النص</label>
                            <textarea
                                class="form-control txtEditor @error('text_arabic') is-invalid @enderror"
                                id="text_arabic"
                                wire:model.defer="text_arabic"
                                style="height:200px; resize:none;"></textarea>
                            @error('النص')
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

            document.addEventListener('livewire:load', function () {
                initEditors();
            });

            // Re-init CKEditor when Livewire re-renders
            document.addEventListener('livewire:navigated', function () {
                initEditors();
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

            // ✅ Livewire can call this:
            window.setEditorValue = function (editorId, value) {
                if (window.ckeditors[editorId]) {
                    window.ckeditors[editorId].setData(value || "");
                }
            };

            // Listen for Livewire event
            document.addEventListener('set-editor-value', function (e) {
                window.setEditorValue(e.detail.id, e.detail.value);
            });

            // Listen for Livewire event
            document.addEventListener('set-editor-value-arabic', function (e) {
                window.setEditorValue(e.detail.id, e.detail.value);
            });

        </script>


        <style>
            .ck-editor__editable_inline {
                min-height: 250px;
            }
        </style>


    </div>

</div>