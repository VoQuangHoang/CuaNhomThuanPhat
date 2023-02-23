$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    }
});

var Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
});

$(document).on('click', '.btn_send_contact', function (e) {
    e.preventDefault();
    const el = $(this);
    const url = $(this).parents('form').attr('action');
    const data = $(this).parents('form').serialize();
    $('.fr-error').remove();
    $.ajax({
        type: 'POST',
        url: url,
        dataType: "json",
        data: data,
        beforeSend: function () {
            $('#lds-loading').show();
        },
        success: function (data) {
            if (data.success == true) {
                Toast.fire({
                    icon: 'success',
                    title: data.message
                })
                el.parents('form')[0].reset();
                $('html, body').animate({
                    scrollTop: '0px'
                }, 800);
                $('#lds-loading').hide();
            }

            if (data.success == false) {
                $.each(data.errorMessage, function (field, item) {
                    var html_error = '<span class="fr-error d-block mt-1"><i class="fas fa-exclamation-circle"></i> ' + item + '</span>';
                    if (field == 'message') {
                        el.parents('form').find('textarea').after(html_error);
                    } else {
                        el.parents('form').find('input[name="' + field + '"]').after(html_error);
                    }
                });
                $('#lds-loading').hide();
            }
        }
    });
})

$(document).on('click', '.add_to_wishlist', function (e) {
    e.preventDefault();
    var product_id = $(this).data('id');
    $.ajax({
        type: "POST",
        url: '/add-wishlist',
        data: {
            'id': product_id
        },
        dataType: "json",
        success: function (data) {
            if (data.check == 'login') {
                Toast.fire({
                    icon: 'error',
                    title: 'Đăng nhập để thêm sản phẩm yêu thích'
                })
            } else if (data.check == 'active') {
                Toast.fire({
                    icon: 'success',
                    title: 'Đã thêm sản phẩm vào yêu thích'
                })
                $('[id="item-wishlist-' + product_id + '"]').addClass('active');
            } else {
                Toast.fire({
                    icon: 'success',
                    title: 'Đã xóa sản phẩm khỏi yêu thích'
                })
                $('[id="item-wishlist-' + product_id + '"]').removeClass('active');
                $('#wishlist-item-remove-' + product_id).remove();
            }
        }
    });
})

// Add to cart
$(document).on('click', '.add-to-cart', function (e) {
    e.preventDefault();
    const url = $(this).parents('form').attr('action');
    const data = $(this).parents('form').serialize();
    $('.fr-error').remove();
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        dataType: "json",
        success: function (data) {
            if (data.type == 1) {
                window.location.href = data.url;
            }
            if (data.type == 2) {
                Toast.fire({
                    icon: 'success',
                    title: 'Đã thêm sản phẩm vào giỏ hàng'
                })
                $('.shop-count').html(data.count);
            }
            if (data.success == false) {
                $.each(data.errorMessage, function (field, item) {
                    var html_error = '<span class="fr-error d-block mt-1"><i class="fas fa-exclamation-circle"></i> ' + item + '</span>';
                    $("#product_attributes_id").html(html_error);
                });
            }
        }
    });
})

// Detele item cart
$(document).on('click', '.remove_item_cart', function (e) {
    e.preventDefault();
    var rowid = $(this).data('rowid');
    var id = $(this).data('id');
    $.ajax({
        type: 'GET',
        url: '/remove-cart',
        data: {
            'rowid': rowid
        },
        dataType: "json",
        success: function (data) {
            Toast.fire({
                icon: 'success',
                title: 'Đã xóa sản phẩm khỏi giỏ hàng'
            })
            $('#item-cart-' + id).remove();
            $('.shop-count').html(data.count);
            if (data.count == 0) {
                $('.shop-count').html(data.count);
                $('#cart_full_content').html(data.cart_none);
            }
        }
    });
})

