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
                                <h3>{{ $doctor->name }}</h3>
                            </div>


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
                                            <!-- chart -->
                                            <canvas id="AreaChart" height="110"></canvas>
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
                if ($(`#AreaChart`).length) {
                    var ctx = document.getElementById(`AreaChart`).getContext('2d');

                    var gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
                    gradientStroke1.addColorStop(0, '#4facfe');
                    gradientStroke1.addColorStop(1, '#00f2fe');

                    var myChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov',
                                'Dec'
                            ],
                            datasets: [{
                                label: 'Revenue',
                                data: [10, 8, 6, 5, 12, 8, 16, 17, 6, 7, 6, 10, 0],
                                backgroundColor: 'rgba(94, 114, 228, 0.3)',
                                borderColor: '#5e72e4',
                                borderWidth: 3
                            }]
                        }
                    });
                }
            </script>

        </x-slot>
    </x-slot>
</x-layout>