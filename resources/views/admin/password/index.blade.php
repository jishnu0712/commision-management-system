<x-layout>
    <x-slot name="title">Change Password</x-slot>
    <x-slot name="content">
        <div class="content-wrapper">
            <div class="container-full">
                <!-- Main content -->
                <section class="content">
                    @include('alert.alert')
                    <div class="row">

                        <div class="col-xl-10 col-12">
                            <div class="box">
                                <form method="post" action="{{ route('password.update') }}" enctype="multipart/form-data"
                                    id="updateSettingsForm">
                                    @csrf
                                    <div class="box-header with-border">
                                        <h4 class="box-title">Change Password</h4>
                                    </div>

                                    <div class="box-body">
                                        <div class="box-body">
                                            <div class="form-group row">
                                                <label class="col-sm-3 control-label">Current Password<span
                                                        class="input_required">*</span></label>
                                                <div class="col-sm-9"><input type="password" name="current_password"
                                                        class="form-control" placeholder="Current Password" required
                                                        onpaste="return false" ondrop="return false">
                                                    <span class="error">
                                                        @error('current_password')
                                                            {{ $message }}
                                                        @enderror
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-3 control-label">New Password<span
                                                        class="input_required">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="password" name="new_password"
                                                        placeholder="New Password" class="form-control" required
                                                        onpaste="return false" ondrop="return false">
                                                    <span class="error">
                                                        @error('new_password')
                                                            {{ $message }}
                                                        @enderror
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-3 control-label">Confirm Password <span
                                                        class="input_required">*</span></label>
                                                <div class="col-sm-9"><input type="password" name="confirm_password"
                                                        class="form-control" placeholder="Confirm Password" required
                                                        onpaste="return false" ondrop="return false">
                                                    <span class="error">
                                                        @error('confirm_password')
                                                            {{ $message }}
                                                        @enderror
                                                    </span>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="box-footer">
                                        <button class="btn btn-rounded btn-primary" type="submit">UPDATE</button>
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
