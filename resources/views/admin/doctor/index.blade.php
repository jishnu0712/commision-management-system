<x-layout>
    <x-slot name="title">Doctors</x-slot>
    <x-slot name="content">
        <div class="content-wrapper">
            <div class="container-full">
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-12" style="margin-bottom:15px;">
                            <h3 style="float:left;">Doctors</h3>
                            <button onClick="add_new_banner()" type="button" class="waves-effect waves-light btn btn-light search_button" style="float: right;">Search</button>
                        </div>
                        <div id="add_new_banner" class="col-xl-12 col-lg-12 col-12">
                            <div class="box">
                                <form method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
                                    <div class="row search_advnced" style="padding: 20px;">
                                        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                            <div class="form-group">
                                                <label>Department Name</label><input type="text" name="dept_name" value="{{ request('dept_name') }}" class="form-control" placeholder="Department Name" />

                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12 col-lg-4 col-xl-3">
                                            <div class="form-group">
                                                <label>&nbsp;</label><button type="submit" class="btn btn-success btn-block">Search</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-12">
                            {{-- error --}}
                            <div class="box">
                                <div class="box-body">
                                    <div class="table-responsive-ipad overflow-auto">
                                        <table class="table table-striped table-hover">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Profile Pic</th>
                                                    <th>Name</th>
                                                    <th>Mobile</th>
                                                    <th>Email</th>
                                                    <th>Gender</th>
                                                    <th>Hospital Name</th>
                                                    <th>Address</th>
                                                    <th>Date Time</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="sortable_art">
                                                @foreach ($doctors as $doctor)
                                                <tr>
                                                    <td data-title="Sl No">
                                                        <a href="javascript:;">
                                                            <button type="button" class="waves-effect waves-light btn btn-primary">{{ ($doctors->currentPage() - 1) * $doctors->perPage() + $loop->iteration }}</button>
                                                        </a>
                                                    </td>
                                                    <td data-title="img">
                                                        <img width="80" alt="Profile pic" src="{{ asset('storage/doctors/profile_pic/' . $doctor->profile_pic) }}">
                                                    </td>
                                                    <td data-title="name">{{ $doctor->name }}</td>
                                                    <td data-title="description">
                                                        {{ $doctor->mobile }}
                                                    </td>
                                                    <td data-title="description">
                                                        {{ $doctor->email }}
                                                    </td>
                                                    <td data-title="description">
                                                        {{ ucfirst($doctor->gender) }}
                                                    </td>
                                                    <td data-title="description">
                                                        {{ $doctor->hospital_name }}
                                                    </td>
                                                    <td data-title="description">
                                                        {{ $doctor->address }}
                                                    </td>
                                                    <td data-title="Date Time">
                                                        {{ CustomHelper::dateFormat('d/m/Y h:i a', $doctor->created_at) }}
                                                    </td>
                                                    <td data-title="Action">
                                                        <a href="{{ route('doctor.edit', ['doctor_id' => encrypt($doctor->id)]) }}" class="btn btn-primary"><i class='fa fa-edit'></i></a>
                                                        {{-- <button data-rowId="{{ $doctor->id }}"
                                                        class="btn btn-danger removeRow"><i class='fa fa-trash'></i></button> --}}
                                                    </td>
                                                </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- pagination -->
                                    <div class="row mt-20">
                                        <div class="col-sm-12 col-md-5 d-flex flex-column-reverse">
                                            <div class="dataTables_info" id="example5_info" role="status" aria-live="polite">
                                                {{-- @if ($doctors->lastPage() > 1) --}}
                                                <p class="text-center text-muted float-left">
                                                    Showing {{ $doctors->firstItem() }} to {{ $doctors->lastItem() }} of
                                                    {{ $doctors->total() }} entries
                                                </p>
                                                {{-- @endif --}}
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-7">
                                            <div class="dataTables_paginate paging_simple_numbers">
                                                {{ $doctors->appends(request()->query())->links('pagination::bootstrap-4') }}
                                            </div>
                                        </div>
                                    </div>
                                    <!-- ./pagination./ -->
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- /.content -->
            </div>
        </div>
    </x-slot>
    <x-slot name="javascript">
        <script>
            $(document).ready(function() {
                softnicRms.itemListPage.init();
            });
        </script>
    </x-slot>
</x-layout>