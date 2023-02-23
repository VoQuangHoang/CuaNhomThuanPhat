<!-- modal confim aff -->
<div class="modal fade" id="confirm_aff" tabindex="-1" role="dialog" aria-hidden="true">
    <form action="" id="form-confirm" method="POST">
        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
        <div class="modal-dialog modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thông báo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4>Bạn có muốn xác nhận đã xử lý yêu cầu và hoàn tất thanh toán?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-success">Xác nhận</button>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- end -->