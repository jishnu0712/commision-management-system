<x-layout>
    <x-slot name="title">Doctors</x-slot>
    <x-slot name="content">
        @php
        $userPermission = json_decode(auth()->user()->permissions);
        @endphp
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
                                                <label>Department Name</label>
                                                <input type="text" name="dept_name" value="{{ request('dept_name') }}" class="form-control" placeholder="Department Name" />

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
                        </div>
                        <div class="col-12">
                            {{-- error --}}
                            <div class="box">
                                <div class="box-body">
                                    <div class="table-responsive-ipad overflow-auto">
                                        <table id="doctors-table" class="table table-striped table-hover">
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
                                                    @if (in_array('doctor_edit', $userPermission))
                                                    <th>Action</th>
                                                    @endif
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
                                                    @if (in_array('doctor_edit', $userPermission))
                                                    <td data-title="Action">
                                                        <a href="{{ route('doctor.edit', ['doctor_id' => encrypt($doctor->id)]) }}" class="btn btn-primary"><i class='fa fa-edit'></i></a>
                                                        {{-- <button data-rowId="{{ $doctor->id }}"
                                                        class="btn btn-danger removeRow"><i class='fa fa-trash'></i></button> --}}
                                                    </td>
                                                    @endif
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
                    "pageLength": 10,  // Number of entries to show per page
                    "searching": true,  // Enable searching
                    // Add more options as needed
                });

                softnicRms.itemListPage.init();
            });
        </script>
    </x-slot>
</x-layout>