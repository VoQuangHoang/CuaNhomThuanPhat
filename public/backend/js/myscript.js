$(document).ready(function(){
    $(function () {
        $("#example1,#example2").DataTable({
            language:{
                "sProcessing":   "Đang xử lý...",
                "sLengthMenu":   "Xem _MENU_ mục",
                "sZeroRecords":  "Không tìm thấy dữ liệu nào phù hợp",
                "sInfo":         "Đang xem _START_ đến _END_ trong tổng số _TOTAL_ mục",
                "sInfoEmpty":    "Đang xem 0 đến 0 trong tổng số 0 mục",
                "sInfoFiltered": "(được lọc từ _MAX_ mục)",
                "sInfoPostFix":  "",
                "sSearch":       "Tìm:",
                "sUrl":          "",
                "oPaginate": {
                    "sFirst":    "Đầu",
                    "sPrevious": "Trước",
                    "sNext":     "Tiếp",
                    "sLast":     "Cuối"
                }
            },
            columnDefs: [
                { orderable: false, targets: 0 }
            ],

        });
    });
    $(function () {
        $("#example3").DataTable({
            language:{
                "sProcessing":   "Đang xử lý...",
                "sLengthMenu":   "Xem _MENU_ mục",
                "sZeroRecords":  "Không tìm thấy dữ liệu nào phù hợp",
                "sInfo":         "Đang xem _START_ đến _END_ trong tổng số _TOTAL_ mục",
                "sInfoEmpty":    "Đang xem 0 đến 0 trong tổng số 0 mục",
                "sInfoFiltered": "(được lọc từ _MAX_ mục)",
                "sInfoPostFix":  "",
                "sSearch":       "Tìm:",
                "sUrl":          "",
                "oPaginate": {
                    "sFirst":    "Đầu",
                    "sPrevious": "Trước",
                    "sNext":     "Tiếp",
                    "sLast":     "Cuối"
                }
            },
            columnDefs: [
                { orderable: false, targets: 0 }
            ],
            searching: false

        });
    });
    $('select[name="content[city_id]"]').on('change', function() {
        let id_city = $(this).val();
        const url = homeUrl()+'/quan-huyen/'+id_city;
        const name = $(this).find('option:selected').data('name');
        $.ajax({
            url: url,
            type:'GET',
            success: function(data) {
                $('select[name="content[district_id]"]').html(data);
            }
        });
    });
});

$(document).ready( function ( e ){
    $('input#name').keyup(function(event) {
        var title, slug;
    
        title = $(this).val();

        slug = title.toLowerCase();

        slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
        slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
        slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
        slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
        slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
        slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
        slug = slug.replace(/đ/gi, 'd');
        slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
        slug = slug.replace(/ /gi, "-");
        slug = slug.replace(/\-\-\-\-\-/gi, '-');
        slug = slug.replace(/\-\-\-\-/gi, '-');
        slug = slug.replace(/\-\-\-/gi, '-');
        slug = slug.replace(/\-\-/gi, '-');
        slug = '@' + slug + '@';
        slug = slug.replace(/\@\-|\-\@|\@/gi, '');

        slug = slug.replace(/\[|\]|\{|\}|\\/gi, '');
        
        $('input#slug').val(slug);
    });
});

// $(document).ready(function(){
//     $('a#select-img').click(function(event){
//         event.preventDefault();
//         $('#modal-media-imge').modal('show');
//         $('#modal-media-imge').on('hide.bs.modal',function(e){
//             var imgUrl = $('input#image').val();
//             $('img#show-img').attr('src',imgUrl);
//         });
//     });
// });
// $(document).ready(function(){
//     $('a#remove-img').click(function(event){
//         event.preventDefault();
//         $('input#image').val('');
//         $('img#show-img').attr('src','');
//     });
// });

$(document).ready(function(){
    $('a#del_img').on('click', function(){
        var url =  homeUrl() + "/backend/product/delimg/";
        var _token = $("form[name='frmEditProduct']").find("input[name='_token']").val();
        var idImg = $(this).parent().find("img").attr("idImg");
        var img = $(this).parent().find("img").attr("src");
        var rid = $(this).parent().find("img").attr("id");
        
        $.ajax({
            url: url + idImg,
            type: 'GET',
            cache: false,
            data: {"_token":_token,"idImg":idImg,"urlImg":img},
            success: function(data){
                if (data == 'OK') {
                    $('#'+rid).remove();
                }else{
                    alert('Error ! Please contact admin !');
                }
            }
        });
    });
});

