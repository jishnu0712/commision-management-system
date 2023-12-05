<x-layout>
    <x-slot name="title">Transaction of {{ $doctor->name }}</x-slot>
    <x-slot name="content">
        <div class="content-wrapper">
            <div class="container-full">
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xl-12 col-12">
                            <!-- INVOICE INFORMATION -->

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
                                    <div class="box">
                                        <div class="box-body">
                                            <table class="table table-stripted">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th>Month</th>
                                                        <th>Rvenue</th>
                                                        <th>Commission</th>
                                                        <th class="text-center">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($transactions as $transaction)
                                                        @php
                                                            $isPaid = in_array(date('m', strtotime($transaction->month_year)), $payments);
                                                        @endphp
                                                        <tr class="text-center">
                                                            <td>{{ $transaction->month }}</td>
                                                            <td><i class="fa fa-rupee"></i>
                                                                {{ $transaction->total_amount }}</td>
                                                            <td><i class="fa fa-rupee"></i>
                                                                {{ $transaction->commission }}</td>
                                                            {{-- <td><span class="label label-success">Paid</span></td> --}}
                                                            <td>
                                                                @if ($isPaid)
                                                                    <span class="label label-success">Paid</span>
                                                                @else
                                                                    <button doctor_id="{{ $doctor->id }}"
                                                                        month_year="{{ $transaction->month_year }}"
                                                                        class="btn btn-primary btn-sm markAsPaid">Mark
                                                                        as
                                                                        Paid</button>
                                                                @endif
                                                            </td>

                                                        </tr>
                                                    @endforeach
                                                    <tr class="text-center">
                                                        <th>Total</th>
                                                        <th><i class="fa fa-rupee"></i>
                                                            {{ array_sum(json_decode($totalAmount)) }}</th>
                                                        <th><i class="fa fa-rupee"></i>
                                                            {{ array_sum(json_decode($commissions)) }}</th>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-12 col-lg-12 col-12 pl-5">
                                <h3>Commission Chart </h3>
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

                            <div class="col-xl-12 col-lg-12 col-12 pl-5">
                                <h3>Revenue & Commission (Monthly)</h3>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    {{-- error --}}
                                    <div class="box">
                                        <div class="box-body">
                                            <!-- chart -->
                                            <canvas id="barChart" height="110"></canvas>
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
                                label: 'Commission',
                                data: {!! $commissions !!},
                                backgroundColor: 'rgba(94, 114, 228, 0.3)',
                                borderColor: '#5e72e4',
                                borderWidth: 3
                            }]
                        }
                    });
                }
                // BAR CHART
                if ($('#barChart').length) {
                    var ctx = document.getElementById("barChart").getContext('2d');
                    var myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: {!! $months !!},
                            datasets: [{
                                label: 'Revenue',
                                data: {!! $totalAmount !!},
                                backgroundColor: "#ff2fa0"
                            }, {
                                label: 'Commission',
                                data: {!! $commissions !!},
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


                // DOCTOR PAYMENT
                $(".markAsPaid").on('click', function(e) {
                    var $this = $(this);
                    var doctor_id = $this.attr('doctor_id');
                    var month_year = $this.attr('month_year');

                    swal({
                        title: "Are you sure?",
                        text: "You will not be able to recover.",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3da643",
                        confirmButtonText: "Yes, Pay!",
                        closeOnConfirm: true,
                    }, function() {
                        $.post("{{ route('doctor.payment') }}", {
                            doctor_id,
                            month_year
                        }, function(data, status) {
                            if (data.status == 'success') {
                                $this.hide();
                                $this.parent().html('<span class="label label-success">Paid</span>');
                                swal("Success", data.msg, "success");
                            } else {
                                swal("Error", data.msg, "error");
                            }
                        });
                    });

                });
            </script>

        </x-slot>
    </x-slot>
</x-layout>
