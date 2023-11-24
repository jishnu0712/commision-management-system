<a class="box box-link-shadow text-center col-md-6 box-inverse box-{{ $color }}  {{ $margin }}" style="float:left;"
    href="{{ $url }}">
    <div class="box-body">
        <div class="font-size-24">
            {{ !$isAmount ? '' : $settings->currency }}{{ !$isAmount ? $amount ? $amount : 0 : CustomHelper::currencyFormat($amount) }}
        </div>
        <span>{{ $title }}</span>
    </div>

</a>
