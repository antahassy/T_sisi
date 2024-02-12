$(document).ready(function(){
    $.ajaxSetup({
        headers 	: {
            'X-CSRF-TOKEN' 	: $('meta[name="csrf-token"]').attr('content')
        }
    });
    var nama_bulan = new Array();
    nama_bulan[1] = 'Januari';
    nama_bulan[2] = 'Februari';
    nama_bulan[3] = 'Maret';
    nama_bulan[4] = 'April';
    nama_bulan[5] = 'Mei';
    nama_bulan[6] = 'Juni';
    nama_bulan[7] = 'Juli';
    nama_bulan[8] = 'Agustus'; 
    nama_bulan[9] = 'September'; 
    nama_bulan[10] = 'Oktober';
    nama_bulan[11] = 'November'; 
    nama_bulan[12] = 'Desember';
    var table_data = '';
    swal({
        showConfirmButton   : false,
        allowOutsideClick   : false,
        allowEscapeKey      : false,
        background          : 'transparent',
        onOpen  : function(){
            swal.showLoading();
            setTimeout(function(){
                data_table();
            },300);
        }
    });
    function data_table(){
        table_data = $('#table_data').DataTable({
            lengthMenu          : [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],
            processing          : true, 
            destroy             : true,
            serverSide          : true, 
            scrollX             : true,
            scrollCollapse      : true,
            fixedColumns        : true, 
            initComplete: function(){
                swal.close();
                main();
            },
            ajax            : {
                url         : site + '/group_admin',
                method      : 'get'
            },
            columns             : [
                {data   : 'DT_RowIndex'},
                {data   : 'name'},
                {data   : 'description'},
                {defaultContent: '',
                        render: function(data, type, row){
                            if(hak_akses.includes(3) && hak_akses.includes(4)){
                                if(row.id == 1){
                                    return '<a href="' + site + '/group_admin/akses/' + row.id + '" class="btn btn-sm btn-outline-success" style="margin: 2.5px;">Akses</a>' + '<button class="btn btn-sm btn-outline-primary btn_edit" style="margin: 2.5px;">Edit</button>';
                                }else{
                                    return '<a href="' + site + '/group_admin/akses/' + row.id + '" class="btn btn-sm btn-outline-success" style="margin: 2.5px;">Akses</a>' + '<button class="btn btn-sm btn-outline-primary btn_edit" style="margin: 2.5px;">Edit</button>' + '<button class="btn btn-sm btn-outline-danger btn_delete" style="margin: 2.5px;">Hapus</button>';
                                }
                            }
                            if(! hak_akses.includes(3) && hak_akses.includes(4)){
                                if(row.id == 1){
                                    return '';
                                }else{
                                    return '<button class="btn btn-sm btn-outline-danger btn_delete" style="margin: 2.5px;">Hapus</button>';   
                                }
                            }
                            if(hak_akses.includes(3) && ! hak_akses.includes(4)){
                                return '<a href="' + site + '/group_admin/akses/' + row.id + '" class="btn btn-sm btn-outline-success" style="margin: 2.5px;">Akses</a>' + '<button class="btn btn-sm btn-outline-primary btn_edit" style="margin: 2.5px;">Edit</button>';
                            }else{
                                return '';
                            }
                        }
                },
                {data 	: 'created_at',
                       render: function(data, type, row){
                        var time = row.created_at.split(' ');
                        return time[0].split('-')[2] + '/' + nama_bulan[Number(time[0].split('-')[1])] + '/' + time[0].split('-')[0] + '<br>' + time[1] + '<br>' + row.created; 
                    }
                   },
                   {data 	: 'updated_at',
                       render: function(data, type, row){
                           if(row.updated_at != null){
                               var time = row.updated_at.split(' ');
                            return time[0].split('-')[2] + '/' + nama_bulan[Number(time[0].split('-')[1])] + '/' + time[0].split('-')[0] + '<br>' + time[1] + '<br>' + row.updated; 
                           }else{
                               return '';
                           }
                    }
                   }
            ]
        });
    }
    function main(){
        swal.close();
        var modal_form;
           $('#modal_form').on('show.bs.modal', function(){
            $(this).addClass('zoomIn');
            modal_form = true;
           });
           $('#modal_form').on('hide.bs.modal', function(){
            if(modal_form){
                $(this).removeClass('zoomIn').addClass('zoomOut');
                modal_form = false;
                setTimeout(function(){
                    $('#modal_form').modal('hide');
                },350);
                return false;
            }
            $(this).removeClass('zoomOut');
        });
        $('#btn_add').on('click', function(){
            $('#form_data')[0].reset();
            $('#modal_form').find('.modal-title').text('Tambah');
            $('#btn_process').text('Simpan');
            $('#form_data').attr('method', 'post');
            $('#_method').val('post');
            $('#form_data').attr('action', site + '/group_admin');
            $('#modal_form').modal('show');
            data_process();
        });
        $('#table_data').on('click', '.btn_edit', function(){
            var action_data = table_data.row($(this).parents('tr')).data();
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
                            method         : 'get',
                            url            : site + '/group_admin/' + action_data.id + '/edit',
                            async          : true,
                            dataType       : 'json',
                            success        : function(data){
                                $('#form_data')[0].reset();
                                $('#level').val(data.name);
                                $('#deskripsi').val(data.description);

                                $('#modal_form').find('.modal-title').text('Edit');
                                $('#btn_process').text('Update');
                                $('#form_data').attr('method', 'post');
                                $('#_method').val('put');
                                $('#form_data').attr('action', site + '/group_admin/' + data.id);
                                swal.close();
                                $('#modal_form').modal('show');
                                data_process();
                            },
                            error   : function(error){
                                send_error(error, site + '/group_admin/' + action_data.id + '/edit', form_data = '-');
                            }
                        });
                    },300);
                }
            });     
        });
        $('#table_data').on('click', '.btn_delete', function(){
            var action_data = table_data.row($(this).parents('tr')).data();
            swal({
                html                : '<pre>Beberapa user akan kehilangan' + '<br>' + 
                                      'Group & akses menu' + '<br>' + 
                                      'Hapus data ini ?</pre>',
                type                : "question",
                background          : 'transparent',
                showCancelButton    : true,
                cancelButtonText    : 'Tidak',
                confirmButtonText   : 'Ya'
               }).then((result) => {
                if(result.value){
                    swal({
                        showConfirmButton   : false,
                        allowOutsideClick   : false,
                        allowEscapeKey      : false,
                        background          : 'transparent',
                        onOpen  : function(){
                            swal.showLoading();
                            setTimeout(function(){
                                $.ajax({
                                    type        : 'ajax',
                                    method      : 'post',
                                    data        : {id : action_data.id},
                                    url         : site + '/group_admin/hapus',
                                    dataType    : "json",
                                    async       : true,
                                    success   : function(response){
                                        if(response.success){
                                            swal({
                                                html                : '<pre>Data berhasil dihapus</pre>',
                                                type                : "success",
                                                background          : 'transparent',
                                                allowOutsideClick   : false,
                                                allowEscapeKey      : false, 
                                                showConfirmButton   : false,
                                                timer               : 1000
                                            }).then(function(){
                                                setTimeout(function(){
                                                    send_activity(id_menu = '4', activity = 'Menghapus id_group ' + action_data.id);
                                                    data_table();
                                                },300);
                                            });
                                        }
                                    },
                                    error   : function(error){
                                        send_error(error, site + '/group_admin/hapus', action_data.id);
                                    }
                                });
                            },300);
                        }
                    });
                }
               });
        });
    }
    
    function data_process(){
        $('#btn_process').on('click', function(event){
            event.preventDefault();
            event.stopImmediatePropagation();
            var ajax_method		= $('#form_data').attr('method');
            var ajax_url   		= $('#form_data').attr('action');
            var form_data       = $('#form_data')[0];
            form_data       	= new FormData(form_data);
            var errormessage    = '';
            if(! $('#level').val()){
                errormessage += 'Group dibutuhkan \n';
            }
            if(! $('#deskripsi').val()){
                errormessage += 'Deskripsi dibutuhkan \n';
            }
            if(errormessage !== ''){
                swal({
                    background  : 'transparent',
                    html        : '<pre>' + errormessage + '</pre>'
                });
            }else{
                swal({
                    background          : 'transparent',
                    html                : '<pre>Apakah data sudah benar ?</pre>',
                    type                : 'question',
                    showCancelButton    : true,
                    cancelButtonText    : 'Tidak',
                    confirmButtonText   : 'Ya'
                }).then((result) => {
                    if(result.value){
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
                                            if(response.success){
                                                $('#modal_form').modal('hide');
                                                $('#form_data')[0].reset();
                                                swal({
                                                    html                : '<pre>Data berhasil ' + response.type + '</pre>',
                                                    type                : "success",
                                                    background          : 'transparent',
                                                    allowOutsideClick   : false,
                                                    allowEscapeKey      : false, 
                                                    showConfirmButton   : false,
                                                    timer               : 1000
                                                }).then(function(){
                                                    setTimeout(function(){
                                                        send_activity(id_menu = '4', activity = response.activity);
                                                        data_table();
                                                    },300);
                                                });
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
                });
            }
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
                console.log(resp);
            }
        });
    }
    function send_error(error, url, form_data){
        var json_data = '-';
        if(form_data != '-'){
            if(isNaN(form_data)){
                var value_param = {};
                form_data.forEach(function(value, key){
                    value_param[key] = value;
                });
                json_data = JSON.stringify(value_param);
            }else{
                json_data = form_data;
            }
        }
        url = url.replace(site,'');
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