// Update cart
$(document).on("click", "#plus-cart", function (e) {
    e.preventDefault();
    var rowid = $(this).data('rowid');
    var id = $(this).data('id');
    var quantity = $('#quantity' + id);
    console.log(quantity)
    var newValue = parseInt(quantity.val()) + 1;
    console.log(newValue)

    quantity.val(newValue);
    $.ajax({
        url: '/update-cart',
        type: "POST",
        dataType: "json",
        data: {
            id: rowid,
            qty: newValue
        },
        success: function (data) {
            Toast.fire({
                icon: 'success',
                title: 'Cập nhật giỏ hàng thành công'
            })
            $('.shop-count').html(data.count);
            $('#cart_full_content').html(data.cart_full);
        }
    });
});

$(document).on("click", "#minus-cart", function (e) {
    e.preventDefault();
    var rowid = $(this).data('rowid');
    var id = $(this).data('id');
    var quantity = $('#quantity' + id);
    var oldValue = quantity.val();
    var newValue = 0;
    var rowid = $(this).data('rowid');

    if (oldValue <= 1) {
        newValue = 1;
    } else {
        newValue = parseInt(quantity.val()) - 1;
    }
    quantity.val(newValue);
    $.ajax({
        url: '/update-cart',
        type: "POST",
        dataType: "json",
        data: {
            id: rowid,
            qty: newValue
        },
        success: function (data) {
            Toast.fire({
                icon: 'success',
                title: 'Cập nhật giỏ hàng thành công'
            })
            $('.total_shopping_product').html(data.count);
            $('#cart_full_content').html(data.cart_full);
        }
    });
});

// Send checkout
$(document).on('click','.btn_send_checkout', function (e) {
    e.preventDefault();
    const el = $(this);
    const url = $(this).parents('form').attr('action');
    const data = $(this).parents('form').serialize();
    $('.fr-error').remove();
    $.ajax({
        type: 'POST',
        url: url,
        dataType: "json",
        data: data,
        beforeSend: function () {
            $('#lds-loading').show();
        },
        success: function (data) {
            if (data.check == 'no_login') {
                Toast.fire({
                    icon: 'error',
                    title: 'Đăng nhập hoàn tất thanh toán'
                })
                $('#lds-loading').hide();

            }
            if (data.check == 'no_cart') {
                $('#lds-loading').hide();
                Toast.fire({
                    icon: 'error',
                    title: 'Giỏ hàng chưa có sản phẩm nào'
                })
                window.location.href = data.url
            }
            if (data.success == true) {
                $('#lds-loading').hide();
                Toast.fire({
                    icon: 'success',
                    title: 'Đặt hàng thành công. Chúng tôi sẽ liên hệ để xác nhận lại đơn hàng'
                })
                el.parents('form')[0].reset();
                window.setTimeout(function () {
                    window.location.href = data.url
                }, 1500);
            }
            if (data.success == false) {
                $('#lds-loading').hide();
                $('[href="#review-tab"]').tab('show');
                $.each(data.errorMessage, function (field, item) {
                    var html_error = '<span class="fr-error d-block mt-1"><i class="fas fa-exclamation-circle"></i> ' + item + '</span>';
                    if (field == 'address') {
                        el.parents('form').find('textarea[name="' + field + '"]').after(html_error);
                    } else {
                        el.parents('form').find('input[name="' + field + '"]').after(html_error);
                        el.parents('form').find('select[name="' + field + '"]').after(html_error);
                    }
                });
            }
        }
    });
})


// Send Product Review
$(document).on('click','.send_product_review', function (e) {
    e.preventDefault();
    const el = $(this);
    const url = $('.feedback-form').attr('action');
    const data = $(this).parents('form').serialize();

    $('.fr-error').remove();

    $.ajax({

        type: "POST",
        url: url,
        dataType: "json",
        data: data,

        success: function (data) {

            if (data.check == 'login'){
                Toast.fire({
                    icon: 'error',
                    title: data.message
                })
            }
            if (data.success == true) {
                Toast.fire({
                    icon: 'success',
                    title: data.message,
                })
                el.parents('form')[0].reset();
                setTimeout(function () {
                    window.location.reload()
                }, 3000);
                $('[href="#review-tab"]').tab('show');
            }
            if (data.success == false) {
                $('[href="#review-tab"]').tab('show');
                $.each(data.errorMessage, function (field, item) {
                    var html_error = '<span class="fr-error d-block mt-1"><i class="fas fa-exclamation-circle"></i> ' + item + '</span>';
                    if (field == 'content') {
                        el.parents('form').find('textarea').after(html_error);
                    } else {
                        el.parents('form').find('input[name="' + field + '"]').after(html_error);
                    }
                });
            }
        }
    });
})


