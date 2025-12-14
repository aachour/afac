<div>

    <div>
        
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between">
                <h4 class="card-title mb-3">Logo Elements List</h4>
            </div>
            <div class="card-datatable table-responsive" wire:ignore>
                <table class="table dataTable border-top" id="table">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Text</th>
                        <th>Active</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($logos as $logo)
                        <tr>
                            <td>{{ $logo->id }}</td>
                            <td>{{ $logo->name }}</td>
                            <td>{{ $logo->text }}</td>
                            <td>
                                <button 
                                    wire:click="toggleActivate({{ $logo->id }})" 
                                    class="px-4 rounded text-white 
                                        {{ $logo->status ? 'btn-success' : 'btn-danger' }}">
                                        {{ $logo->status == 1 ? 'Yes' : 'No' }}
                                </button>
                            </td>
                            <td>
                                <a href="#" wire:click="openModal({{ $logo->id }})" class="text-body edit-user-button">
                                    <i class="ti ti-edit ti-sm"></i>
                                </a>
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
                                <label for="ColorCode" class="form-label">Text</label>
                                <input type="text"
                                    class="form-control @error('text') is-invalid @enderror"
                                    id="text"
                                    wire:model="text"
                                    placeholder="text">
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="ColorCode" class="form-label">Text Arabic</label>
                                <input type="text"
                                    class="form-control @error('text_arabic') is-invalid @enderror"
                                    id="text_arabic"
                                    wire:model="text_arabic"
                                    placeholder="text_arabic">
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" wire:click="closeModal" class="btn btn-secondary">Cancel</button>
                            <button type="button" wire:click="saveLogo" class="btn btn-primary">
                                {{ $editingId ? 'Update' : 'Save' }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>

</div>
