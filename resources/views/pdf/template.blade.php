<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>


    <div class="content-wrapper">
        <div class="container-full">
            <!-- Main content -->
            <section class="content">

                <div class="row">
                    <div class="col-xl-12 col-12">
                        <div class="box">
                            <div class="box-header with-border">

                            </div>
                            <div class="box-body">
                                <div class="box-body">
                                    @php
                                    $totalTransactionCount = 0;
                                    @endphp

                                    @foreach ($invoices as $invoice)
                                    @foreach ($invoice->bill as $bill)
                                    @php
                                    $totalTransactionCount += count($bill->transaction);
                                    @endphp
                                    @endforeach
                                    @endforeach

                                    @foreach ($invoices as $invoice)
                                    @php
                                    if (count($invoice->bill) < 1) { continue; } @endphp <table class="table table-stripped">
                                        <thead>
                                            <tr class="text-center">
                                                <th colspan="5">For the month of {{ $newMonth }}
                                                    {{ $year }} (DHULIAN NURSING HOME)
                                                </th>
                                            </tr>
                                            <tr class="text-center">
                                                <th>Doctor Name</th>
                                                <th>Patient Name</th>
                                                <th>Date</th>
                                                <th>Department</th>
                                                <th>Commission</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                            $commissionSum = 0;
                                            @endphp
                                            {{-- Display Doctor Name only once per invoice --}}
                                            <tr class="text-center">
                                                <td rowspan="{{ $totalTransactionCount }}">{{ $invoice->name }}
                                                </td>
                                            </tr>

                                            @foreach ($invoice->bill as $index => $bill)
                                            @foreach ($bill->transaction as $tranIndex => $tran)
                                            <tr class="text-center">
                                                <td>{{ $bill->patient_name }}</td>
                                                <td>{{ CustomHelper::dateFormat('F-Y', $bill->bill_date) }}
                                                </td>
                                                <td>{{ $tran->department->dept_name }}</td>
                                                <td>Rs. {{ $tran->commission }}</td>
                                            </tr>
                                            @php
                                            $commissionSum += $tran->commission;
                                            @endphp
                                            @endforeach
                                            @endforeach
                                            <tr class="text-center">
                                                <th colspan="2"></th>
                                                <th>GRAND TOTAL</th>
                                                <th>Rs. {{ $commissionSum }}</th>
                                            </tr>
                                        </tbody>
                                        </table>
                                        <br><br>
                                        @endforeach

                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </section>
            <!-- /.content -->
        </div>
    </div>

</body>

</html>