$(document).ready(function(){
    $('a#del_gallery').on('click', function(){
        var url =  homeUrl() + "/backend/inf/delimg/";
        var _token = $("form[name='frmEditImg']").find("input[name='_token']").val();
        var idImg = $(this).parent().find("img").attr("idImg");
        var img = $(this).parent().find("img").attr("src");
        var rid = $(this).parent().find("img").attr("id");
        
        $.ajax({
            url: url + idImg,
            type: 'GET',
            cache: false,
            data: {"_token":_token,"idImg":idImg,"urlImg":img},
            success: function(data){
                if (data == 'OK') {
                    $('#'+rid).remove();
                }else{
                    alert('Error ! Please contact admin !');
                }
            }
        });
    });
});

$(document).on('ready', function() {
    $("#inpImg").fileinput({
         language: "vi",
        allowedFileTypes: ["image"],
        maxFileSize: 2000,
        showUpload: false
    });
});
$(document).on('ready', function() {
    $("#detailImg").fileinput({
        language: "vi",
        allowedFileTypes: ["image"],
        maxFileSize: 2000,
        showUpload: false
    });
});
$(document).on('ready', function() {
    for(i=1; i< 20; i++){
        $("#inpImg"+i).fileinput({
            language: "vi",
            allowedFileTypes: ["image"],
            maxFileSize: 2000,
            showUpload: false
        });
    }
});
$(document).on('ready', function() {
    $("#gallery").fileinput({
        allowedFileTypes: ["image"],
        maxFileSize: 2000
    });
});

$(document).ready(function(){
    $('#chkAll').change(function(event){
        var checkAll = $('#chkAll:checked').length > 0;

        if (checkAll) {
            $('input[name="chkItem[]"]').prop('checked', true);
        }else{
            $('input[name="chkItem[]"]').prop('checked', false);
        }
    });
});


$(document).ready(function(){
    var id = $('.liColor').attr('id');
    $("#iphiColor").val(id);

    $('.liColor').on('click', function(ev){
        ev.preventDefault();
        $('.liColor').removeClass('active');
        $(this).addClass('active');

        var id = $(this).attr('id');
        $("#iphiColor").val(id);
    });
});
$(document).on('ready', function() {
    $('#reservation').daterangepicker({
         autoUpdateInput: false,
         "locale": {
            "format": "MM-DD-YYYY",
            "applyLabel": "Áp dụng",
            "cancelLabel": "Hủy bỏ",
            "daysOfWeek": [
                "T2",
                "T3",
                "T4",
                "T5",
                "T6",
                "T7",
                "CN"
            ],
            "monthNames": [
                "Tháng 1 - ",
                "Tháng 2 - ",
                "Tháng 3 - ",
                "Tháng 4 - ",
                "Tháng 5 - ",
                "Tháng6 - ",
                "Tháng 7 - ",
                "Tháng 8 - ",
                "Tháng 9 - ",
                "Tháng 10 - ",
                "Tháng 11 - ",
                "Tháng 12 - "
            ]
        }
    });
    $('#reservation').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
    });

    $('#reservation').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });
});


$(function() {
    $('body').on('click', '.btn-destroy', function(event) {
        var action = $(this).attr('data-href');
        $('#form-destroy').attr('action', action);
    });
    $('body').on('click', '.btn-confirm', function(event) {
        var action = $(this).attr('data-href');
        $('#form-confirm').attr('action', action);
    });
    $('body').on('click', '.kv-error-close', function(event) {
        event.preventDefault();
    });
    $('#frm_product').on('submit', function() {
        price = parseInt($("input[name='price']").val());
        price_promotion = parseInt($("input[name='price_promotion']").val());
        if(price <= price_promotion ){
            alert('Giá khuyến mại phải nhỏ hơn giá bán !');
            return false;
        }
    });
    $('#form_post').on('submit', function() {
        img = $("input[name='image']").val();
        if(img == ''){
            alert('Bạn chưa chọn hình ảnh cho bài viết.');
            $(".image__thumbnail img").css({"border": "2px", "border-style": "solid", "border-color": "red"});
            return false;
        }
        var listArr = [];
        $("input[name='category[]']:checked").each(function() {
           listArr.push($(this).val());
        });
        if (listArr.length == 0) {
            $('.category-box').css({
                'border': '2px',
                'border-style': 'solid',
                'border-color' : 'red'
            });
            alert('Bạn chưa chọn danh mục bài viết.');
            var $container = $("html,body");
            var $scrollTo = $('.category-box');
            $container.animate({scrollTop: $scrollTo.offset().top - $container.offset().top + $container.scrollTop() - 200, scrollLeft: 0},300);
            return false;
        }
    });
    
});

