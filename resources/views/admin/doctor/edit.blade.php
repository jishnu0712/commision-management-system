<x-layout>
    <x-slot name="title">Doctor update</x-slot>
    <x-slot name="content">
        <div class="content-wrapper">
            <div class="container-full">
                <!-- Main content -->
                <section class="content">
                    @include('alert.alert')
                    <form method="post" id="addItemForm" action="{{ route('doctor.update') }}" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-xl-12 col-12">
                                <div class="box">
                                    <div class="box-header with-border">
                                        <h4 class="box-title">Doctor Update</h4>
                                    </div>
                                    <div class="box-body">
                                        <div class="box-body">
                                            @csrf
                                            <input type="hidden" name="doctor_id" value="{{ request('doctor_id') }}">
                                            <div class="form-group row">
                                                <label class="col-sm-3 control-label">Doctor Name <span class="input_required">*</span></label>
                                                <div class="col-sm-9">
                                                    <input value="{{ $doctor->name }}" type="text" name="name" class="form-control @error('name') is-invalid @enderror" required placeholder="Doctor Name">

                                                    <span class="error">@error('name') {{ $message }} @enderror</span>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-3 control-label">Mobile<span class="input_required">*</span></label>
                                                <div class="col-sm-9">
                                                    <input value="{{ $doctor->mobile }}" type="text" name="mobile" class="form-control @error('mobile') is-invalid @enderror" required placeholder="Doctor Mobile">

                                                    <span class="error">@error('mobile') {{ $message }} @enderror</span>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-3 control-label">Email<span class="input_required">*</span></label>
                                                <div class="col-sm-9">
                                                    <input value="{{ $doctor->email }}" type="text" name="email" class="form-control @error('email') is-invalid @enderror" required placeholder="Doctor Email">

                                                    <span class="error">@error('email') {{ $message }} @enderror</span>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-3 control-label">Specialization<span class="input_required">*</span></label>
                                                <div class="col-sm-9">
                                                    <input value="{{ $doctor->specialization }}" type="text" name="specialization" class="form-control @error('specialization') is-invalid @enderror" required placeholder="Doctor Specialization">

                                                    <span class="error">@error('specialization') {{ $message }} @enderror</span>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-3 control-label">Gender<span class="input_required">*</span></label>
                                                <div class="col-sm-9">
                                                    <select name="gender" class="form-control @error('gender') is-invalid @enderror" required>
                                                        <option @selected($doctor->gender == 'male') value="male">Male</option>
                                                        <option @selected($doctor->gender == 'female') value="female">Female</option>
                                                    </select>

                                                    <span class="error">@error('gender') {{ $message }} @enderror</span>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-3 control-label">Hospital Name<span class="input_required">*</span></label>
                                                <div class="col-sm-9">
                                                    <input value="{{ $doctor->hospital_name }}" type="text" name="hospital_name" class="form-control @error('hospital_name') is-invalid @enderror" required placeholder="Hospital Name">

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
                                                <label class="col-sm-3 control-label">Address </label>
                                                <div class="col-sm-9">
                                                    <textarea rows="5" class="form-control" name="address" placeholder="address">{{ $doctor->address }}</textarea>
                                                    <span class="error">@error('address') {{ $message }} @enderror</span>
                                                </div>
                                            </div>

                                            <hr/>
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <h3>Update percentage (Department wise)</h3>
                                                    <input type="number" class="form-control" id="defaultValue" placeholder="Default Value">
                                                </div>
                                                
                                                {{-- <div class="col-md-4">
                                                    <span style="float: right;"><a class="btn btn-primary btn-sm" href="{{ route('doctor.sync', ['doctor_id' => encrypt($doctor->id)]) }}">Sync Department</a></span>
                                                </div> --}}
                                            </div>
                                            <hr/>
                                            <div class="row">
                                                @foreach($percentages as $percentage)
                                                {{-- {{ $percentage }} --}}
                                                    <div class="col-md-3">
                                                        <label class="control-label">{{ $percentage->department->dept_name }} (%)</label>
                                                        <input type="text" name="percentage[{{ $percentage->id }}]" class="form-control" placeholder="{{ $percentage->department->dept_name }} percentage" value="{{ $percentage->percentage }}">
                                                    </div>
                                                @endforeach
                                            </div>

                                        </div>
                                    </div>

                                    <div class="box-footer">
                                        <button class="btn btn-rounded btn-primary" type="submit">Update</button>
                                    </div>
                                </div>
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
    <x-slot name="javascript">
        <script>
            $(document).ready(function(){
                $("#defaultValue").on("keyup", function(e){
                    e.preventDefault();
                    let $this = $(this);
                    let defaultValue = $this.val();
                    $(document).find('input[value="0.00"]').val(defaultValue);
                })
            })
        </script>
    </x-slot>
</x-layout>