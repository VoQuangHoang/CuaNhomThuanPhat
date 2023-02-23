@extends('frontend.layouts.master')
@section('content')
<main class="site-main news-detail">
    <div class="container">
        <div class="page-breadcrumb">
            <a href="{{ route('home.index') }}">Trang chủ</a>
            <span class="divide">/</span>
            <a href="{{ route('home.blogs') }}">Tin tức</a>
            <span class="divide">/</span>
            <span class="last">{{$blog->title}} </span>
        </div>

        <div class="entry-heading">
            <h1>{{$blog->title}}</h1>
            <div class="date">Ngày đăng: {{date_format($blog->created_at, 'd/m/Y')}}</div>
        </div>

        <div class="entry-content">
            {!! $blog->content !!}
        </div>

        {{-- <div class="comment-box">
            <div class="comment-box-head">
                <div class="total-comment">
                    <strong>300</strong> bình luận
                </div>
                <div class="sort-comment">
                    <select name="" id="" class="form-select rounded-0">
                        <option value="">Mới nhất</option>
                        <option value="">Cũ nhất</option>
                    </select>
                </div>
            </div>
            <div class="comment-box-main">
                <form action="" method="post" class="comment-form d-flex">
                    <textarea rows="3" placeholder="Nhập bình luận" class="form-control rounded-0"></textarea>
                    <input type="submit" value="GỬI" class="btn btn-submit btn-send-comment">
                </form>
                <div class="comment-listing">
                    <div class="comment-item">
                        <div class="comment parent">
                            <div class="avatar">
                                <img src="assets/images/feedback3.jpg" alt="avatar">
                            </div>
                            <div class="content">
                                <div class="name">Nguyễn Trung Quân</div>
                                <div class="text">
                                    Quisque varius diam vel metus mattis, id aliquam diam rhoncus. Proin vitae
                                    magna in dui finibus malesuada et at nulla. Morbi elit ex, viverra vitae
                                    ante vel, blandit feugiat ligula.
                                </div>
                                <div class="metadata">
                                    <div class="date">22/08/2022</div>
                                    <div class="like">
                                        <a href="#">
                                            <i class="fas fa-thumbs-up"></i> Thích
                                        </a>
                                    </div>
                                    <div class="reply">
                                        <a href="#">
                                            <i class="fas fa-comment-alt-dots"></i> Phản hồi
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="comment-item">
                        <div class="comment parent">
                            <div class="avatar">
                                <img src="assets/images/feedback3.jpg" alt="avatar">
                            </div>
                            <div class="content">
                                <div class="name">Nguyễn Trung Quân</div>
                                <div class="text">
                                    Quisque varius diam vel metus mattis, id aliquam diam rhoncus. Proin vitae
                                    magna in dui finibus malesuada et at nulla. Morbi elit ex, viverra vitae
                                    ante vel, blandit feugiat ligula.
                                </div>
                                <div class="metadata">
                                    <div class="date">22/08/2022</div>
                                    <div class="like active">
                                        <a href="#">
                                            <i class="fas fa-thumbs-up"></i> Thích (2)
                                        </a>
                                    </div>
                                    <div class="reply active">
                                        <a href="#">
                                            <i class="fas fa-comment-alt-dots"></i> Phản hồi (1)
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="comment child">
                            <div class="avatar">
                                <img src="assets/images/feedback-logo.jpg" alt="avatar">
                            </div>
                            <div class="content">
                                <div class="name">Dotiva <i class="fas fa-check-circle"></i></div>
                                <div class="text">
                                    Quisque varius diam vel metus mattis, id aliquam diam rhoncus.
                                </div>
                                <div class="metadata">
                                    <div class="date">22/08/2022</div>
                                    <div class="like active">
                                        <a href="#">
                                            <i class="fas fa-thumbs-up"></i> Thích (2)
                                        </a>
                                    </div>
                                    <div class="reply active">
                                        <a href="#">
                                            <i class="fas fa-comment-alt-dots"></i> Phản hồi (1)
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="comment-item">
                        <div class="comment parent">
                            <div class="avatar">
                                <img src="assets/images/feedback3.jpg" alt="avatar">
                            </div>
                            <div class="content">
                                <div class="name">Nguyễn Trung Quân</div>
                                <div class="text">
                                    Quisque varius diam vel metus mattis, id aliquam diam rhoncus. Proin vitae
                                    magna in dui finibus malesuada et at nulla. Morbi elit ex, viverra vitae
                                    ante vel, blandit feugiat ligula.
                                </div>
                                <div class="metadata">
                                    <div class="date">22/08/2022</div>
                                    <div class="like">
                                        <a href="#">
                                            <i class="fas fa-thumbs-up"></i> Thích
                                        </a>
                                    </div>
                                    <div class="reply">
                                        <a href="#">
                                            <i class="fas fa-comment-alt-dots"></i> Phản hồi
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="load-comment text-center">
                        <a href="javascript:void(0);">Hiển thị bình luận cũ hơn</a>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
</main>
@endsection