$(function () {
    var ckeditor = $('textarea.content');
    if (ckeditor.length) {
        ckeditor.each(function () {
            var editor = CKEDITOR.replace($(this).attr('name'));
            CKFinder.setupCKEditor(editor);
        });
    }
    window.init = function() {
        var imgDefer = document.querySelectorAll('img.lazy');
        for (var i=0; i<imgDefer.length; i++) {
            var url = imgDefer[i].getAttribute('data-src');
            if(url) {
                imgDefer[i].setAttribute('src',url);
                imgDefer[i].setAttribute('srcset',url );
            }
        }
    }
    window.onload = init;
});
function fileSelect(el) {
    CKFinder.modal({
        chooseFiles: true,
        width: 1200,
        height: 600,
        language: 'vi',
        onInit: function (finder) {
            finder.on('files:choose', function (evt) {
                var parent = $(el).closest('.image');
                var img = parent.find('img').first();
                var input = parent.find('input').first();
                var file = evt.data.files.first();
                var url = file.getUrl();
                img.attr('src', url);
                input.val(url);
            });
            finder.on('file:choose:resizedImage', function (evt) {
                var parent = $(el).closest('.image');
                var img = parent.find('img').first();
                var input = parent.find('input').first();
                var url = evt.data.resizedUrl;
                img.attr('src', url);
                var result = url.substr(url);
                input.val(result);
            });
        }
    });
}
function urlFileDelete(el) {
    var parent = $(el).closest('.image');
    var img = parent.find('img').first();
    var input = parent.find('input').first();

    img.attr('src', img.data('init'));
    input.val('');
}
function fileMultiSelect(el) {
    CKFinder.modal({
        chooseFiles: true,
        width: 1000,
        height: 500,
        language: 'vi',
        onInit: function (finder) {
            finder.on('files:choose', function (evt) {
                var parent = $(el).closest('.image');
                var gallery = parent.find('.image__gallery');
                var files = evt.data.files;
                files.forEach(function (file) {
                    var url = file.getUrl();
                    var result = '<div class="image__thumbnail image__thumbnail--style-1">' +
                        '<img src="' + url + '" >' +
                        '<a href="javascript:void(0)" class="image__delete" onclick="urlFileMultiDelete(this)"><i class="fa fa-times"></i></a>' +
                        '<input type="hidden" name="gallery[]" value="' + url + '">' +
                        '</div>';
                    gallery.append(result)
                })
            });
            finder.on('file:choose:resizedImage', function (evt) {
                var parent = $(el).closest('.image');
                var gallery = parent.find('.image__gallery');
                var url = evt.data.resizedUrl;
                var result = '<div class="image__thumbnail image__thumbnail--style-1">' +
                    '<img src="' + url + '" >' +
                    '<a href="javascript:void(0)" class="image__delete" onclick="urlFileMultiDelete(this)"><i class="fa fa-times"></i></a>' +
                    '<input type="hidden" name="gallery[]" value="' + url    + '">' +
                    '</div>';
                gallery.append(result)
            });
        }
    });
}

