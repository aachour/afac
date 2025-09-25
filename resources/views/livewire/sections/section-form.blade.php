<div>
    <div class="row">
        <div class="col-xl">
            <form wire:submit="store" class="row g-3">

                <div class="col-12">
                    
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">{{ $editing ? "Edit" : "Create" }} Section</h5>
                            <a href="{{ route('pages') }}" class="btn btn-primary mb-2 text-nowrap">
                                Pages
                            </a>
                        </div>
                        <div class="card-body">

                            <div class="row">

                                <div class="col-12 col-md-6 mt-2">
                                    <label class="form-label" for="name">Page Name <span class="text-danger">*</span></label>
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
