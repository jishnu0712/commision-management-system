<x-layout>
    <x-slot name="title">Add User</x-slot>
    <x-slot name="content">
        <div class="content-wrapper">
            <div class="container-full">
                <!-- Main content -->
                <section class="content">
                    @include('alert.alert')
                    <form method="post" id="addItemForm" action="{{ route('user.store') }}" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-xl-8 col-12">
                                <div class="box">
                                    <div class="box-header with-border">
                                        <h4 class="box-title">Item Information</h4>
                                    </div>
                                    <div class="box-body">
                                        <div class="box-body">
                                            @csrf
                                            <div class="form-group row">
                                                <label class="col-sm-3 control-label">Name <span class="input_required">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" required placeholder="Name">

                                                    <span class="error">@error('name') {{ $message }} @enderror</span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 control-label">Username</label>
                                                <div class="col-sm-9">
                                                    <input rows="5" class="form-control" name="username" placeholder="Username"/>

                                                    <span class="error">@error('username') {{ $message }} @enderror</span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 control-label">Mobile <span class="input_required">*</span></label>
                                                <div class="col-sm-9"><input type="number" step="any" name="mobile" class="form-control @error('mobile') is-invalid @enderror" 
                                                maxlength="10"
                                                required placeholder="mobile">
                                                    <span class="error">@error('mobile') {{ $message }} @enderror</span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 control-label">Email <span class="input_required">*</span></label>
                                                <div class="col-sm-9"><input type="email" step="any" name="email" class="form-control @error('email') is-invalid @enderror" required placeholder="email">
                                                    <span class="error">@error('email') {{ $message }} @enderror</span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 control-label">Password <span class="input_required">*</span></label>
                                                <div class="col-sm-9"><input type="password" step="any" name="password" class="form-control @error('password') is-invalid @enderror" required placeholder="password">
                                                    <span class="error">@error('password') {{ $message }} @enderror</span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 control-label">Confirm Password <span class="input_required">*</span></label>
                                                <div class="col-sm-9"><input type="password" step="any" name="confirm_password" class="form-control @error('confirm_password') is-invalid @enderror" required placeholder="confirm_password">
                                                    <span class="error">@error('confirm_password') {{ $message }} @enderror</span>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-3 control-label">Image</label>
                                                <div class="col-sm-9"><input type="file" name="image" class="form-control">
                                                    <span class="error">@error('image') {{ $message }} @enderror</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <button class="btn btn-rounded btn-primary" type="submit">Add Item</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </section>
                <!-- /.content -->
            </div>
        </div>
    </x-slot>
</x-layout>