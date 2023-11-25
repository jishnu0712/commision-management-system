<x-layout>
    <x-slot name="title">Department update</x-slot>
    <x-slot name="content">
        <div class="content-wrapper">
            <div class="container-full">
                <!-- Main content -->
                <section class="content">
                    @include('alert.alert')
                    <form method="post" id="addItemForm" action="{{ route('department.update') }}" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-xl-8 col-12">
                                <div class="box">
                                    <div class="box-header with-border">
                                        <h4 class="box-title">Department Update</h4>
                                    </div>
                                    <div class="box-body">
                                        <div class="box-body">
                                            @csrf
                                            <input type="hidden" name="department_id" value="{{ request('department_id') }}">
                                            <div class="form-group row">
                                                <label class="col-sm-3 control-label">Department <span class="input_required">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="dept_name" class="form-control @error('name') is-invalid @enderror" required placeholder="Department" value="{{ $department->dept_name }}">

                                                    <span class="error">@error('dept_name') {{ $message }} @enderror</span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 control-label">Description </label>
                                                <div class="col-sm-9">
                                                   <textarea rows="5" class="form-control" name="description" placeholder="Description">{{ $department->description }}</textarea>
                                                   <span class="error">@error('description') {{ $message }} @enderror</span>
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
                </section>
                <!-- /.content -->
            </div>
        </div>
    </x-slot>
</x-layout>