<x-layout>
    <x-slot name="title">Departments</x-slot>
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
                            <h3 style="float:left;">Departments</h3>
                            <div class="col-md-8">
                                <a href="{{ route('department.download') }}" class="btn btn-primary printButton float-right" target="_blank"><i class="fa fa-print"></i>Print All Departments</a>
                            </div>
                        </div>

                        <div class="col-12">
                            {{-- error --}}
                            <div class="box">
                                <div class="box-body">
                                    <div class="table-responsive-ipad overflow-auto">
                                        <table id="departments-table" class="table table-striped table-hover">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Department</th>
                                                    <th>Description</th>
                                                    <th>Date Time</th>
                                                    @if (in_array('department_edit', $userPermission))
                                                    <th>Action</th>
                                                    @endif
                                                </tr>
                                            </thead>
                                            <tbody id="sortable_art">
                                                @foreach ($departments as $key => $department)
                                                <tr>
                                                    <td data-title="Sl No">
                                                        <a href="javascript:;">
                                                            <button type="button" class="waves-effect waves-light btn btn-primary">{{ $key + 1 }}</button>
                                                        </a>
                                                    </td>
                                                    <td data-title="name">{{ $department->dept_name }}</td>
                                                    <td data-title="description">
                                                        {{ $department->description }}
                                                    </td>
                                                    <td data-title="Date Time">
                                                        {{ CustomHelper::dateFormat('d/m/Y h:i a', $department->created_at) }}
                                                    </td>
                                                    <td data-title="Action">
                                                        @if (in_array('department_edit', $userPermission))
                                                        <a href="{{ route('department.edit', ['department_id' => encrypt($department->id)]) }}" class="btn btn-primary"><i class='fa fa-edit'></i></a>
                                                        @endif
                                                        @if (in_array('department_delete', $userPermission))
                                                        <button data-rowId="{{ encrypt($department->id) }}" class="btn btn-danger removeRow"><i class='fa fa-trash'></i></button>
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
                $('#departments-table').DataTable({
                    "pageLength": 50, // Number of entries to show per page
                    "searching": true, // Enable searching
                    // Add more options as needed
                });

                softnicRms.deptListPage.init();
            });
        </script>
    </x-slot>
</x-layout>