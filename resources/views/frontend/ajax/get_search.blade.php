@if (count($data)>0)
    <ul class="list-group" style="display: block; position: absolute; z-index: 1; width: 560px">
    @foreach ($data as $row)
        <li class="list-group-item">
            <div class="row">
                <div class="col-md-4 text-center">
                    <img src="{{$row->image}}" alt="{{$row->name}}" style="width:60px">
                </div>
                <div class="col-md-8">
                    <a class="text-dark" href="{{route('home.product_single', $row->slug)}}">{{$row->name}}</a>
                </div>
            </div>
        </li>
    
    @endforeach
    </ul>
@else
    <ul class="list-group" style="display: block; position: absolute; z-index: 1; width: 560px">
        <li class="list-group-item">Không có sản phẩm phù hợp</li>
    </ul>
@endif