<x-layout>
    <x-slot name="title">Invoice</x-slot>
    <x-slot name="content">
        <style>
            #loader {
                display: none;
            }

            @media print {
                .card {
                    page-break-before: auto;
                    width: 100%;
                    page-break-inside: avoid;
                }

                .row {
                    page-break-before: always;
                }

                .card-header,
                .card-footer {
                    -webkit-print-color-adjust: exact;
                    background-color: #522e8c;
                }

                .printButton,
                .goBack {
                    display: none;
                }
            }
        </style>
        <div class="content-wrapper">
            <div class="container-full">
                <!-- Main content -->
                <section class="content">
                    @include('alert.alert')
                    <div class="row">
                        <div class="col-xl-12 col-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    {{-- <h4 class="box-title">Invoice</h4> --}}
                                    <div class="row">
                                        <div class="col-md-4">
                                            <input type="month" id="month" class="form-control"
                                                value="{{ date($year . '-' . $month) }}">
                                        </div>
                                        <div class="col-md-8">
                                            <button class="btn btn-primary printButton float-right"
                                                onclick="window.print()">
                                                <i class="fa fa-print"></i> Print
                                            </button>
                                        </div>
                                    </div>
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
                                            if(count($invoice->bill) < 1){
                                                continue;
                                            }
                                        @endphp
                                            <table class="table table-stripped">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th colspan="5">For the month of {{ $newMonth }}
                                                            {{ $year }} (DHULIAN NURSING HOME)</th>
                                                    </tr>
                                                    <tr class="text-center">
                                                        <th>Doctor Name</th>
                                                        <th>Patient Name</th>
                                                        <th>Date</th>
                                                        <th>Department</th>
                                                        <th>Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $commissionSum = 0;
                                                    @endphp
                                                    @foreach ($invoice->bill as $index => $bill)
                                                        @php
                                                            $transactionCount = count($bill->transaction);
                                                        @endphp
                                                        @foreach ($bill->transaction as $tranIndex => $tran)
                                                            <tr class="text-center">
                                                                @if ($index === 0 && $tranIndex === 0)
                                                                    <td rowspan="{{ $totalTransactionCount }}">
                                                                        {{ $invoice->name }}</td>
                                                                @endif
                                                                <td>{{ $bill->patient_name }}</td>
                                                                <td>{{ CustomHelper::dateFormat('F-Y', $bill->bill_date) }}
                                                                </td>
                                                                <td>{{ $tran->department->dept_name }}</td>
                                                                <td>₹ {{ $tran->commission }}</td>
                                                            </tr>
                                                            @php
                                                                $commissionSum += $tran->commission;
                                                            @endphp
                                                        @endforeach
                                                    @endforeach
                                                    <tr class="text-center">
                                                        <th colspan="2"></th>
                                                        <th>Grand Total</th>
                                                        <th>₹ {{ $commissionSum }}</th>
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
        <x-slot name="javascript">
            <script>
                $("#month").on('change', function(e) {
                    window.location.href = `?month=${$(this).val()}`;
                })
            </script>
        </x-slot>
    </x-slot>

</x-layout>
