$(document).ready(function(){
    login_process();
    $.ajaxSetup({
        headers 	: {
            'X-CSRF-TOKEN' 	: $('meta[name="csrf-token"]').attr('content')
        }
    });
    function login_process(){
        $('#kt_login_signin_form').attr('method', 'post');
        $('#_method').val('post');
        $('#kt_login_signin_form').attr('action', site + '/admin/login');
        $('#kt_login_signin_submit').on('click', function(event){ 
            event.preventDefault();
            event.stopImmediatePropagation();
            var ajax_method		= $('#kt_login_signin_form').attr('method');
            var ajax_url   		= $('#kt_login_signin_form').attr('action');
            var form_data       = $('#kt_login_signin_form')[0];
            form_data       	= new FormData(form_data);
            var errormessage    = '';
            if(! $('#login_username').val()){
                 errormessage += 'Username dibutuhkan \n';
            }
            if(! $('#login_password').val()){
                 errormessage += 'Password dibutuhkan \n';
            }
            if(errormessage !== ''){
                swal({
                    background  : 'transparent',
                    html        : '<pre>' + errormessage + '</pre>'
                });
            }else{
                swal({
                    showConfirmButton   : false,
                    allowOutsideClick   : false,
                    allowEscapeKey      : false,
                    background          : 'transparent',
                    onOpen  : function(){
                        swal.showLoading();
                        setTimeout(function(){
                            $.ajax({
                                type           : 'ajax',
                                method         : ajax_method,
                                url            : ajax_url,
                                data           : form_data,
                                async          : true,
                                processData    : false,
                                contentType    : false,
                                cache          : false,
                                dataType       : 'json',
                                success        : function(response){
                                    if(response.username){
                                        swal({
                                            background  : 'transparent',
                                            html        : '<pre>Akun tidak terdaftar</pre>'
                                        });
                                    }
                                    if(response.pass){
                                        swal({
                                            background  : 'transparent',
                                            html        : '<pre>Password tidak cocok</pre>'
                                        });
                                    }
                                    if(response.banned){
                                        swal({
                                            background  : 'transparent',
                                            html        : '<pre>Akun dinonaktifkan' + '<br>' + 'Harap hubungi administrator</pre>'
                                        });
                                    }
                                    if(response.success){
                                        setTimeout(function(){
                                            location.reload(true);
                                        },300);
                                    }
                                },
                                error   : function(error){
                                    send_error(error, ajax_url, form_data);
                                }
                            });
                        },300);
                    }
                });
            }
            return false;
        });
    }
    function send_error(error, url, form_data){
        var value_param = {};
        form_data.forEach(function(value, key){
            value_param[key] = value;
        });
        url = url.replace(site,'');
        var json_data = JSON.stringify(value_param);
        $.ajax({
            type           : 'ajax',
            method         : 'post',
            url            : site + '/error',
            data           : {
                message         : error.responseJSON.message,
                function        : url,
                controller      : url,
                parameter       : json_data
            },
            async          : true,
            dataType       : 'json',
            success        : function(error_response){
                if(error_response.saved){
                    swal({
                        background  : 'transparent',
                        html        : '<pre>Koneksi terputus' + '<br>' + 
                                        'Cobalah beberapa saat lagi</pre>',
                        type        : "warning"
                    });
                }
            }
        });
    }
});