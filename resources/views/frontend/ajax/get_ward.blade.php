<option value="" selected disabled>Chọn Phường Xã</option>
@foreach ($wardByDistrict as $item)
    <option value="{{$item->id}}">{{$item->name_with_type}}</option>
@endforeach
