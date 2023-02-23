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

// Đăng nhập
$(document).on('click','.btn_login', function (e) {
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
        complete: function () {
        },
        success: function (data) {
            if (data.success == 1) {
                Toast.fire({
                    icon: 'success',
                    title: data.message
                })
                window.setTimeout(function () {
                    window.location.href = data.redirect
                }, 1000);
            }

            if (data.success == 2) {
                Toast.fire({
                    icon: 'success',
                    title: data.message
                })
                window.setTimeout(function () {
                    window.location.href = data.redirect
                }, 1000);
            }

            if (data.success == 4) {
                var html_error = '<span class="fr-error d-block"><i class="fas fa-exclamation-circle"></i> ' + data.message + '</span>';
                $("#thongbaologin").html(html_error);
                $('#lds-loading').hide();

            }

            if (data.success == false) {
                $.each(data.errorMessage, function (field, item) {
                    var html_error = '<span class="fr-error d-block"><i class="fas fa-exclamation-circle"></i> ' + item + '</span>';

                    if (field == 'username') {
                        $("#thongbaousername").html(html_error);
                    } else {
                        $("#thongbaopassword").html(html_error);
                    }
                });
                $('#lds-loading').hide();
            }
        }
    });
})

// Đăng ký
$(document).on('click','.btn_register', function (e) {
    e.preventDefault();
    const el = $(this);
    const url = $(this).parents('form').attr('action');
    const data = $(this).parents('form').serialize();

    $('.fr-error').remove();
    const btn = $('.btn_register').html();

    $.ajax({
        type: 'POST',
        url: url,
        dataType: "json",
        data: data,
        beforeSend: function () {
            $('#lds-loading').show();
        },
        complete: function () {
            
        },
        success: function (data) {
            $('#lds-loading').hide();
            if (data.success == 1) {
                Toast.fire({
                    icon: 'success',
                    title: data.message
                })
                el.parents('form')[0].reset();
                window.setTimeout(function () {
                    window.location.href = data.redirect
                }, 1000)
            }

            if (data.success == 2) {
                Toast.fire({
                    icon: 'error',
                    title: data.message
                })
                el.parents('form')[0].reset();
            }

            if (data.success == false) {
                $.each(data.errorMessage, function (field, item) {
                    var html_error = '<span class="fr-error d-block mb-3"><i class="fas fa-exclamation-circle"></i> ' + item + '</span>';
                    if(field == 'password' || field == 'password_confirmation'){
                        el.parents('form').find('.' + field + '').after(html_error);
                        console.log('.' + field + '');
                    }
                    else{
                        el.parents('form').find('input[name="' + field + '"]').after(html_error);
                    }
                });
                
            }
        },
        error: function (data) {
            console.log(data)
        }
    });
})

// Thêm địa chỉ người dùng
$('.btn_themdiachi').on('click', function (e) {
    e.preventDefault();
    const el = $(this);
    const url = $(this).parents('form').attr('action');
    const data = $(this).parents('form').serialize();
    const btn = $('.btn_themdiachi').html();
    $('.fr-error').remove();

    $.ajax({

        type: 'POST',
        url: url,
        dataType: "json",
        data: data,

        beforeSend: function () {
            var html = '<div class="d-flex flex-row justify-content-center"><div class="spinner-border text-light mr-8"></div><div class="p-1 text-light">Đang xử lý</div></div>';
            $('.btn_themdiachi').html(html);
        },
        complete: function () {
            $('.btn_themdiachi').html(btn);
        },

        success: function (data) {

            if (data.success == true) {
                Toast.fire({
                    icon: 'success',
                    title: data.message
                })
                el.parents('form')[0].reset();
                window.setTimeout(function () {
                    window.location.reload()
                }, 1000);
            }

            if (data.success == false) {

                $.each(data.errorMessage, function (field, item) {
                    var html_error = '<p><span class="fr-error d-block mt-1"><i class="fas fa-exclamation-circle"></i> ' + item + '</span></p>';
                    if (field == 'address') {
                        el.parents('form').find('textarea').after(html_error);
                    } else if (field == 'is_default') {
                        $('.form-check').after(html_error);
                    } else {
                        el.parents('form').find('input[name="' + field + '"]').after(html_error);
                        el.parents('form').find('select[name="' + field + '"]').after(html_error);
                    }
                });
            }
        },
        error: function (data) {
            console.log(data)
        }
    });
})

