<div class="row">
    @foreach ($priceAll as $key => $item)
        <div class="col-md-4">
            <div class="form-group">
                <div class="custom-control custom-radio">
                    <input class="custom-control-input" type="radio" value="{{$item['MA_DV_CHINH']}}" id="customRadio{{$key}}" name="vtp_service" @if($service == $item['MA_DV_CHINH']) checked @endif>
                    <label for="customRadio{{$key}}" class="custom-control-label">{{$item['TEN_DICHVU']}}</label>
                </div>
                <div class="mt-2">Giá cước : {{number_format($item['GIA_CUOC'], 0, '', '.')}} đ</div>
            </div>
        </div>
    @endforeach
</div>