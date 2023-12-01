<x-layout>
    <x-slot name="title">Users</x-slot>
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
                            <h3 style="float:left;">Users</h3>
                            <button onClick="add_new_banner()" type="button"
                                class="waves-effect waves-light btn btn-light search_button"
                                style="float: right;">Search</button>
                        </div>
                        <div id="add_new_banner" class="col-xl-12 col-lg-12 col-12">
                            <div class="box">
                                <form method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
                                    <div class="row search_advnced" style="padding: 20px;">
                                        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                            <div class="form-group">
                                                <label>Name</label><input type="text" name="name"
                                                    value="{{ request('name') }}" class="form-control"
                                                    placeholder="Name" />

                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                            <div class="form-group">
                                                <label>Email</label><input type="email" name="email"
                                                    value="{{ request('email') }}" class="form-control"
                                                    placeholder="Email" />

                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                            <div class="form-group">
                                                <label>Mobile</label><input type="number" maxlength="10" name="mobile"
                                                    value="{{ request('mobile') }}" class="form-control"
                                                    placeholder="Mobile" />

                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12 col-lg-4 col-xl-3">
                                            <div class="form-group">
                                                <label>&nbsp;</label><button type="submit"
                                                    class="btn btn-success btn-block">Search</button>
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
                                        <table id="users-table" class="table table-striped table-hover">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Image</th>
                                                    <th>Name</th>
                                                    <th>Mobile</th>
                                                    <th>Email</th>
                                                    <th>Date Time</th>
                                                    @if (in_array('users_edit', $userPermission))
                                                        <th>Action</th>
                                                    @endif
                                                </tr>
                                            </thead>
                                            <tbody id="sortable_art">
                                                @foreach ($users as $key => $user)
                                                    <tr>
                                                        <td data-title="Sl No">
                                                            <a href="javascript:;">
                                                                <button type="button"
                                                                    class="waves-effect waves-light btn btn-primary">{{ $key + 1 }}</button>
                                                            </a>
                                                        </td>
                                                        <td data-title="img">
                                                            <img width="80" alt="Profile pic"
                                                                src="{{ asset('storage/profile_pic/' . $user->profile_pic) }}">
                                                        </td>
                                                        <td data-title="name">{{ $user->name }}</td>
                                                        <td data-title="mobile">
                                                            {{ $user->mobile }}</td>
                                                        <td data-title="email">
                                                            {{ $user->email }}</td>
                                                        <td data-title="Date Time">
                                                            {{ CustomHelper::dateFormat('d/m/Y h:i a', $user->created_at) }}
                                                        </td>
                                                        @if (in_array('users_edit', $userPermission))
                                                            <td data-title="Action">
                                                                <a href="{{ route('user.edit', ['user_id' => encrypt($user->id)]) }}"
                                                                    class="btn btn-primary"><i
                                                                        class='fa fa-edit'></i></a>
                                                                {{-- <button data-rowId="{{ $user->id }}"
                                                                class="btn btn-danger removeRow"><i
                                                                    class='fa fa-trash'></i></button> --}}
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
                $('#users-table').DataTable({
                    "pageLength": 10,  // Number of entries to show per page
                    "searching": true,  // Enable searching
                    // Add more options as needed
                });

                softnicRms.itemListPage.init();
            });
        </script>
    </x-slot>
</x-layout>
