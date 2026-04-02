<div>

    <div>
        
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between">
                <h4 class="card-title mb-3">Jurors List</h4>
            </div>
            <div class="card-datatable table-responsive" wire:ignore>
                <table class="table dataTable border-top" id="table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($assigns as $assign)
                        <tr>
                            <td>{{ $assign->user->id }}</td>
                            <td>{{ $assign->user->first_name.' '.$assign->user->last_name }}</td>
                            <td>{{ $assign->user->email }}</td>
                            <td>{{ $assign->user->phone }}</td>
                            <td></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>

    </div>


</div>
