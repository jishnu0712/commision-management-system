<x-layout>
    <x-slot name="title">Departments</x-slot>
    <x-slot name="content">
        <div class="content-wrapper">
            <div class="container-full">
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-12" style="margin-bottom:15px;">
                            <h3 style="float:left;">Departments</h3>
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
                                                <label>Department Name</label><input type="text" name="dept_name"
                                                    value="{{ request('dept_name') }}" class="form-control"
                                                    placeholder="Department Name" />

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
                                                    <th>Department</th>
                                                    <th>Description</th>
                                                    <th>Date Time</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="sortable_art">
                                                @foreach ($departments as $department)
                                                    <tr>
                                                        <td data-title="Sl No">
                                                            <a href="javascript:;">
                                                                <button type="button"
                                                                    class="waves-effect waves-light btn btn-primary">{{ ($departments->currentPage() - 1) * $departments->perPage() + $loop->iteration }}</button>
                                                            </a>
                                                        </td>
                                                        <td data-title="name">{{ $department->dept_name }}</td>
                                                        <td data-title="description">
                                                            {{ $department->description }}</td>
                                                        <td data-title="Date Time">
                                                            {{ CustomHelper::dateFormat('d/m/Y h:i a', $department->created_at) }}
                                                        </td>
                                                        <td data-title="Action">
                                                            <a href="{{ route('department.edit', ['department_id' => encrypt($department->id)]) }}"
                                                                class="btn btn-primary"><i class='fa fa-edit'></i></a>
                                                            {{-- <button data-rowId="{{ $department->id }}"
                                                                class="btn btn-danger removeRow"><i
                                                                    class='fa fa-trash'></i></button> --}}
                                                        </td>
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
                                                {{-- @if ($departments->lastPage() > 1) --}}
                                                <p class="text-center text-muted float-left">
                                                    Showing {{ $departments->firstItem() }} to {{ $departments->lastItem() }} of
                                                    {{ $departments->total() }} entries
                                                </p>
                                                {{-- @endif --}}
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-7">
                                            <div class="dataTables_paginate paging_simple_numbers">
                                                {{ $departments->appends(request()->query())->links('pagination::bootstrap-4') }}
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
