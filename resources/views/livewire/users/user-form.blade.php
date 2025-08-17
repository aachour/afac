<div>
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ $editing ? ($status == \App\Utils\Constants::VIEW_STATUS ? 'View': ($status == \App\Utils\Constants::CONFIRM_STATUS ? 'Confirm' : 'Edit')) : 'Add' }} User </h5>
                    <a href="{{ route('users') }}"
                        class="btn btn-primary mb-2 text-nowrap">
                        Users
                    </a>
                </div>
                <div class="card-body">
                    <form class="row g-3">

                        <div class="col-12 col-md-6">
                            <label class="form-label" for="UserFirstName">First Name</label>
                            <input
                                wire:model.defer="first_name"
                                type="text"
                                id="UserFirstName"
                                name="UserFirstName"
                                class="form-control"
                                placeholder="John" />
                            @error('first_name') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="UserLastName">Last Name</label>
                            <input
                                wire:model.defer="last_name"
                                type="text"
                                id="UserLastName"
                                name="UserLastName"
                                class="form-control"
                                placeholder="Doe" />
                            @error('last_name') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="UserName">Username</label>
                            <input
                                wire:model.defer="username"
                                type="text"
                                id="UserName"
                                name="UserName"
                                class="form-control"
                                placeholder="john.doe.007" />
                            @error('username') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="UserEmail">E-mail</label>
                            <input
                                wire:model.defer="email"
                                type="text"
                                id="UserEmail"
                                name="UserEmail"
                                class="form-control"
                                placeholder="example@domain.com" />
                            @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        @if($editing && $user->id != 1 || !$editing)
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="UserRole">Role</label>
                            <select
                                wire:model.defer="role_name"
                                id="UserRole"
                                name="UserRole"
                                class="form-select"
                                aria-label="Default select example">
                                <option value="" selected>Select Role</option>
                                @foreach($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            @error('role_name') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                        @endif
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="UserPhone">Phone</label>
                            <div class="input-group">
                                <input
                                    wire:model.defer="phone"
                                    type="text"
                                    id="UserPhone"
                                    name="UserPhone"
                                    class="form-control"
                                    placeholder="202 555 0111" 
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                    />
                            </div>
                            @error('phone') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-password-toggle">
                                <label class="form-label" for="UserPassword">Password</label>
                                <div class="input-group">
                                    <input
                                        wire:model.defer="password"
                                        type="password"
                                        class="form-control"
                                        id="UserPassword"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="basic-default-password2" />
                                    <span id="basic-default-password2" class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                                </div>
                            </div>
                            @error('password') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-password-toggle">
                                <label class="form-label" for="UserConfirmPassword">Password Confirmation</label>
                                <div class="input-group">
                                    <input
                                        wire:model.defer="password_confirmation"
                                        type="password"
                                        class="form-control"
                                        id="UserConfirmPassword"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="basic-default-password-confirmation2" />
                                    <span id="basic-default-password-confirmation2" class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                                </div>
                            </div>
                            @error('password_confirmation') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>                         

                    </form>
                </div>

            </div>

            @if(!$status)
            <div class="col-12 text-end mt-2">
                <button wire:click="{{ $editing ? "update" : "store" }}" type="button" class="btn btn-primary me-sm-3 me-1">Submit</button>
            </div>
            @endif
        </div>
    </div>

    @script
    <script>
        document.addEventListener('livewire:navigated', function() {
            $(document).ready(function() {

                if (usersList) {
                    Sortable.create(usersList, {
                        animation: 150,
                        group: 'taskList',
                        onEnd: updateOrder
                    });
                }

            });
        })
        document.addEventListener('livewire:navigated', function() {
            var status = {{$status}};
            if (status == "1") {
                $('input').prop('disabled', true);
            }
        });

        function submit(action) {
            window.livewire.emit(action)
        }

        $('.selectpicker').selectpicker();

        Livewire.hook('morph.added', ({el}) => {
            $('.selectpicker').selectpicker();
        })

        $(document).on('change', '.selectpicker', function() {
            @this.set($(this).attr('wire:model'), $(this).val())
        })
    </script>
    @endscript


</div>