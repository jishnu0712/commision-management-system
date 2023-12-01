<x-layout>
    <x-slot name="title">Transaction</x-slot>
    <x-slot name="content">
        <div class="content-wrapper">
            <div class="container-full">
                <!-- Main content -->
                <section class="content">
                    @include('alert.alert')
                    <form method="post" id="addItemForm" action="{{ route('transaction.store') }}"
                        enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-xl-12 col-12">
                                <div class="box">
                                    <div class="box-header with-border">
                                        <h4 class="box-title">Transaction</h4>
                                    </div>
                                    <div class="box-body">
                                        <div class="box-body item_repeter_container">
                                            @csrf

                                            <div class="row col-md-12">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label class="control-label">Select Doctor<span
                                                                class="input_required">*</span></label>
                                                        <select name="doctor_id" class="select2" required
                                                            id="doctorDropdown">
                                                            <option value="">Select Doctor</option>
                                                            @foreach ($doctors as $doctor)
                                                                <option value="{{ $doctor->id }}">{{ $doctor->name }}
                                                                    -
                                                                    ({{ $doctor->address }})
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Patient Name</label>
                                                        <input type="text" name="patient_name" class="form-control"
                                                            required placeholder="Patient Name">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Bill No</label>
                                                        <input type="text" name="bill_no" class="form-control"
                                                            required placeholder="Bill No">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Bill Date</label>
                                                        <input type="date" name="bill_date" class="form-control"
                                                            required placeholder="Bill Date">
                                                    </div>
                                                </div>

                                            </div>
                                            <hr />

                                            <div class="row col-md-12 item_repeter_content">
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label>Select Department</label>
                                                        <select class="form-control select2 departmentDropdown"
                                                            name="department[]" style="width: 100%;" required>
                                                            <option value="">Select Department</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label>Amount</label>
                                                        <input type="number" name="amount[]" class="form-control"
                                                            placeholder="Amount" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label class="row action_name">Add</label>
                                                        <button type="button" id="addProToTbL"
                                                            class="btn btn-primary row col-md-12"><i
                                                                class="fa fa-plus"></i></button>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <button class="btn btn-rounded btn-primary" type="submit">Add</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </section>
                <!-- /.content -->
            </div>
        </div>
    </x-slot>
    <x-slot name="javascript">
        <script>
            $('.select2').select2();
            $(document).ready(() => {
                $("#doctorDropdown").on('change', () => {
                    let $this = $(this);
                    let doctor_id = $("#doctorDropdown option:selected").val();
                    $.get("{{ route('transaction.department') }}", {
                        doctor_id
                    }, (data, status) => {
                        $('.departmentDropdown').html(data);
                        $('.select2').select2();
                    });
                });
            });

            $(document).on('click', '#addProToTbL', function(e) {
                var $item_element = $(document).find('.item_repeter_content').first().clone();
                $('.item_repeter_container').append($item_element);
                $item_element.find('.select2-container').remove();
                $item_element.find('input').val('');
                $item_element.find('button').removeAttr('id').addClass('remove_repeter_item');
                $item_element.find('button i').removeClass('fa-plus').addClass('fa-minus');
                $item_element.find('button').removeClass('btn-primary').addClass('btn-danger');
                $item_element.find('.action_name').text('Remove');
                $('.select2').select2();
            });
            $(document).on('click', '.remove_repeter_item', function(e) {
                $(this).parent().parent().parent().remove();
            });
        </script>
    </x-slot>
</x-layout>