// Load more review
$(document).on('click','#more_reivew', function () {
    var page = $(this).data('paginate');
    var slug = $(this).data('slug');
    loadMoreData(page, slug);
    $(this).data('paginate', page + 1);
});

function loadMoreData(paginate, slug) {
    $.ajax({
            url: '/load-more-product-review?page=' + paginate,
            type: 'GET',
            dataType: "json",
            data: {
                'slug': slug
            },
            beforeSend: function () {
                $('#more_reivew').text('Loading...');
            }
        })
        .done(function (data) {
            if (data.html.length == 0) {
                $('.invisible').removeClass('invisible');
                $('#more_reivew').hide();
                return;
            } else {
                $('#more_reivew').text('Xem thêm...');
                $('#list_product_reviews').append(data.html);
            }
        })
        .fail(function (jqXHR, ajaxOptions, thrownError) {
            alert('Something went wrong.');
        });
}

$(document).on('click','.quick-view', function (e) {
    e.preventDefault();
    var slug = $(this).data('slug');

    $.ajax({
        type: "GET",
        url: '/show-quick-view-product/'+slug,
        dataType: "json",
        data: {
            'slug': slug,
        },
        beforeSend: function () {
            $('#lds-loading').show();
        },
        success: function (data) {

            if (data.success == true) {
			    $(".quickview-box-inner").html(data.html);
                $('#lds-loading').hide();
                const mainCarousel = new Carousel(
                    document.querySelector("#mainCarousel1"),
                    {
                        Dots: false,
                        on: {
                            createSlide: (carousel, slide) => {},
                            deleteSlide: (carousel, slide) => {
                                if (slide.Panzoom) {
                                    slide.Panzoom.destroy();
                                    slide.Panzoom = null;
                                }
                            },
                        },
                    }
                );
    
                const thumbCarousel = new Carousel(
                    document.querySelector("#thumbCarousel1"),
                    {
                        Sync: {
                            target: mainCarousel,
                            friction: 0,
                        },
                        Dots: false,
                        Navigation: false,
                        center: true,
                        infinite: false,
                    }
                );
            }
        },
        fail: function (jqXHR, ajaxOptions, thrownError) {
            alert('Something went wrong.');
        }
    });
})

$(document).on('change', '#sort', function (e) {
    e.preventDefault();
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    var url = $(this).val();
    // console.log(url)
    // console.log(queryString)
    // console.log(urlParams)
    if (url) {
        window.location = url;
    }
    return false;
})

$(document).on('change','#city_field', function (e) {
    e.preventDefault();
    var city_id = $(this).val();
    $.ajax({
        type: 'GET',
        url: '/quan-huyen',
        data: {
            'city_id': city_id
        },
        dataType: "json",
        beforeSend: function () {
            $('#lds-loading').show();
        },
        success: function (data) {
            $('#lds-loading').hide();
            $('#district_field').removeAttr('disabled');
            $('#ward_field').val('');
            $('#ward_field').attr('disabled', true);
            $('#district_field').html(data.html)
            // $('.total_checkout').html(data.total + " đ")
        }
    })
})

$(document).on('change','#district_field', function (e) {
    e.preventDefault();
    let city_id = $("#city_field").val();
    var district_id = $(this).val();
    $.ajax({
        type: 'GET',
        url: '/xa-phuong',
        data: {
            'district_id': district_id,
            'city_id': city_id
        },
        dataType: "json",
        beforeSend: function () {
            $('#lds-loading').show();
        },
        success: function (data) {
            $('#lds-loading').hide();
            $('#ward_field').removeAttr('disabled');
            $('#ward_field').html(data.html);
            $('.shipping_fee').html(data.shipping);
            $('.discount').html(data.discount);
            $('.total_checkout').html(data.total);
            $('.cus_discount').html(data.cus_discount);
        }
    })
})