function fileMultiSelectCustom(el, name = 'gallery' ) {
    CKFinder.modal({
        chooseFiles: true,
        width: 1000,
        height: 500,
        language: 'vi',
        onInit: function (finder) {
            finder.on('files:choose', function (evt) {
                var parent = $(el).closest('.image');
                var gallery = parent.find('.image__gallery');
                var files = evt.data.files;
                files.forEach(function (file) {
                    var url = file.getUrl();
                    var result = '<div class="image__thumbnail image__thumbnail--style-1">' +
                        '<img src="' + url + '" >' +
                        '<a href="javascript:void(0)" class="image__delete" onclick="urlFileMultiDelete(this)"><i class="fa fa-times"></i></a>' +
                        '<input type="hidden" name="'+name+'[]" value="' + url + '">' +
                        '</div>';
                    gallery.append(result)
                })
            });
            finder.on('file:choose:resizedImage', function (evt) {
                var parent = $(el).closest('.image');
                var gallery = parent.find('.image__gallery');
                var url = evt.data.resizedUrl;
                var result = '<div class="image__thumbnail image__thumbnail--style-1">' +
                    '<img src="' + url + '" >' +
                    '<a href="javascript:void(0)" class="image__delete" onclick="urlFileMultiDelete(this)"><i class="fa fa-times"></i></a>' +
                    '<input type="hidden" name="'+name+'[]" value="' + url    + '">' +
                    '</div>';
                gallery.append(result)
            });
        }
    });
}

function urlFileMultiDelete(el) {
    $(el).closest('.image__thumbnail').remove();
}
function repeater(event, el, url, indexClass, type, table = null) {

    event.preventDefault();
    var target = $(el).closest('.repeater').find('table tbody');
    if (table != null) {
        var indexs = $(table).find(indexClass);
    }else{
        var indexs = $(indexClass).closest('table').find(indexClass);
    }
    var index = indexs.length;
    $.get(url, {index: index + 1, type: type}, function (data) {
        target.append(data)
    });
}

jQuery(document).ready(function($) {
    $("#meta_title").keyup(function(){
        var countTitle =  this.value.length;
        $('#countTitle').text(countTitle+'/120');
        $(".google__title span").text(this.value);
    });
    $("#meta_description").keyup(function(){
        var countMeta = this.value.length;
        $('#countMeta').text(countMeta+'/360');
        $(".google__description").text(this.value);
    });
});
$(document).on('ready', function() {
    $('.multislt').select2({
        placeholder: "Chọn danh mục",
    });
});

var regExp = /[0-9\.\,]/;
$('.number').on('keydown keyup', function(e) {

    var value = String.fromCharCode(e.which) || e.key;
    // Only numbers, dots and commas
    if (!regExp.test(value)
        && e.which != 188 // ,
        && e.which != 190 // .
        && e.which != 8   // backspace
        && e.which != 46  // delete
        && (e.which < 37  // arrow keys
            || e.which > 40)) {
        e.preventDefault();
        return false;
    }
    if ( event.which >= 37 && event.which <= 40 ) return;
    this.value = this.value.replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, ',');
});// khong cho nhap chu vao text box

$('body').on('keydown keyup', '.number', function(e) {
    var value = String.fromCharCode(e.which) || e.key;
    // Only numbers, dots and commas
    if (!regExp.test(value)
        && e.which != 188 // ,
        && e.which != 190 // .
        && e.which != 8   // backspace
        && e.which != 46  // delete
        && (e.which < 37  // arrow keys
            || e.which > 40)) {
        e.preventDefault();
        return false;
    }
    if (event.which >= 37 && event.which <= 40) return;
    this.value = this.value.replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, ',');
});


