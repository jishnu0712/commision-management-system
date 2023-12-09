<x-layout>
    <x-slot name="title">User update</x-slot>
    <x-slot name="content">
        <div class="content-wrapper">
            <div class="container-full">
                <!-- Main content -->
                <section class="content">
                    @include('alert.alert')
                    <form method="post" id="addItemForm" action="{{ route('user.update') }}" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-xl-12 col-12">
                                <div class="box">
                                    <div class="box-header with-border">
                                        <h4 class="box-title">User Update</h4>
                                    </div>
                                    <div class="box-body">
                                        <div class="box-body">
                                            @csrf
                                            <input type="hidden" name="user_id" value="{{ request('user_id') }}">
                                            <div class="form-group row">
                                                <label class="col-sm-3 control-label">Name <span
                                                        class="input_required">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="name"
                                                        class="form-control @error('name') is-invalid @enderror"
                                                        required placeholder="Name" value="{{ $user->name }}">

                                                    <span class="error">
                                                        @error('name')
                                                            {{ $message }}
                                                        @enderror
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 control-label">Mobile <span
                                                        class="input_required">*</span></label>
                                                <div class="col-sm-9"><input type="number" step="any"
                                                        name="mobile"
                                                        class="form-control @error('mobile') is-invalid @enderror"
                                                        maxlength="10" required placeholder="Mobile"
                                                        value="{{ $user->mobile }}">
                                                    <span class="error">
                                                        @error('mobile')
                                                            {{ $message }}
                                                        @enderror
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 control-label">Email <span
                                                        class="input_required">*</span></label>
                                                <div class="col-sm-9"><input type="email" step="any"
                                                        name="email"
                                                        class="form-control @error('email') is-invalid @enderror"
                                                        required placeholder="Email" value="{{ $user->email }}">
                                                    <span class="error">
                                                        @error('email')
                                                            {{ $message }}
                                                        @enderror
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 control-label">Password <span
                                                        class="input_required"></span></label>
                                                <div class="col-sm-9"><input type="password" step="any"
                                                        name="password"
                                                        class="form-control @error('password') is-invalid @enderror"
                                                        placeholder="Password - (If you want to change)">
                                                    <span class="error">
                                                        @error('password')
                                                            {{ $message }}
                                                        @enderror
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-3 control-label">Image</label>
                                                <div class="col-sm-9"><input type="file" name="image"
                                                        class="form-control">
                                                    <span class="error">
                                                        @error('image')
                                                            {{ $message }}
                                                        @enderror
                                                    </span>
                                                    <br>
                                                    <img src="{{ asset('storage/profile_pic/' . $user->profile_pic) }}"
                                                        width="150px" height="150px">
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <button class="btn btn-rounded btn-primary" type="submit">Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="row">
                        <div class="col-xl-12 col-12">
                            <div class="box">
                                <form action="{{ route('user.permission') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ request('user_id') }}">
                                    <div class="box-header with-border">
                                        <h4 class="box-title">User Permissions</h4>
                                    </div>
                                    <div class="box-body">
                                        <div class="row">
                                            @foreach (config('custom.permissionsList') as $key => $permission)
                                                <div class="col-md-3 border">
                                                    <h3>{{ ucfirst($key) }}</h3>
                                                    <ul>
                                                        @foreach ($permission as $newKey => $per)
                                                            <li>
                                                                <input @checked(in_array( $key . '_' . $per, $userPermissions)) type="checkbox"
                                                                    name="{{ $key . '_' . $per }}"
                                                                    id="{{ $key . $per }}">
                                                                <label for="{{ $key . $per }}">
                                                                    {{ ucfirst($key) }} {{ ucfirst($per) }}
                                                                </label>

                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <button class="btn btn-rounded btn-warning" type="submit">Update
                                            Permission</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- /.content -->
            </div>
        </div>
    </x-slot>
</x-layout>
