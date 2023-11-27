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
                                <h3>Commission Chart </h3>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    {{-- error --}}
                                    <div class="box">
                                        <div class="box-body">
                                            <table class="table table-stripted">
                                                <thead>
                                                    <tr>
                                                        <th>Doctor</th>
                                                        <th>Hospital</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>{{ $doctor->name }}</td>
                                                        <td>{{ $doctor->hospital_name }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                            labels: {!! $months !!},
                            datasets: [{
                                label: 'Revenue',
                                data: {!! $commissions !!},
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