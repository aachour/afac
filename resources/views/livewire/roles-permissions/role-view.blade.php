<div>
    <div>
        <div class="d-flex justify-content-between">
            <div>
                <h4 class="fw-semibold">Role Tittle</h4>
                <p>
                    Description
                </p>
            </div>
            <div class="text-end align-self-end">
                @can('role-create')
                <button
                    wire:click="clearData"
                    data-bs-target="#saveRoleModal"
                    data-bs-toggle="modal"
                    class="btn btn-primary mb-2 text-nowrap add-new-role"
                >
                    Add Role
                </button>
                @endcan
            </div>
        </div>
    </div>

    <!-- Role cards -->
    <div class="row g-4">
        <div class="col-12">
            <!-- Role Table -->
            <div class="card">
                <div class="table-responsive">
                    <table class="datatables-roles table border-top" id="roles_datatable">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($roles as $key => $role)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                <span class='text-truncate d-flex align-items-center'>
                                    @if( isset(\App\Utils\Constants::ROLE_SETTINGS[$role->id]) )
                                        <?php echo \App\Utils\Constants::ROLE_SETTINGS[$role->id]['badge']; ?>
                                    @else
                                        <span class="badge badge-center rounded-pill bg-label-info me-3 w-px-30 h-px-30"><i class="ti ti-edit ti-sm"></i></span>
                                    @endif
                                    {{ $role->name }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @can('role-edit')
                                        @if($role->id != \App\Utils\Constants::SUPER_ADMIN_ROLE_ID)
                                            <a wire:click="edit({{ $role->id }})" href="#" data-bs-toggle="modal" data-bs-target="#saveRoleModal" class="text-body edit-user-button"><i class="ti ti-edit ti-sm me-2"></i></a>
                                            @can('role-delete')
                                            <a href="#" class="text-body delete-record delete-button" data-id="{{ $role->id }}"><i class="ti ti-trash ti-sm mx-2 text-danger"></i></a>
                                            @endcan
                                        @endif
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!--/ Role Table -->
        </div>
    </div>
    <!--/ Role cards -->

    <!-- Add Role Modal -->
    <div wire:ignore.self class="modal fade" id="saveRoleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-add-new-role">
            <div class="modal-content p-3 p-md-5">
                <button
                    type="button"
                    class="btn-close btn-pinned"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h3 class="role-title mb-2">{{ $editing ? 'Edit' : 'Add' }} {{ 'Role'}}</h3>
                        <p class="text-muted">Set Role Permissions</p>
                    </div>
                    <!-- Add role form -->
                    <form wire:submit.prevent="store" id="addRoleForm" class="row g-3">
                        <div class="col-12 mb-4">
                            <label class="form-label" for="modalRoleName">Name </label>
                            <input
                                wire:model.defer="name"
                                type="text"
                                id="modalRoleName"
                                name="modalRoleName"
                                class="form-control"
                                placeholder="Enter a role name"
                                tabindex="-1"
                            />
                            @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-12">
                            <h5>Role Permission</h5>
                            <!-- Permission table -->
                            <div class="table-responsive">
                                <table class="table table-flush-spacing">
                                    <tbody>
                                    <tr>
                                        <td class="text-nowrap fw-semibold">
                                            Administrator Access
                                            <i
                                                class="ti ti-info-circle"
                                                data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                title="Allows a full access to the system"
                                            ></i>
                                        </td>
                                        <td>
                                            <div class="form-check">
                                                <input wire:click="selectAllPermissions" class="form-check-input" {{ $isAllPermissionsSelected ? "checked" : "" }} type="checkbox" id="selectAll"
                                                  {{ $allowPermissionEditing ? "" : "disabled" }}  />
                                                <label class="form-check-label" for="selectAll"> Select All </label>
                                            </div>
                                        </td>
                                    </tr>
                                    @foreach($filteredPermissions as $key => $permissions)
                                    <tr class="{{ $loop->iteration % 2 == 0 ? "bg-light" : "" }}">
                                        <td class="text-nowrap fw-semibold text-center">{{ ucfirst($key) }} Management</td>
                                        <td>
                                            <div class="d-flex">
                                                @foreach($permissions as $permission)
                                                <div class="form-check me-3 me-lg-5">
                                                    <input wire:click="togglePermission('{{ $key . "-" . $permission['name'] }}')" class="form-check-input" type="checkbox" id="permission_{{ $permission['id'] }}" value="{{ $permission['id'] }}"
                                                      {{ in_array($key . "-" . $permission['name'], $selectedPermissions) ? "checked" : "" }} {{ $allowPermissionEditing ? "" : "disabled" }} />
                                                    <label class="form-check-label" for="permission_{{ $permission['id'] }}"> {{ ucfirst($permission['name']) }} </label>
                                                </div>
                                                @endforeach
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- Permission table -->
                        </div>
                        <div class="col-12 text-center mt-4">
                            <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit
</button>
                            <button
                                type="reset"
                                class="btn btn-label-secondary close-modal"
                                data-bs-dismiss="modal"
                                aria-label="Close"
                            >
                                Cancel
                            </button>
                        </div>
                    </form>
                    <!--/ Add role form -->
                </div>
            </div>
        </div>
    </div>
    <!--/ Add Role Modal -->

    @script
        @include('livewire.deleteConfirm')
    @endscript
</div>
