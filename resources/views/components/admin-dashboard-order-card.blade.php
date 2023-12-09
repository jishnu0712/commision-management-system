<div class="col-lg-3 col-12">
   @if ($link)
      <a href="{{ $link }}">
   @endif
    <div class="box">
       <div class="box-body py-0">
          <div class="d-flex justify-content-between align-items-center p-20">
             <div>
                <h5 class="text-fade">{{ $title }}</h5>
                <h2 class="font-weight-500 mb-0">
                  {{ $count }}
                </h2>
             </div>
             <div>
                <i class="{{ $icon }}" style="font-size: 45px;"></i>
             </div>
          </div>
       </div>
    </div>
   @if ($link)
      </a>
   @endif
 </div>