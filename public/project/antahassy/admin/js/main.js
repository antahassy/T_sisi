$(document).ready(function(){
    logout_process();
    function logout_process(){
        $('#logout_btn').on('click', function(event){
            event.preventDefault();
            event.stopImmediatePropagation();
            swal({
                showConfirmButton   : false,
                allowOutsideClick   : false,
                allowEscapeKey      : false,
                background          : 'transparent',
                onOpen  : function(){
                    swal.showLoading();
                    setTimeout(function(){
                        send_activity(id_menu = 0, activity = 'Logout')
                    },300);
                }
            });
            return false;
        });
    }
    function send_activity(id_menu, activity){
        $.ajax({
            type           : 'ajax',
            method         : 'post',
            url            : site + '/activity',
            data           : {
                id_menu         : id_menu,
                activity        : activity
            },
            async          : true,
            dataType       : 'json',
            success        : function(resp){
                location.href = site + '/admin_logout';
            }
        });
    }
});