@foreach ($productReviews as $review)
    <div class="comment-item">
        <div class="avatar">
            @if(!empty($review->User->image))
            <img src="{{url($review->User->image)}}" alt="avatar">
            @else
            <img src="{{url('backend/img/default.jpg')}}" alt="avatar">
            @endif
        </div>
        <div class="detail">
            <div class="rate">
                @if ($review->star <= 1)
                <div class="star star-1"></div>
            @elseif($review->star > 1 && $review->star <= 2)
                <div class="star star-2"></div>
            @elseif($review->star > 2 && $review->star <= 3)
                <div class="star star-3"></div>
            @elseif($review->star > 3 && $review->star <= 4)
                <div class="star star-4"></div>
            @elseif($review->star > 4)
                <div class="star star-5"></div>
            @endif
            </div>
            <div class="user">
                <strong>{{$review->name}}</strong>
                <span>{{date_format($review->created_at, 'd-m-Y')}}</span>
            </div>
            <div class="content">
                {{ $review->content }}
            </div>
        </div>
    </div>
@endforeach