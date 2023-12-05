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

                .table {
                    font-size: 12px !important;
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
                                            <input type="month" id="month" class="form-control" value="{{ date($year . '-' . $month) }}">
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
                                        if (count($invoice->bill) < 1) { continue; } @endphp <table class="table table-bordered">
                                            <thead>
                                                <tr class="text-center">
                                                    <th colspan="6">For the month of {{ $newMonth }}
                                                        {{ $year }} (DHULIAN NURSING HOME)
                                                    </th>
                                                </tr>
                                                <tr class="text-center">
                                                    <th>Doctor Name</th>
                                                    <th>Patient Name</th>
                                                    <th>Date</th>
                                                    <th>Department</th>
                                                    <th>Bill Amount</th>
                                                    <th>Commission</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $commissionSum = 0;
                                                $totalSum = 0;
                                                @endphp
                                                {{-- Display Doctor Name only once per invoice --}}
                                                <tr class="text-center">
                                                    <td rowspan="{{ $totalTransactionCount }}">
                                                        {{ $invoice->name }}
                                                        <br>
                                                        {{ $invoice->address }}
                                                        <br>
                                                        {{ $invoice->mobile }}
                                                    </td>
                                                </tr>

                                                @foreach ($invoice->bill as $index => $bill)
                                                @foreach ($bill->transaction as $tranIndex => $tran)
                                                <tr class="text-center">
                                                    <td>{{ $bill->patient_name }}</td>
                                                    <td>{{ CustomHelper::dateFormat('d-M-Y', $bill->bill_date) }}
                                                    </td>
                                                    <td>{{ $tran->department->dept_name }}</td>
                                                    <td><input class="form-control editableAmount" amountrow="{{ $tran->id }}" type="number" value="{{ $tran->amount }}" /></td>
                                                    <td>₹ {{ $tran->commission }}</td>
                                                </tr>
                                                @php
                                                $commissionSum += $tran->commission;
                                                $totalSum += $tran->amount;
                                                @endphp
                                                @endforeach
                                                @endforeach
                                                {{-- <tr class="text-center">
                                                        <th colspan="3"></th>
                                                        
                                                    </tr> --}}

                                                <tr class="text-center">
                                                    <th></th>
                                                    <th>TOTAL BILL</th>
                                                    <th>₹ {{ $totalSum }}</th>
                                                    <th>TOTAL COMMISSION</th>
                                                    <th>₹ {{ $commissionSum }}</th>
                                                </tr>
                                            </tbody>
                                            </table>
                                            <br><br>
                                            @endforeach
                                            <!-- pagination -->

                                            <!-- ./pagination./ -->
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
                });

                $(".editableAmount").on("blur", function(e){
                    let $this = $(this);
                    let value = $this.val();
                    let id = $this.attr('amountrow');
                    let data = {
                        id,
                        value
                    }
                    $.post("{{ route('transaction.update') }}", data, function(response, status){
                        swal(response.status, response.msg, response.status);
                        
                    });
                })
            </script>
        </x-slot>
    </x-slot>

</x-layout>