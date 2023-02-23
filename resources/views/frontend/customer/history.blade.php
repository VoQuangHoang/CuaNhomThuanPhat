@extends('frontend.layouts.master')
@section('content')
<main class="main account">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Trang Chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tài khoản</li>
            </ol>
        </nav>

        <div class="row">

            @include('frontend.customer.sidebar')
            
            <div class="col-lg-8">
                <section class="account-section account-info">
                    <h3>Thông tin tài khoản</h3>
                    <ul class="info-box list-unstyled mb-0">
                        <li>
                            <span>Thông tin tài khoản</span>
                            <strong>Le Anh</strong>
                        </li>

                        <li>
                            <span>Email</span>
                            <strong>leanhdh.designer@gmail.com</strong>
                        </li>
                    </ul>
                    <div class="action">
                        <a href="#">Chỉnh Sửa</a>
                    </div>
                </section>

                <section class="account-section account-order">
                    <h3>Các đơn vừa đặt</h3>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width:110px">Mã đơn hàng</th>
                                    <th style="width:100px">Ngày mua</th>
                                    <th>Sản phẩm</th>
                                    <th style="width:100px">Tổng tiền</th>
                                    <th style="width:100px">Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>0002154</td>
                                    <td>2-8-2022</td>
                                    <td>
                                        Kem đánh răng ORAJEL Training Toothpaste nuốt được cho trẻ em 42.5g từ
                                        Mỹ
                                    </td>
                                    <td>1.182.000 đ</td>
                                    <td>
                                        <span style="color:#FFA800">Đang gửi</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>0002355</td>
                                    <td>2-8-2022</td>
                                    <td>
                                        Kẹo dẻo Nature Made Kids First Bổ Sung Vitamin C Tốt Cho Hệ Miễn Dịch
                                        (180
                                        Viên)
                                    </td>
                                    <td>1.182.000 đ</td>
                                    <td>
                                        <span style="color:#3AAD61">Đã nhận</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>

                <section class="account-section account-address">
                    <h3>Sổ địa chỉ</h3>

                    <div class="action">
                        <a href="#">Thêm Địa Chỉ Mới</a>
                    </div>

                    <div class="address-list">

                        <div class="address-item">
                            <div class="title">Nguyễn Văn A - 0398781965</div>
                            <div class="detail">
                                255 - 257 Hùng Vương, phường vĩnh trung, quận thanh khê, TP Đà Nẵng
                            </div>
                            <div class="default">
                                Địa chỉ mặc định
                            </div>
                        </div>

                        <div class="address-item">
                            <div class="title">Nguyễn Văn A - 0398781965</div>
                            <div class="detail">
                                255 - 257 Hùng Vương, phường vĩnh trung, quận thanh khê, TP Đà Nẵng
                            </div>
                            <div class="action">
                                <a href="javascript:void(0);"></a>
                                <div class="action-box">
                                    <a href="#">Đặt làm mặc định</a>
                                    <a href="#">Chỉnh sửa</a>
                                    <a href="#">Xoá</a>
                                </div>
                            </div>
                        </div>

                        <div class="address-item">
                            <div class="title">Ngô Thanh Tùng - 0905365245</div>
                            <div class="detail">
                                255 - 257 Hùng Vương, phường vĩnh trung, quận thanh khê, TP Đà Nẵng
                            </div>
                            <div class="action">
                                <a href="javascript:void(0);"></a>
                                <div class="action-box">
                                    <a href="#">Đặt làm mặc định</a>
                                    <a href="#">Chỉnh sửa</a>
                                    <a href="#">Xoá</a>
                                </div>
                            </div>
                        </div>

                    </div>
                </section>
            </div>
        </div>

    </div>
</main>
@stop
