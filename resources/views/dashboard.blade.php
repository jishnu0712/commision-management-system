<x-layout>
    <x-slot name="title">Dashboard</x-slot>
    <x-slot name="content">
        <div class="content-wrapper">
            <div class="container-full">
                <!-- Main content -->
                <section class="content">
                    @if (in_array('dashboard_view', json_decode(auth()->user()->permissions)))
                    @include('include.dashboard.adminview')
                    @else
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box">
                                <div class="box-body">
                                    <h2 class="text-center">Welcome - {{ auth()->user()->name }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

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
                                    label: 'Commission',
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

            {{-- BAR CHART --}}
            <script>
                if ($('#barChart').length) {
                    var ctx = document.getElementById("barChart").getContext('2d');
                    var myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: {!! $BarChartMonths !!},
                            datasets: [{
                                label: 'Revenue',
                                data: {!! $BarChartTotal !!},
                                backgroundColor: "#ff2fa0"
                            }, {
                                label: 'Commission',
                                data: {!! $BarChartCommissions !!},
                                backgroundColor: "#5e72e4"
                            }]
                        },
                        options: {
                            scales: {
                                xAxes: [{
                                    barPercentage: .7
                                }]
                            }
                        }
                    });
                }
            </script>


            // <script>
            //     $(document).ready(function() {
            //         $("#searchForm").on('submit', function(e) {
            //             e.preventDefault();

            //             let $this = $(this);
            //             let searchText = $this.find('input').val();
            //         });
            //     });
            // </script>

        </x-slot>
    </x-slot>
</x-layout>