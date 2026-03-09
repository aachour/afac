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

        <div wire:ignore.self class="modal fade" id="accordionModal" tabindex="-1" data-bs-focus="false">
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
                                placeholder="Text" style="height:200px; resize:none;">{{$text}}</textarea>
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
                                style="height:200px; resize:none;">{{$text_arabic}}</textarea>
                            @error('النص')
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

            document.addEventListener('DOMContentLoaded', function () {
                var modal = document.getElementById('accordionModal');

                modal.addEventListener('hidden.bs.modal', function () {
                    Livewire.dispatch('reset-modal');
                });
            });

        </script>

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
                const modalEl = document.getElementById('accordionModal');
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
            .ck.ck-balloon-panel {
                z-index: 999999 !important;
            }

            .ck-link-form {
                z-index: 999999 !important;
            }

            .ck-input-text {
                position: relative;
                z-index: 999999 !important;
            }
        </style>

    </div>

</div>