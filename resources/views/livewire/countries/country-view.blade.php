<div>

    <div>
        
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between">
                <h4 class="card-title mb-3">Countries List</h4>
            </div>
            <div class="card-datatable table-responsive" wire:ignore>
                <table class="table dataTable border-top" id="table">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Active</th>
                        <th>Action</th>
                        
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($countries as $country)
                        <tr>
                            <td>{{ $country->id }}</td>
                            <td>{{ $country->name }}</td>
                            <td>{{ $country->active == 1 ? 'Yes': 'No' }}</td>
                            <td>
                                @if($country->active==0)
                                <button 
                                    wire:click="activate({{ $country->id }})" 
                                    class="px-4 rounded text-white btn-success">
                                    Activate
                                </button>
                                @elseif($country->active==1)
                                <button 
                                    wire:click="deactivate({{ $country->id }})" 
                                    class="px-4 rounded text-white btn-danger">
                                    Deactivate
                                </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>

    </div>

</div>
