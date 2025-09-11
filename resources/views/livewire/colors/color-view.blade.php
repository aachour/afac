<div>

    <div>
        
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between">
                <h4 class="card-title mb-3">Colors List</h4>
                <button wire:click="openModal()" class="btn btn-primary h-50">
                    Add Color
                </button>
            </div>
            <div class="card-datatable table-responsive" wire:ignore>
                <table class="table dataTable border-top" id="table">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($colors as $color)
                        <tr>
                            <td>{{ $color->id }}</td>
                            <td>{{ $color->name }}</td>
                            <td>{{ $color->code }}</td>
                            <td>
                                <a href="#" wire:click="openModal({{ $color->id }})" class="text-body edit-user-button">
                                    <i class="ti ti-edit ti-sm"></i>
                                </a>
                                <a href="#" class="text-body delete-record delete-button" data-id="{{ $color->id }}"><i class="ti ti-trash ti-sm mx-2 text-danger"></i></a>
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
                                <label for="ColorName" class="form-label">Color Name</label>
                                <input type="text"
                                    class="form-control @error('name') is-invalid @enderror"
                                    id="ColorName"
                                    wire:model="name"
                                    placeholder="Name">
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="ColorCode" class="form-label">Color Code</label>
                                <input type="text"
                                    class="form-control @error('code') is-invalid @enderror"
                                    id="ColorCode"
                                    wire:model="code"
                                    placeholder="Code">
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" wire:click="closeModal" class="btn btn-secondary">Cancel</button>
                            <button type="button" wire:click="saveColor" class="btn btn-primary">
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
