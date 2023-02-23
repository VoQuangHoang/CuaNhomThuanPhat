@if(!empty($childs))
   @foreach($childs as $child)
   <li class="menu-item">
      <a href="{{ route('home.cate_product',$child->slug) }}">{{ $child->name }}</a>
         @if(!empty($child->childs) && count($child->childs)>0)
         <ul class="sub2menu list-unstyled mb-0">
            @include('frontend.ajax.submenu',['childs' => $child->childs])
         </ul>
         @endif
  </li>
   @endforeach

@endif