// Thay đổi mật khẩu
$('.btn_thaydoimatkhau').on('click', function (e) {
    e.preventDefault();
    const el = $(this);
    const url = $(this).parents('form').attr('action');
    const data = $(this).parents('form').serialize();
    const btn = $('.btn_thaydoimatkhau').html();
    $('.fr-error').remove();

    $.ajax({

        type: 'POST',
        url: url,
        dataType: "json",
        data: data,
        beforeSend: function () {
            var html = '<div class="d-flex flex-row justify-content-center"><div class="spinner-border text-light mr-8"></div><div class="p-1 text-light">Đang xử lý</div></div>';
            $('.btn_thaydoimatkhau').html(html);
        },
        complete: function () {
            $('.btn_thaydoimatkhau').html(btn);
        },
        success: function (data) {

            if (data.success == true) {
                Toast.fire({
                    icon: 'success',
                    title: data.message
                })
                el.parents('form')[0].reset();
                // setTimeout(function() { window.location.reload()}, 5000);
                //$('html, body').animate({scrollTop: '0px'}, 800);

            }
            if (data.success == 2) {
                var html_error = '<p><span class="fr-error d-block mt-1"><i class="fas fa-exclamation-circle"></i> ' + data.message + '</span></p>';
                el.parents('form').find('input[name="' + 'password' + '"]').after(html_error);

            }
            if (data.success == false) {
                $.each(data.errorMessage, function (field, item) {
                    var html_error = '<p><span class="fr-error d-block mt-1"><i class="fas fa-exclamation-circle"></i> ' + item + '</span></p>';
                    if(field == 'password' || field == 'password_new_confirmation' || field == 'password_new'){
                        el.parents('form').find('.' + field + '').after(html_error);
                    } else {
                        el.parents('form').find('input[name="' + field + '"]').after(html_error);
                    }
                });
            }
        },
        error: function (data) {
            console.log(data)
        }
    });
})

// Cập nhật địa chỉ người dùng
$('.btn_capnhatdiachi').on('click', function (e) {
    e.preventDefault();
    const el = $(this);
    const url = $(this).parents('form').attr('action');
    const data = $(this).parents('form').serialize();
    const btn = $('.btn_capnhatdiachi').html();
    
    $('.fr-error').remove();
    $.ajax({

        type: 'POST',
        url: url,
        dataType: "json",
        data: data,

        beforeSend: function () {
            var html = '<div class="d-flex flex-row justify-content-center"><div class="spinner-border text-light mr-8"></div><div class="p-1 text-light">Đang xử lý</div></div>';
            $('.btn_capnhatdiachi').html(html);
        },
        complete: function () {
            $('.btn_capnhatdiachi').html(btn);
        },

        success: function (data) {

            if (data.success == true) {
                Toast.fire({
                    icon: 'success',
                    title: data.message
                })
            }

            if (data.success == false) {

                $.each(data.errorMessage, function (field, item) {
                    var html_error = '<p><span class="fr-error d-block mt-1"><i class="fas fa-exclamation-circle"></i> ' + item + '</span></p>';
                    if (field == 'address') {
                        el.parents('form').find('textarea').after(html_error);
                    } else if (field == 'is_default') {
                        $('.form-check').after(html_error);
                    } else {
                        el.parents('form').find('input[name="' + field + '"]').after(html_error);
                        el.parents('form').find('select[name="' + field + '"]').after(html_error);
                    }
                });
            }
        },
        error: function (data) {
            console.log(data)
        }
    });
})

// Cập nhật thông tin người dùng
$('.btn_updateinfo').on('click', function (e) {
    e.preventDefault();
    const el = $(this);
    const url = $(this).parents('form').attr('action');
    const data = $(this).parents('form').serialize();

    $('.fr-error').remove();
    const btn = $('.btn_updateinfo').html();
    var formData = new FormData($(this).parents('form')[0]);

    $.ajax({
        type: 'POST',
        url: url,
        dataType: "json",
        data: formData,
        processData: false,
        contentType: false,

        beforeSend: function () {
            var html = '<div class="d-flex flex-row justify-content-center"><div class="spinner-border text-light mr-8"></div><div class="p-1 text-light">Đang xử lý</div></div>';
            $('.btn_updateinfo').html(html);
        },
        complete: function () {
            $('.btn_updateinfo').html(btn);
        },

        success: function (data) {

            if (data.success == true) {
                Toast.fire({
                    icon: 'success',
                    title: data.message
                })
                window.setTimeout(function () {
                    window.location.reload()
                }, 1000);
            }

            if (data.success == false) {
                $.each(data.errorMessage, function (field, item) {
                    var html_error = '<p><span class="fr-error d-block mt-1"><i class="fas fa-exclamation-circle"></i> ' + item + '</span></p>';
                    if (field == 'gender') {
                        $('#gioitinh').after(html_error);
                    } else {
                        el.parents('form').find('input[name="' + field + '"]').after(html_error);
                    }
                });
            }
        },
        error: function (data) {
            console.log(data)
        }
    });
})

