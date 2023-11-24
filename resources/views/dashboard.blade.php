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
                                <h3>Commition Information</h3>
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
                                {{-- <h3>Commition Chart </h3> --}}
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
                        </div>
                    </div>
                </section>
                <!-- /.content -->
            </div>
        </div>
        <x-slot name="javascript">
            {{-- <script>
                const ctx = document.getElementById('myChart');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: {!! $chartMonths !!},
                        datasets: [{
                            label: 'Total - ',
                            data: {!! $chartTotalAmount !!},
                            borderWidth: 2
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            </script> --}}

        </x-slot>
    </x-slot>
</x-layout>
