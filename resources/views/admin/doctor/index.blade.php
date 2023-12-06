<x-layout>
    <x-slot name="title">Doctors</x-slot>
    <x-slot name="content">
        <style>
            .table {
                font-size: 12px;
            }
        </style>
        @php
        $userPermission = json_decode(auth()->user()->permissions);
        @endphp
        <div class="content-wrapper">
            <div class="container-full">
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        {{-- <div class="col-xl-12 col-lg-12 col-12" style="margin-bottom:15px;">
                            <h3 style="float:left;">Doctors</h3>
                            <button onClick="add_new_banner()" type="button"
                                class="waves-effect waves-light btn btn-light search_button"
                                style="float: right;">Search</button>
                        </div> --}}
                        {{-- <div id="add_new_banner" class="col-xl-12 col-lg-12 col-12">
                            <div class="box">
                                <form method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
                                    <div class="row search_advnced" style="padding: 20px;">
                                        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                            <div class="form-group">
                                                <label>Department Name</label>
                                                <input type="text" name="dept_name"
                                                    value="{{ request('dept_name') }}" class="form-control"
                        placeholder="Department Name" />

                        <label>Doctor Name</label>
                        <input type="text" name="doctor_name" value="{{ request('doctor_name') }}" class="form-control" placeholder="Doctor Name" />

                        <label>Hospital Name</label>
                        <input type="text" name="hospital_name" value="{{ request('hospital_name') }}" class="form-control" placeholder="Doctor Name" />
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
        </div> --}}
        <div class="col-12">
            {{-- error --}}
            <div class="box">
                <div class="box-body">
                    <div class="row">

                        <div class="col-md-8">
                            <a href="{{ route('doctor.download') }}" class="btn btn-primary printButton float-right" target="_blank"><i class="fa fa-print"></i>Print All Doctors</a>
                        </div>
                    </div>
                    <div class="table-responsive-ipad overflow-auto">
                        <table id="doctors-table" class="table table-striped table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Profile Pic</th>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Mobile</th>
                                    <th>Email</th>
                                    <th>Gender</th>
                                    <th>Hospital Name</th>
                                    <th>Date Time</th>
                                    @if (in_array('doctor_edit', $userPermission))
                                    <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody id="sortable_art">
                                @foreach ($doctors as $key => $doctor)
                                <tr>
                                    <td data-title="Sl No">
                                        <a href="javascript:;">
                                            <button type="button" class="waves-effect waves-light btn btn-primary btn-sm">{{ $key + 1 }}</button>
                                        </a>
                                    </td>
                                    <td data-title="img">
                                        <img class="rounded" width="35px" height="35px" alt="Profile pic" src="{{ asset('storage/doctors/profile_pic/' . (!empty($doctor->profile_pic) ? $doctor->profile_pic : 'profile_pic.png')) }}">

                                    </td>
                                    <td data-title="name"><a href="{{ route('transaction.view', ['doctor_id' => encrypt($doctor->id)]) }}">{{ $doctor->name }}</a></td>
                                    <td data-title="description">
                                        {{ $doctor->address }}
                                    </td>
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
                                    <td data-title="Date Time">
                                        {{ CustomHelper::dateFormat('d/m/Y h:i a', $doctor->created_at) }}
                                    </td>
                                    <td data-title="Action">
                                        @if (in_array('doctor_edit', $userPermission))
                                        <a href="{{ route('doctor.edit', ['doctor_id' => encrypt($doctor->id)]) }}" class="btn btn-primary"><i class='fa fa-edit'></i></a>
                                        @endif
                                        @if (in_array('doctor_delete', $userPermission))
                                        <button data-rowId="{{ encrypt($doctor->id) }}" class="btn btn-danger removeRow"><i class='fa fa-trash'></i></button>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>

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
    <x-slot name="javascript">
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

        <script>
            $(document).ready(function() {
                // Initialize DataTable
                $('#doctors-table').DataTable({
                    "pageLength": 50, // Number of entries to show per page
                    "searching": true, // Enable searching
                    // Add more options as needed
                });

                softnicRms.doctorListPage.init();
            });
        </script>
    </x-slot>
</x-layout>