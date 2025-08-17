<div>
    <!-- Users List Table -->
    <div class="card">
        <div class="card-header border-bottom d-flex justify-content-between">
            <h4 class="card-title mb-3">User List</h4>
            <a class="btn btn-primary h-50" href="{{ route('users.create') }}">Add User</a>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-users dataTable table border-top">
                <thead>
                 <tr>
                    <th>Id</th>
                    <th>Role</th>
                    <th>Username</th>
                    <th>E-mail</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->roles[0]->name ?? 'N/A' }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>
                            @can('user-edit')
                                <a href="{{ route('users.edit', $user->id) }}" class="text-body edit-user-button"><i class="ti ti-edit ti-sm me-2"></i></a>
                            @endcan
                            @if($user->id != 1)
                                @can('user-delete')
                                    <a href="#" class="text-body delete-record delete-button" data-id="{{ $user->id }}"><i class="ti ti-trash ti-sm mx-2 text-danger"></i></a>
                                @endcan
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>

    @script
        @include('livewire.deleteConfirm')
    @endscript


</div>

