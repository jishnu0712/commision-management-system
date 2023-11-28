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
                                        <table class="table table-striped table-hover">
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
                                                @foreach ($users as $user)
                                                    <tr>
                                                        <td data-title="Sl No">
                                                            <a href="javascript:;">
                                                                <button type="button"
                                                                    class="waves-effect waves-light btn btn-primary">{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</button>
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
                                    <!-- pagination -->
                                    <div class="row mt-20">
                                        <div class="col-sm-12 col-md-5 d-flex flex-column-reverse">
                                            <div class="dataTables_info" id="example5_info" role="status"
                                                aria-live="polite">
                                                {{-- @if ($users->lastPage() > 1) --}}
                                                <p class="text-center text-muted float-left">
                                                    Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of
                                                    {{ $users->total() }} entries
                                                </p>
                                                {{-- @endif --}}
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-7">
                                            <div class="dataTables_paginate paging_simple_numbers">
                                                {{ $users->appends(request()->query())->links('pagination::bootstrap-4') }}
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