$(document).on('click', '#btn_apply_coupon',function(e){
    e.preventDefault();
    var el = $(this);
    let city_id = '';
    let district_id = '';
    let code = $('#coupon_code').val();
    let receive_gifts = $('#receive_gifts').is(":checked") ? $('#receive_gifts').val() : 0;
    let action = $(this).data('action');
    if ($("#city_field").val() != undefined) {
        city_id = $("#city_field").val()
    }
    if ($("#district_field").val() != undefined) {
        district_id = $("#district_field").val()
    }
    $.ajax({
        type: 'GET',
        url: '/check-discount',
        data: {
            'district_id': district_id,
            'city_id': city_id,
            'code' : code,
            'action' : action,
            'receive_gifts': receive_gifts
        },
        dataType: "json",
        beforeSend: function () {
            $('#lds-loading').show();
        },
        success: function(data) {
            $('#lds-loading').hide();
            if (data.success) {
                Toast.fire({
                    icon: 'success',
                    title: data.message,
                })
                el.data('action', 'remove');
                el.html('<span class="lb_addcart">Xoá</span>');
                $("#coupon_code").attr('readonly', true);
                $('#receive_gifts').attr('disabled', 'disabled');
                $('#receive_gifts').prop('checked', false);
                $('.shipping_fee').html(data.shipping);
                $('.discount').html(data.discount);
                $('.total_checkout').html(data.total);
                $('.cus_discount').html(data.cus_discount);
            } else {
                Toast.fire({
                    icon: 'error',
                    title: data.message,
                })
                $("#coupon_code").val('');
            }

            if(data.remove){
                Toast.fire({
                    icon: 'success',
                    title: data.message,
                })
                el.data('action', 'apply');
                $("#coupon_code").val('');
                $("#coupon_code").attr('readonly', false);
                $('#receive_gifts').prop('checked', true);
                $('#receive_gifts').attr('disabled', false);
                el.html('<span class="lb_addcart">Áp dụng</span>');
                $('.shipping_fee').html(data.shipping);
                $('.discount').html(data.discount);
                $('.total_checkout').html(data.total);
                $('.cus_discount').html(data.cus_discount);
            }
        },
        error: function (jqXHR, exception) {
            $('#lds-loading').hide();
        }

    });
});

$(document).on("click",'.clipboard', function () {
    value = $(this).data('ref');
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val(value).select();
    document.execCommand("copy");
    $temp.remove();

    Toast.fire({
        icon: 'success',
        title: 'URL Copy'
    })
})

$(document).on('click', '#btn_apply_referral',function(e){
    e.preventDefault();
    var el = $(this);
    let code = $('#referral_code').val();
    let action = $(this).data('action');
    $.ajax({
        type: 'GET',
        url: '/check-referral',
        data: {
            'code' : code,
            'action' : action,
        },
        dataType: "json",
        beforeSend: function () {
            $('#lds-loading').show();
        },
        success: function(data) {
            $('#lds-loading').hide();

            if (data.success) {
                Toast.fire({
                    icon: 'success',
                    title: data.message,
                })
                el.data('action', 'remove');
                el.html('<span class="lb_addcart">Xoá</span>');
                $("#referral_code").attr('readonly', true);
            } else {
                Toast.fire({
                    icon: 'error',
                    title: data.message,
                })
            }

            if(data.remove){
                Toast.fire({
                    icon: 'success',
                    title: data.message,
                })
                el.data('action', 'apply');
                $("#referral_code").val('');
                $("#referral_code").attr('readonly', false);
                el.html('<span class="lb_addcart">Áp dụng</span>');
            }
        },
        error: function (jqXHR, exception) {
            $('#lds-loading').hide();
        }

    });
});

$(document).on('click', '.cart-gift-title', function() {
    $(this).closest('.cart-gift').find('.cart-gift-list').slideToggle();
});
