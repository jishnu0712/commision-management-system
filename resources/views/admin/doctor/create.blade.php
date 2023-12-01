<x-layout>
    <x-slot name="title">Add Doctor</x-slot>
    <x-slot name="content">
        <div class="content-wrapper">
            <div class="container-full">
                <!-- Main content -->
                <section class="content">
                    @include('alert.alert')
                    <form method="post" id="addItemForm" action="{{ route('doctor.store') }}" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-xl-12 col-12">
                                <div class="box">
                                    <div class="box-header with-border">
                                        <h4 class="box-title">Add Doctor</h4>
                                    </div>
                                    <div class="box-body">
                                        <div class="box-body">
                                            @csrf

                                            <div class="form-group row">
                                                <label class="col-sm-3 control-label">Doctor Name <span class="input_required">*</span></label>
                                                <div class="col-sm-9">
                                                    <input value="{{ old('name') }}" type="text" name="name" class="form-control @error('name') is-invalid @enderror" required placeholder="Doctor Name">

                                                    <span class="error">@error('name') {{ $message }} @enderror</span>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-3 control-label">Mobile<span class="input_required">*</span></label>
                                                <div class="col-sm-9">
                                                    <input value="{{ old('mobile') }}" type="text" name="mobile" class="form-control @error('mobile') is-invalid @enderror" required placeholder="Doctor Mobile">

                                                    <span class="error">@error('mobile') {{ $message }} @enderror</span>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-3 control-label">Email<span class="input_required"></span></label>
                                                <div class="col-sm-9">
                                                    <input value="{{ old('email') }}" type="text" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Doctor Email">

                                                    <span class="error">@error('email') {{ $message }} @enderror</span>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-3 control-label">Specialization<span class="input_required"></span></label>
                                                <div class="col-sm-9">
                                                    <input value="{{ old('specialization') }}" type="text" name="specialization" class="form-control @error('specialization') is-invalid @enderror" placeholder="Doctor Specialization">

                                                    <span class="error">@error('specialization') {{ $message }} @enderror</span>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-3 control-label">Gender<span class="input_required"></span></label>
                                                <div class="col-sm-9">
                                                    <select name="gender" class="form-control @error('gender') is-invalid @enderror">
                                                        <option value="male">Male</option>
                                                        <option value="female">Female</option>
                                                    </select>

                                                    <span class="error">@error('gender') {{ $message }} @enderror</span>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-3 control-label">Hospital Name<span class="input_required"></span></label>
                                                <div class="col-sm-9">
                                                    <input value="{{ old('hospital_name') }}" type="text" name="hospital_name" class="form-control @error('hospital_name') is-invalid @enderror" placeholder="Hospital Name">

                                                    <span class="error">@error('hospital_name') {{ $message }} @enderror</span>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-3 control-label">Profile pic<span class="input_required"></span></label>
                                                <div class="col-sm-9">
                                                    <input type="file" name="profile_pic" class="form-control @error('profile_pic') is-invalid @enderror">

                                                    <span class="error">@error('profile_pic') {{ $message }} @enderror</span>
                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <label class="col-sm-3 control-label">Address <span class="input_required">*</span></label>
                                                <div class="col-sm-9">
                                                    <textarea requireds rows="5" class="form-control" required name="address" placeholder="address">{{ old('address') }}</textarea>
                                                    <span class="error">@error('address') {{ $message }} @enderror</span>
                                                </div>
                                            </div>
                                            <hr/>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h3>Add percentage (Department wise)</h3>
                                                </div>
                                            </div>
                                            <div class="row">
                                                @foreach($departments as $department)
                                                    <div class="col-md-3">
                                                        <label class="control-label">{{ $department->dept_name }}</label>
                                                        <input type="text" name="percentage[{{ $department->id }}]" class="form-control" placeholder="{{ $department->dept_name }} percentage" value="0">
                                                    </div>
                                                @endforeach
                                            </div>

                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <button class="btn btn-rounded btn-primary" type="submit">Add</button>
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