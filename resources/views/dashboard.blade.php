<x-layout>
    <x-slot name="title">Dashboard</x-slot>
    <x-slot name="content">
        <div class="content-wrapper">
            <div class="container-full">
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xl-12 col-12">
                            <!-- INVOICE INFORMATION -->
                            <div class="col-xl-12 col-lg-12 col-12 pl-5">
                                <h3>Commission Information</h3>
                            </div>
                            <div class="row">

                                <x-admin-dashboard-order-card title="Total" :count="$orders->total_orders"
                                    icon="fa fa-truck text-success" link="" />

                                <x-admin-dashboard-order-card title="This Year" :count="$orders->completed_orders ? $orders->completed_orders : 0"
                                    icon="fa fa-check-circle text-warning" link="" />

                                <x-admin-dashboard-order-card title="This Month" :count="$orders->cancelled_orders ? $orders->cancelled_orders : 0"
                                    icon="fa fa-window-close text-danger" link="" />

                                <x-admin-dashboard-order-card title="This Week" :count="$orders->placed_orders ? $orders->placed_orders : 0"
                                    icon="fa fa-clock-o text-primary" link="" />

                            </div>
                            <!-- ./ ORDER INFORMATION ./ -->
                            <!-- INVOICE INFORMATION -->
                            <div class="col-xl-12 col-lg-12 col-12 pl-5">
                                {{-- <h3>Commission Chart </h3> --}}
                            </div>
                            {{-- <div class="row">
                                <x-admin-dashboard-o-invoice-card title="Total Invoice" :amount="$orders->completed_orders"
                                    :isAmount=false />
                                <x-admin-dashboard-o-invoice-card title="Total Sales" :amount="isset($sales[3]) ? $sales[3] : 0"
                                    :isAmount=true />
                                <x-admin-dashboard-o-invoice-card title="Inside Sales" :amount="isset($sales[2]) ? $sales[2] : 0"
                                    :isAmount=true />
                                <x-admin-dashboard-o-invoice-card title="3rd Party Sales" :amount="isset($sales[1]) ? $sales[1] : 0"
                                    :isAmount=true />

                            </div> --}}
                            <!-- ./ INVOICE INFORMATION ./ -->
                            {{-- <div class="row">
                                <div class="col-md-12">
                                    <div class="box">
                                        <div class="box-body py-0">
                                            <div class="d-flex justify-content-between align-items-center p-20">
                                                <canvas style="width: 100% !important;" id="myChart"></canvas>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div> --}}
                            <div class="row">
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
                                                            <th>Hospital Name</th>
                                                            <th class="text-center">Chart</th>
                                                            {{-- <th>Action</th> --}}
                                                        </tr>
                                                    </thead>
                                                    <tbody id="sortable_art">
                                                        @foreach ($doctors as $key => $doctor)
                                                            <tr>
                                                                <td data-title="Sl No">
                                                                    <a
                                                                        href="{{ route('transaction.view', ['doctor_id' => encrypt($doctor->id)]) }}">
                                                                        <button type="button"
                                                                            class="waves-effect waves-light btn btn-primary">{{ ($doctors->currentPage() - 1) * $doctors->perPage() + $loop->iteration }}</button>
                                                                    </a>
                                                                </td>
                                                                <td data-title="img">
                                                                    <img width="80" alt="Profile pic"
                                                                        src="{{ asset('storage/doctors/profile_pic/' . $doctor->profile_pic) }}">
                                                                </td>
                                                                <td data-title="name">{{ $doctor->name }}</td>

                                                                <td data-title="hospital_name">
                                                                    {{ $doctor->hospital_name }}
                                                                </td>
                                                                <td data-title="chart">
                                                                    <canvas id="AreaChart{{ $doctor->id }}"
                                                                        height="110"></canvas>
                                                                </td>

                                                                {{-- <td data-title="Action">
                                                                    <a href="{{ route('doctor.edit', ['doctor_id' => encrypt($doctor->id)]) }}"
                                                                        class="btn btn-primary"><i
                                                                            class='fa fa-edit'></i></a>
                                                                </td> --}}
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
                                                        {{-- @if ($doctors->lastPage() > 1) --}}
                                                        <p class="text-center text-muted float-left">
                                                            Showing {{ $doctors->firstItem() }} to
                                                            {{ $doctors->lastItem() }} of
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
                        </div>
                    </div>
                </section>
                <!-- /.content -->
            </div>
        </div>
        <x-slot name="javascript">
            <script>
                const getMultiChart = (doctor_id, months, commissions) => {
                    if ($(`#AreaChart${doctor_id}`).length) {
                        var ctx = document.getElementById(`AreaChart${doctor_id}`).getContext('2d');

                        var gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
                        gradientStroke1.addColorStop(0, '#4facfe');
                        gradientStroke1.addColorStop(1, '#00f2fe');

                        var myChart = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: months,
                                datasets: [{
                                    label: 'Revenue',
                                    data: commissions,
                                    backgroundColor: 'rgba(94, 114, 228, 0.3)',
                                    borderColor: '#5e72e4',
                                    borderWidth: 3
                                }]
                            }
                        });
                    }
                }
            </script>
            @foreach ($doctors as $doctor)
                <script>
                    getMultiChart('{{ $doctor->id }}', JSON.parse('{!! $monthsArr[$doctor->id] !!}'), JSON.parse('{!! $commissionsArr[$doctor->id] !!}'));
                </script>
            @endforeach

        </x-slot>
    </x-slot>
</x-layout>
