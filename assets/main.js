jQuery(document).ready(function ($) {    
    $('.jm_login_wrap form.jm_login_form').on('submit', function (e) {       
        e.preventDefault();
        $('.jm_login_wrap .status').show().text(ajax_handler.loadingmessage);       
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_handler.ajaxurl,
            data: {
                'action': 'ajaxlogin', //calls wp_ajax_nopriv_ajaxlogin
                'username': $('.jm_login_wrap form .jm_login_input').val(),
                'password': $('.jm_login_wrap form .jm_password_input').val(),
                'security': $('.jm_login_wrap #security').val()
            },
            success: function (data) {
                $('.jm_login_wrap p.message').text(data.message);
                
                if (data.success === true) {
                    $('.jm_login_wrap p.message').removeClass('red').addClass('green');
                    document.location.href = data.redirect;
                } else {
                    $('.jm_login_wrap p.message').addClass('red');
                }
            }
        });

    });


    $('.jm_signup_wrap form.jm_signup_form').on('submit', function (e) {
        $('.jm_signup_wrap p.message').show().text(ajax_handler.loadingmessage);        
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_handler.ajaxurl,
            data: {
                'action': 'ajaxsignup', //calls wp_ajax_nopriv_ajaxlogin
                'email': $('.jm_signup_wrap form .jm_login_input ').val(),
                'password': $('.jm_signup_wrap form .jm_password_input ').val(),
                'password_2': $('.jm_signup_wrap form .jm_confirm_password_input ').val(),
                'security': $('.jm_signup_wrap #security').val()
            },
            success: function (data) {
                $('.jm_signup_wrap p.message').text(data.message);
                console.log(data);
                if (data.success) {
                    $('.jm_signup_wrap p.message').removeClass('red').addClass('green');
                    document.location.href = data.redirect;
                } else {
                    $('.jm_signup_wrap p.message').addClass('red');
                }
            }
        });
        e.preventDefault();
    });

    $('.jm_pw_change_wrap form.jm_pw_change_form ').on('submit', function (e) {
        console.log('submit');
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_handler.ajaxurl,
            data: {
                'action': 'changepwd', 
                'old_password': $('.jm_pw_change_wrap .jm_old_password_input').val(),
                'new_password': $('.jm_pw_change_wrap .jm_new_password_input').val(),
                'confirm_password': $('.jm_pw_change_wrap .jm_confirm_password_input').val(),
                'security': $('.jm_pw_change_wrap #security').val()
            },
            success: function (data) {
                console.log(data);
                $('.jm_pw_change_wrap p.message').text(data.message);
                $('.jm_old_password_input, .jm_new_password_input, .jm_confirm_password_input').val('');
                if (data.pwd_changed === true) {
                    $('.jm_pw_change_wrap p.message').removeClass('red').addClass('green');
                    $('.jm_pw_change_form input.error').removeClass('error');
                } else {
                    $('.jm_pw_change_form p.message').removeClass('green').addClass('red');
                    if (data.wrong_pwd === true) {
                        $('jm_pw_change_wrap input.error').removeClass('error');
                        $('.jm_pw_change_wrap .jm_old_password_input').addClass('error');
                    } else if (data.mismatch === true) {
                        $('.jm_pw_change_wrap input.error').removeClass('error');
                        $('.jm_pw_change_wrap .jm_new_password_input').addClass('error');
                        $('.jm_pw_change_wrap .jm_confirm_password_input').addClass('error');

                    }
                }


            }

        });
        e.preventDefault();
    });
    
    $('form#useraddress').on('submit', function (e) {
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: ajax_handler.ajaxurl,
                data: {
                    'action': 'userinfo', //calls wp_ajax_nopriv_ajaxlogin
                    'first-name': $('form#useraddress #first-name').val(),
                    'last-name': $('form#useraddress #last-name').val(),
                    'email': $('form#useraddress #email').val(),
                    'address_1': $('form#useraddress #address_1').val(),
                    'address_2': $('form#useraddress #address_2').val(),
                    'city': $('form#useraddress #city').val(),
                    'zip_code': $('form#useraddress #zip_code').val(),
                    'country': $('form#useraddress #country').val(),
                    'security': $('form#useraddress #security').val()
                },
                success: function (data) {
                    console.log(data);
                    $('#user-address p.status').text(data.message);
                    if (data.address_updated === true) {
                        $('#user-address p.status').removeClass('red');
                        $('#user-address p.status').addClass('green');
                        $('form#useraddress #email').removeClass('error');
                    } else {
                        $('#user-address p.status').removeClass('green');
                        $('#user-address p.status').addClass('red');
                        $('form#useraddress #email').addClass('error');
                    }


                }

            });
            e.preventDefault();
        });
});