<div class="col-lg-3 col-12">
    <div class="box">
        <div class="box-body py-0">
            <div class="d-flex justify-content-between align-items-center p-20">
                <div>
                    <h5 class="text-fade">{{ $title }}</h5>
                    <h2 class="font-weight-500 mb-0" style="font-size: 22px;">
                        @if ($isAmount)
                            {{ $settings->currency ?? '₹' }}{{ CustomHelper::currencyFormat($amount ?? 0) }}
                        @else
                            {{ $amount ?? 0 }}
                        @endif

                    </h2>
                </div>
            </div>
        </div>
    </div>
</div>
