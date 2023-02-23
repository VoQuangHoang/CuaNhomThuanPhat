<option value="" selected disabled>Chọn Quận Huyện</option>
@foreach ($districtByCity as $item)
    <option value="{{$item->id}}">{{$item->name}}</option>
@endforeach

