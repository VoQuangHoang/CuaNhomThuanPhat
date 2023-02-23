<option value="" selected disabled>Chọn Quận/Huyện</option>
@if (isset($district['message']) && $district['message'] == 'OK')
    {{-- {{dd($district['data'])}} --}}
    @foreach($district['data'] as $item)
        <option value="{{$item['DISTRICT_ID']}}" class="text-capitalize">{{(\Str::lower($item['DISTRICT_NAME']))}}</option>
    @endforeach
@endif