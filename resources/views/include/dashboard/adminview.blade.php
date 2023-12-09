<div class="row">
    <div class="col-xl-12 col-12">
        <!-- INVOICE INFORMATION -->
        <div class="col-xl-12 col-lg-12 col-12 pl-5">
            <h3>Commission Information</h3>
        </div>
        <div class="row">

            <x-admin-dashboard-order-card title="Total Revenue" :count="$totals->total_amount" icon="" link="" />

            <x-admin-dashboard-order-card title="Total Commissions" :count="$totals->total_commission ? $totals->total_commission : 0" icon="" link="" />
            <!-- 
            <x-admin-dashboard-order-card title="This Month" :count="$orders->cancelled_orders ? $orders->cancelled_orders : 0" icon="" link="" />

            <x-admin-dashboard-order-card title="This Week" :count="$orders->placed_orders ? $orders->placed_orders : 0" icon="" link="" /> -->

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
                            <canvas style="width: 80% !important;" id="myChart"></canvas>
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
                            <form action="" method="get" id="searchForm">
                                <div class="col-sm-4 p-10">
                                    <input type="search" value="{{ request('text') }}" name="text" placeholder="Search" class="form-control" id="searchInput" />
                                </div>
                                <!-- <div class="col-sm-4 p-10">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div> -->
                            </form>
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
                                            <button type="button" class="waves-effect waves-light btn btn-primary">
                                                {{ ($doctors->currentPage() - 1) * $doctors->perPage() + $loop->iteration }}

                                            </button>
                                        </td>
                                        <td data-title="img">
                                            <img width="80" alt="Profile pic" class="avatar avatar-lg bg-primary-light rounded100" src="{{ asset('storage/doctors/profile_pic/' . (!empty($doctor->profile_pic) ? $doctor->profile_pic : 'profile_pic.png')) }}">

                                        </td>
                                        <td data-title="name">{{ $doctor->name }} ({{ $doctor->address }}) - ({{ $doctor->mobile }})</td>

                                        <td data-title="hospital_name">
                                            {{ $doctor->hospital_name }}
                                        </td>
                                        <td data-title="chart">
                                            <a href="{{ route('transaction.view', ['doctor_id' => encrypt($doctor->id)]) }}">
                                                <div>
                                                    <canvas id="AreaChart{{ $doctor->id }}" height="110"></canvas>
                                                </div>
                                            </a>
                                        </td>

                                        {{-- <td data-title="Action">
                                                <a href="{{ route('doctor.edit', ['doctor_id' => encrypt($doctor->id)]) }}"
                                        class="btn btn-primary"><i class='fa fa-edit'></i></a>
                                        </td> --}}
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        <!-- pagination -->
                        <div class="row mt-20">
                            <div class="col-sm-12 col-md-5 d-flex flex-column-reverse">
                                <div class="dataTables_info" id="example5_info" role="status" aria-live="polite">
                                    <p class="text-center text-muted float-left">
                                        Showing {{ $doctors->firstItem() }} to
                                        {{ $doctors->lastItem() }} of
                                        {{ $doctors->total() }} entries
                                    </p>
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

        <!-- ./ INVOICE INFORMATION ./ -->
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body py-0">
                        <div class="col-xl-12 col-lg-12 col-12 pl-5">
                            <h3>Revenue & Commission of - {{ date('Y') }}</h3>
                        </div>
                        <hr />
                        <div class="d-flex justify-content-between align-items-center p-10">
                            <canvas id="barChart" height="110"></canvas>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>