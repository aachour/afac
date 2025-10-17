<div>
    <div class="row">
        <div class="col-xl">
            <form wire:submit="store" class="row g-3">

                <div class="col-12">
                    
                    <div class="card">
                        
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">{{ $editing ? "Edit" : "Create" }} Section</h5>
                            @if($page_id!=null)
                                <a href="{{ route('sections',['pageId'=>$page_id]) }}" class="btn btn-primary mb-2 text-nowrap">
                                    Sections
                                </a>
                            @elseif($entry_id!=null)
                                <a href="{{ route('entry.sections',['entryId'=>$entry_id]) }}" class="btn btn-primary mb-2 text-nowrap">
                                    Sections
                                </a>
                            @endif
                        </div>
                        
                        <div class="card-body">

                            <div class="row">

                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="name">Section Name <span class="text-danger">*</span></label>
                                    <input
                                        wire:model="name"
                                        type="text"
                                        id="name"
                                        class="form-control"
                                        placeholder="Page Name" />
                                    @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                            </div>

                        </div>

                    </div>

                    

                    @foreach($columns as $key=>$column)

                        <div class="card mt-5">
                            
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Column {{($key +1)}}</h5>
                                @if(!$loop->first)
                                <button type="button" class="btn btn-danger me-sm-3 me-1" wire:click="DeleteColumn({{$key}})">Delete</button>
                                @endif
                            </div>
                            
                        
                            <div class="card-body">

                                <div class="row">

                                    <div class="col-12 col-md-6 mt-2">
                                        <label class="form-label" for="name">
                                            Column Type <span class="text-danger">*</span>
                                        </label>
                                        
                                        @foreach($this->columnTypes as $type)
                                            <div class="form-check mt-1">
                                                <input 
                                                    wire:model="columns.{{$key}}.type_id" 
                                                    class="form-check-input" 
                                                    type="radio" 
                                                    id="columns.{{$key}}.type_id" 
                                                    value="{{ $type->id }}" 
                                                >
                                                <label class="form-check-label" for="columns.{{$key}}.type_id">
                                                    {{ ucfirst($type->name) }}
                                                </label>
                                            </div>
                                        @endforeach

                                        @error('name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-12 col-md-6 mt-4">
                                        <label class="form-label" for="name">
                                            Column Alignment <span class="text-danger">*</span>
                                        </label>
                                        
                                        @foreach($this->alignmentTypes as $alignment)
                                            <div class="form-check mt-1">
                                                <input 
                                                    wire:model="columns.{{$key}}.alignment_id" 
                                                    class="form-check-input" 
                                                    type="radio" 
                                                    id="columns.{{$key}}.alignment_id" 
                                                    value="{{ $alignment->id }}" 
                                                >
                                                <label class="form-check-label" for="columns.{{$key}}.alignment_id">
                                                    {{ ucfirst($alignment->name) }}
                                                </label>
                                            </div>
                                        @endforeach

                                        @error('name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror

                                    </div>
                                </div>

                            </div>

                            @if($loop->last && $columns_num<$columns_max)
                            <div class="mt-3 mb-3 text-end">
                                <button type="button" class="btn btn-secondary me-sm-3 me-1" wire:click="AddColumn">Add New Column</button>
                            </div>
                            @endif

                        </div>

                    @endforeach
     
                </div>
                                

                <div class="col-12 text-end mt-4">
                    <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                </div>

            </form>

        </div>
    </div>

    <script>
       
    </script>
</div>
