<div>

    <div>
        
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between">
                <h4 class="card-title mb-3">Grantees List</h4>
                <button wire:click="openModal()" class="btn btn-primary h-50">
                    Add Grantee
                </button>
            </div>
            <div class="card-datatable table-responsive" wire:ignore>
                <table class="table border-top" id="table">
                    <thead>
                    <tr>
                        <th>Order</th>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($project_grantees as $project_grantee)
                        <tr data-id="{{ $project_grantee->id }}" style="cursor: move;">
                            <td>{{ $project_grantee->list_order }}</td>
                            <td>{{ $project_grantee->grantee->grantee_name }}</td>
                            <td>
                                <a href="#" wire:click="openModal({{ $project_grantee->id }})" class="text-body edit-user-button">
                                    <i class="ti ti-edit ti-sm"></i>
                                </a>
                                <a href="#" class="text-body delete-record delete-button" data-id="{{ $project_grantee->id }}"><i class="ti ti-trash ti-sm mx-2 text-danger"></i></a>
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
                                <label for="grantee_id" class="form-label">Grantee</label>
                                <select wire:model="grantee_id" id="grantee_id" class="form-control">
                                    <option value="">Select Grantee</option>
                                    @foreach($grantees as $grantee)
                                        <option value="{{ $grantee->id }}">{{ $grantee->grantee_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" wire:click="closeModal" class="btn btn-secondary">Cancel</button>
                            <button type="button" wire:click="saveGrantee" class="btn btn-primary">
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

    </div>

</div>