jQuery(document).ready(function($) {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
    });
    
    $('#change_slug').click(function(event) {
        $('#change_slug').hide();
        $('#btn-ok').show();
        $('.cancel.button-link').show();
        changeInput();
    });

    $('.cancel.button-link').click(function(event) {
        $('#change_slug').show();
        $('#btn-ok').hide();
        $('.cancel.button-link').hide();
        cancelInput();
    });

    $('#btn_put_viettelpost').click(function() {
        var _this = $(this);
        var order_id = _this.data('order_id')
        _this.html('Äang gá»­i...')
        $.ajax({
            url: '/backend/orders/put_viettelpost',
            type: 'GET',
            cache: false,
            data:
            {
                order_id : order_id
            },
            success: function(data){
                _this.html('Äáº©y Ä‘Æ¡n')
            }
        });
    });

    $("#product_length").on('change',function(){
        VTPOnUpdatePrice();
    });
    $("#product_width").on('change',function(){
        VTPOnUpdatePrice();
    });
    $("#product_height").on('change',function(){
        VTPOnUpdatePrice();
    });

    $('#vtp_select_store').on('change',function() {
        VTPOnUpdatePrice();
    });
    $('#total_weight').on('change',function() {
        VTPOnUpdatePrice();
    });
    $('#money_collection').on('change',function() {
        VTPOnUpdatePrice();
    });
    $(document).on('change','input[type=radio][name=vtp_service]',function() {
        VTPOnUpdatePrice();
    });
    $('#check_money_collection').change(function() {
        VTPOnUpdatePrice();
    });
    
    function VTPOnUpdatePrice(){
        let store_id = $("#vtp_select_store").val();
        let order_id = $("#order_id").val();
        let total_weight = $("#total_weight").val();
        let width = $("#product_width").val();
        let length = $("#product_length").val();
        let height = $("#product_height").val();
        let money_collection = $("#money_collection").val();
        let check_money_collection = $('input[type=checkbox][name=check_money_collection]:checked').val();
        let vtp_service = $("input[type=radio][name=vtp_service]:checked").val()
        let urlRoute = $("#url_select_store").val();
        console.log(store_id)
        $.ajax({
            url: urlRoute,
            type: 'GET',
            cache: false,
            data:
            {
                store_id : store_id,
                order_id : order_id,
                total_weight: total_weight,
                width: width,
                length: length,
                height: height,
                money_collection: money_collection,
                vtp_service: vtp_service,
                check_money_collection: check_money_collection
            },
            success: function(res){
                if (res.status) {
                    $("#vtp_shipping_price").val(res.shipping_price);
                    $("#money_collection").val(res.total_price);
                    $('#weight_calc').val(res.weight_calc);
                    $("#vtp_error").html('');
                    $('#vtp_error_callout').hide();
                    $("#vtp_btn_create").attr('disabled', false);
                    $('#view_service').html(res.view_service);
                    Toast.fire({
                        icon: 'success',
                        title: res.msg,
                    })
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: res.msg,
                    })
                    $('#vtp_error_callout').show();
                    $("#vtp_error").html(res.msg)
                    $("#vtp_btn_create").attr('disabled', true)
                }
            }
        });
    }

    $("#vtp_btn_create").on('click', function(e){
        e.preventDefault();
        var el = $(this);
        var route = el.data('route');
        var data = $('#formVTP').serializeArray().reduce(function(obj, item) {
            obj[item.name] = item.value;
            return obj;
        }, {});
        el.html('Đang xử lý...')
        el.attr('disabled', true);
        $.ajax({
            url: route,
            type: 'POST',
            cache: false,
            data: data,
            success: function(res){
                if (res.status) {
                    window.location.reload();
                    Toast.fire({
                        icon: 'success',
                        title: res.msg,
                    })
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: res.msg,
                    })
                    $("#vtp_error").html(res.msg);
                    el.html('Tạo đơn');
                    el.attr('disabled', false);
                }
            }
        });
    })

    $("#btn_cancel_vtp").click(function(){
        var _this = $(this);
        _this.html('Äang xá»­ lĂ½...')
        _this.attr('disabled', true);
        $.ajax({
            url:    '/backend/orders/cancel_viettelpost',
            type: 'GET',
            cache: false,
            data: {
                order_id: _this.data('order_id')
            },
            success: function(res){
                if (res.status) {
                    alert('ÄĂ£ huá»· Ä‘Æ¡n thĂ nh cĂ´ng');
                    location.reload();
                } else {
                    _this.html('Huá»· Ä‘Æ¡n');
                    _this.attr('disabled', false);
                    alert(res.msg)
                }
            }
        });
    })
});

function changeInput(){
    var content = $('#current-slug').val();
    var base = $('#baseUrl').val();
    var html = '<span class="default-slug">'+base+'/<span id="editable-post-name"><input type="text" id="new-post-slug" value="'+content+'"></span></span>';
    $('#sample-permalink').html(html);
}

function cancelInput(slug = null){

    var current_slug;
    if(slug == null){
       current_slug = $('#current-slug').val();
    }else{
        current_slug = slug;
    }
    var base = $('#baseUrl').val();
    var html = '<a class="permalink" target="_blank" href="'+base+'/'+current_slug+'"><span class="default-slug">'+base+'/<span id="editable-post-name">'+current_slug+'</span></span></a>';
    $('#sample-permalink').html(html);
}

