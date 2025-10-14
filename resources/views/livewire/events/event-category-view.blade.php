<div>

    <div>
        
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between">
                <h4 class="card-title mb-3">Categories List</h4>
                <button wire:click="openModal()" class="btn btn-primary h-50">
                    Add Category
                </button>
            </div>
            <div class="card-datatable table-responsive" wire:ignore>
                <table class="table dataTable border-top" id="table">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Name Arabic</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->name_arabic }}</td>
                            <td>
                                <a href="#" wire:click="openModal({{ $category->id }})" class="text-body edit-user-button">
                                    <i class="ti ti-edit ti-sm"></i>
                                </a>
                                <a href="#" class="text-body delete-record delete-button" data-id="{{ $category->id }}"><i class="ti ti-trash ti-sm mx-2 text-danger"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>


        @if($showModal)
            <div class="modal fade show" tabindex="-1" style="display: block; background-color: rgba(0,0,0,0.5)">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ $modalTitle }}</h5>
                            <button type="button" wire:click="closeModal" class="btn-close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text"
                                    class="form-control @error('name') is-invalid @enderror"
                                    id="name"
                                    wire:model="name"
                                    placeholder="Name">
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Name Arabic</label>
                                <input type="text"
                                    class="form-control @error('name_arabic') is-invalid @enderror"
                                    id="name_arabic"
                                    wire:model="name_arabic"
                                    placeholder="Name Arabic">
                                @error('name_arabic')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" wire:click="closeModal" class="btn btn-secondary">Cancel</button>
                            <button type="button" wire:click="saveCategory" class="btn btn-primary">
                                {{ $editingId ? 'Update' : 'Save' }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @script
            @include('livewire.deleteConfirm')
        @endscript

    </div>

</div>
