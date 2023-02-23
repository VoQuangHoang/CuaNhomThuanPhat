<option value="" selected disabled>Chọn Phường/Xã</option>
@if (isset($wards['message']) && $wards['message'] == 'OK')
    @foreach($wards['data'] as $item)
        <option value="{{$item['WARDS_ID']}}" class="text-capitalize">{{\Str::lower($item['WARDS_NAME'])}}</option>
    @endforeach
@endif