//Forgot Password
$(document).on('click', '.btn_forgot_password', function (e) {
    e.preventDefault();
    const el = $(this);
    const url = $(this).parents('form').attr('action');
    const data = $(this).parents('form').serialize();
    const btn = $('.btn_forgot_password').html();
    $('.fr-error').remove();

    $.ajax({

        type: 'POST',
        url: url,
        dataType: "json",
        data: data,

        beforeSend: function () {
            var html = '<div class="d-flex flex-row justify-content-center align-items-center"><div class="spinner-border text-light mr-8"></div><div class="p-2 text-light">Loading</div></div>';
            $('.btn_forgot_password').html(html);
            $('#lds-loading').show();
        },
        complete: function () {
            $('.btn_forgot_password').html(btn);
        },
        success: function (data) {
            $('#lds-loading').hide();
            if (data.success == 1) {
                Toast.fire({
                    icon: 'success',
                    title: data.message
                })
                el.parents('form')[0].reset();
            }

            if (data.success == 2) {
                Toast.fire({
                    icon: 'error',
                    title: data.message
                })
            }

            if (data.success == false) {
                $.each(data.errorMessage, function (field, item) {
                    var html_error = '<p><span class="fr-error d-block"><i class="fas fa-exclamation-circle"></i> ' + item + '</span></p>';
                    el.parents('form').find('input[name="' + field + '"]').after(html_error);
                });
            }
        },
        error: function (data) {
            console.log(data)
        }
    });
})

$(document).on('click', '.btn_create_customer', function (e) {
    e.preventDefault();
    const el = $(this);
    const url = $(this).parents('form').attr('action');
    const form = el.parents('form')[0];
    const btn = $('.btn_create_customer').html();
    const data = new FormData(form);
    console.log(data);
    $('.fr-error').remove();

    $.ajax({
        type: 'POST',
        url: url,
        dataType: "json",
        processData: false,
        contentType: false,
        data: data,
        beforeSend: function () {
            var html = '<div class="d-flex flex-row justify-content-center"><div class="spinner-border text-light mr-8"></div><div class="p-1 text-light">Đang xử lý</div></div>';
            $('.btn_create_customer').html(html);
        },
        complete: function () {
            $('.btn_create_customer').html(btn);
        },

        success: function (data) {

            if (data.success == true) {
                Toast.fire({
                    icon: 'success',
                    title: data.message
                })
                window.setTimeout(function () {
                    window.location.href = data.redirect
                }, 500);
            }

            if (data.success == false) {
                $.each(data.errorMessage, function (field, item) {
                    var html_error = '<p><span class="fr-error d-block mt-1"><i class="fas fa-exclamation-circle"></i> ' + item + '</span></p>';
                    if (field == 'customer_role_id') {
                        el.parents('form').find('select[name="' + field + '"]').after(html_error);
                    } else {
                        el.parents('form').find('input[name="' + field + '"]').after(html_error);
                    }
                });
            }
        },
        error: function (data) {
            console.log(data)
        }
    });
})

//Update Password
$(document).on('click', '.btn_update_password', function (e) {
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
        complete: function () {
            $('.btn_update_password').html(btn);
        },
        success: function (data) {
            $('#lds-loading').hide();
            if (data.success == 1) {
                Toast.fire({
                    icon: 'success',
                    title: data.message
                })
                el.parents('form')[0].reset();
                setTimeout(function() { window.location = data.url }, 2500);
            }

            if (data.success == 2) {
                Toast.fire({
                    icon: 'error',
                    title: data.message
                })
                setTimeout(function() { window.location = data.url }, 2500);
            }

            if (data.success == false) {
                $.each(data.errorMessage, function (field, item) {
                    var html_error = '<p><span class="fr-error d-block"><i class="fas fa-exclamation-circle"></i> ' + item + '</span></p>';
                    el.parents('form').find('input[name="' + field + '"]').after(html_error);
                });
            }
        },
        error: function (data) {
            console.log(data)
        }
    });
})