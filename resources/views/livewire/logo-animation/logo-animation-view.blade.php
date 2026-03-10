<div>

    <div>
        
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between">
                <h4 class="card-title mb-3">Logo animation</h4>
            </div>
            <div class="card-datatable table-responsive" wire:ignore>
                <table class="table dataTable border-top" id="table">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Active</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{{ $logoAnimation->id }}</td>
                        <td>
                            <button 
                                wire:click="toggleActivate({{ $logoAnimation->id }})" 
                                class="px-4 rounded text-white 
                                    {{ $logoAnimation->active ? 'btn-success' : 'btn-danger' }}">
                                {{ $logoAnimation->active == 1 ? 'Yes' : 'No' }}
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>

            </div>
        </div>

        @script
            @include('livewire.deleteConfirm')
        @endscript

    </div>

</div>
