<div>

    <div>
        
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-3">Files List</h4>
                @can('file-create')
                <div>
                    <button
                        data-bs-target="#fileModal"
                        data-bs-toggle="modal"
                        class="btn btn-primary mb-2 text-nowrap" 
                        style="margin-top:2px;"
                        >Add Entry
                    </button>
                </div>
                @endcan
            </div>
            <div class="card-datatable table-responsive" wire:ignore>
                <table class="table border-top" id="tableInputs">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>File</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($files as $file)
                        <tr>
                            <td>{{$file->id}}</td>
                            <td>{{$file->title}}</td>
                            <td><a href="{{asset('storage/' . $file->path)}}" target="_blank">View File</a></td>
                            <td>
                                <i class="ti ti-copy ti-sm cursor-pointer ms-2"
                                   onclick="copyUrl('{{asset('storage/' . $file->path)}}')"></i>
                                @can('file-edit')
                                    <i  class="ti ti-edit ti-sm cursor-pointer"
                                        data-bs-target="#fileModal"
                                        data-bs-toggle="modal"
                                        wire:click="editFile({{ $file->id }})"></i>
                                @endcan
                                @can('file-delete')
                                <a href="#" class="text-body delete-record delete-button" data-id="{{ $file->id }}">
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

        <!-- Form Inputs Modal-->
        <div wire:ignore.self class="modal fade" id="fileModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $modalId ? 'Edit' : 'Add' }} File</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="file" class="form-label">File</label>

                            <x-filepond wire:model="file"
                                file-path="{{ @$filePreview }}"
                                delete-event="deleteFile"
                                is-multiple="false" />

                            @error('gallery')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                        </div>

                        <div class="mb-3">
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

                        <div class="mb-3">
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

            document.addEventListener('DOMContentLoaded', function () {
                var modal = document.getElementById('fileModal');

                modal.addEventListener('hidden.bs.modal', function () {
                    Livewire.dispatch('reset-modal');
                });
            });

            function copyUrl(url) {
                navigator.clipboard.writeText(url)
                    .then(() => {
                        alert('URL copied to clipboard!');
                    })
                    .catch(err => {
                        console.error('Failed to copy: ', err);
                    });
            }
        </script>
        

    </div>

</div>