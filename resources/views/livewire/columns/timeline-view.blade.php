<div>
    <div>
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-3">Timeline List</h4>

                @can('section-create')
                    <div>
                        <button
                            type="button"
                            wire:click="createTimeline"
                            class="btn btn-primary mb-2 text-nowrap"
                            style="margin-top:2px;"
                        >
                            Add Entry
                        </button>

                        @if(isset($page_id))
                            <a href="{{ route('sections', $page_id) }}" class="btn btn-primary mb-2 text-nowrap">Sections</a>
                        @elseif(isset($entry_id))
                            <a href="{{ route('entry.sections', $entry_id) }}" class="btn btn-primary mb-2 text-nowrap">Sections</a>
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
                                <td>{{ $timeline->list_order }}</td>
                                <td>{{ $timeline->date }}</td>
                                <td>
                                    @can('section-edit')
                                        <i
                                            class="ti ti-edit ti-sm cursor-pointer"
                                            wire:click="editEntry({{ $timeline->id }})"
                                        ></i>
                                    @endcan

                                    @can('section-delete')
                                        <a href="#" class="text-body delete-record delete-button" data-id="{{ $timeline->id }}">
                                            <i class="ti ti-trash ti-sm mx-2 text-danger"></i>
                                        </a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div wire:ignore.self class="modal fade" id="timelineModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $modalId ? 'Edit' : 'Add' }} Entry</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="date" class="form-label">Date</label>
                            <input
                                type="text"
                                class="form-control @error('date') is-invalid @enderror"
                                id="date"
                                wire:model="date"
                                placeholder="Date"
                            />
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @foreach($entries as $key => $entry)
                            <div class="mt-3 mb-3 d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Timeline {{ $key + 1 }}</h5>
                                @if($key >= 1)
                                    <button
                                        type="button"
                                        wire:click="deleteEntry({{ $key }})"
                                        class="btn btn-danger btn-sm"
                                    >
                                        Delete
                                    </button>
                                @endif
                            </div>

                            <div class="row" wire:key="timeline-entry-row-{{ $modalId ?? 'new' }}-{{ $key }}">
                                <div class="mb-3" wire:key="entry-text-wrapper-{{ $modalId ?? 'new' }}-{{ $key }}">
                                    <label for="entries_{{ $key }}_text" class="form-label">Text</label>
                                    <div wire:ignore>
                                        <textarea
                                            class="form-control txtEditor @error('entries.' . $key . '.text') is-invalid @enderror"
                                            id="entries_{{ $key }}_text"
                                            data-model="entries.{{ $key }}.text"
                                            style="height:150px; resize:none;"
                                        >{{ $entries[$key]['text'] ?? '' }}</textarea>
                                    </div>
                                    @error('entries.' . $key . '.text')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3" wire:key="entry-text-ar-wrapper-{{ $modalId ?? 'new' }}-{{ $key }}">
                                    <label for="entries_{{ $key }}_text_arabic" class="form-label">النص</label>
                                    <div wire:ignore>
                                        <textarea
                                            class="form-control txtEditor @error('entries.' . $key . '.text_arabic') is-invalid @enderror"
                                            id="entries_{{ $key }}_text_arabic"
                                            data-model="entries.{{ $key }}.text_arabic"
                                            style="height:150px; resize:none;"
                                        >{{ $entries[$key]['text_arabic'] ?? '' }}</textarea>
                                    </div>
                                    @error('entries.' . $key . '.text_arabic')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="small text-danger mb-1">
                                    Note: Skip Pattern Shape and Percentage if text only
                                </div>

                                <div class="col-12 col-lg-12 mb-3">
                                    <label for="entries_{{ $key }}_shape_id" class="form-label">Pattern Shape</label>
                                    <select
                                        wire:model="entries.{{ $key }}.shape_id"
                                        id="entries_{{ $key }}_shape_id"
                                        class="form-control"
                                    >
                                        <option value="">Select Shape</option>
                                        @foreach($shapes as $shape)
                                            <option value="{{ $shape->id }}">{{ $shape->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('entries.' . $key . '.shape_id')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 col-lg-6 mb-3">
                                    <label for="entries_{{ $key }}_percentage" class="form-label">Pattern Percentage</label>
                                    <input
                                        type="text"
                                        class="form-control @error('entries.' . $key . '.percentage') is-invalid @enderror"
                                        id="entries_{{ $key }}_percentage"
                                        wire:model="entries.{{ $key }}.percentage"
                                        placeholder="Percentage"
                                    />
                                    @error('entries.' . $key . '.percentage')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 col-lg-6 mb-3">
                                    <label for="entries_{{ $key }}_percentage_color_id" class="form-label">Pattern Color</label>
                                    <select
                                        wire:model="entries.{{ $key }}.percentage_color_id"
                                        id="entries_{{ $key }}_percentage_color_id"
                                        class="form-control"
                                    >
                                        <option value="">Select Color</option>
                                        @foreach($colors as $color)
                                            <option value="{{ $color->id }}">{{ $color->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('entries.' . $key . '.percentage_color_id')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        @endforeach

                        <div class="mb-3">
                            <button type="button" wire:click="addEntry" class="btn btn-primary">Add Row</button>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        >
                            Cancel
                        </button>

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

        <script src="https://cdn.ckeditor.com/ckeditor5/39.0.2/super-build/ckeditor.js"></script>

        <script>
            let timelineSortableInstance = null;

            function initSortableTable() {
                const el = document.querySelector('#table tbody');
                if (!el || timelineSortableInstance) return;

                timelineSortableInstance = Sortable.create(el, {
                    handle: 'td',
                    animation: 150,
                    onEnd: function () {
                        const order = [];
                        el.querySelectorAll('tr').forEach((row) => {
                            order.push(row.getAttribute('data-id'));
                        });

                        Livewire.dispatch('updateOrder', { order: order });
                    }
                });
            }

            function destroyEditor(el) {
                if (el && el.editorInstance) {
                    el.editorInstance.destroy().catch(() => {});
                    el.editorInstance = null;
                    el.dataset.editorInitialized = 'false';
                }
            }

            function destroyAllEditors() {
                document.querySelectorAll('.txtEditor').forEach((el) => {
                    destroyEditor(el);
                });
            }

            function initEditors() {
                document.querySelectorAll('.txtEditor').forEach((el) => {
                    if (el.dataset.editorInitialized === 'true') return;

                    const model = el.dataset.model;
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
                                { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                                { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                                { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                                { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' }
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
                    }).then((editor) => {
                        el.dataset.editorInitialized = 'true';
                        el.editorInstance = editor;

                        editor.setData(el.value || '');

                        editor.model.document.on('change:data', () => {
                            const componentEl = el.closest('[wire\\:id]');
                            if (!componentEl) return;

                            const component = Livewire.find(componentEl.getAttribute('wire:id'));
                            if (!component) return;

                            component.set(model, editor.getData());
                        });
                    }).catch((error) => {
                        console.error('CKEditor init error:', error);
                    });
                });
            }

            document.addEventListener('livewire:init', () => {
                initSortableTable();

                const modalEl = document.getElementById('timelineModal');

                if (modalEl) {
                    modalEl.addEventListener('shown.bs.modal', () => {
                        setTimeout(() => {
                            initEditors();
                        }, 200);
                    });

                    modalEl.addEventListener('hidden.bs.modal', () => {
                        destroyAllEditors();
                    });
                }

                Livewire.on('open-timeline-modal', () => {
                    const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                    modal.show();

                    setTimeout(() => {
                        initEditors();
                    }, 300);
                });

                Livewire.on('close-timeline-modal', () => {
                    const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                    modal.hide();
                });

                Livewire.on('refresh-editors', () => {
                    setTimeout(() => {
                        destroyAllEditors();
                        initEditors();
                    }, 200);
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