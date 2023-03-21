$(document).ready(function() {
    // Call the dataTables jQuery plugin
    var table = $('#user_table').DataTable({
        "processing": true,
        "serverSide": true,
        // "select": {
        //     style: 'multi'
        // },
        "ajax":{
            "url": $('#base_url').val()+"user/list",
            "dataType": "json",
            "type": "POST",
            "data":{  '<?= $this->security->get_csrf_token_name() ?>' : '<?= $this->security->get_csrf_hash() ?>' }
        },
        "columns": [
            { 
                "data": {
                    id: "id"
                },
                render: function ( data, type, row ) {
                    var r = '';
                    if(data.id != $('#user_id_h').val()) {
                        r = '<input type="checkbox" class="select-checkbox" id="'+data.id+'" value="'+data.id+'" data-user_name="'+data.user_name+'">';
                    }
                    return r;
                },
                "className": "text-left"
            },
            { 
                "data": "id",
                "className": "text-left"
            },
            { 
                "data": "user_name",
                "className": "text-left"
            },
            { 
                "data": "user_type",
                "className": "text-left"
            },
            { 
                "data": "datetime_added",
                "className": "text-left" 
            },
            { 
                "data": "datetime_modified",
                "className": "text-left" 
            },
            {
                "data": {
                    id: "id",
                    user_name: "user_name",
                    user_type: "user_type",
                    datetime_added: "datetime_added",
                    datetime_modified: "datetime_modified"
                },
                render: function ( data, type, row ) {
                    var r = '';
                    if(data.id != $('#user_id_h').val()) {
                        r = '<button class="btn btn-danger btn-sm" data-type="delete" data-id="'+data.id+'" data-user_name="'+data.user_name+'" data-toggle="modal" data-target="#deluserModal"><i class="fa fa-trash"></i> Delete</button>';
                    }
                    return '<button class="btn btn-info btn-sm btn-cp" data-type="cp" data-id="'+data.id+'" data-user_name="'+data.user_name+'" data-toggle="modal" data-target="#editcpModal"><i class="fa fa-key"></i> Change Password</button> <button class="btn btn-warning btn-sm btn-edit" data-type="edit" data-id="'+data.id+'" data-user_name="'+data.user_name+'" data-user_type="'+data.user_type+'" data-toggle="modal" data-target="#edituserModal"><i class="fa fa-edit"></i> Edit</button> '+r;
                },
                "className": "text-left"
            },
        ],
        "lengthMenu": [[5000, 20000, 50000, -1], [5000, 20000, 50000, "All"]],
        "ordering": false,
        "drawCallback": function( settings ) {
            cb_event();
        }
    });

    $('#user_table tbody').on( 'click', 'tr', function () {
        //$(this).toggleClass('selected');
        //$('#'+table.row( this ).data().id).prop("checked", $(this).hasClass('selected'));
    } );

    table.on('xhr.dt', function ( e, settings, json, xhr ) {
        //tbh
    } );

    $('#user_table tbody').on('click', 'button', function() {
        var id = $(this).data('id');

        if($(this).data('type')=='edit') {
            $('#edit_id').val(id);
            $('#edit_user_name').val($(this).data('user_name'));
            $('#edit_user_type').val($(this).data('user_type')=='Super Admin'?1:2);
        } else if($(this).data('type')=='cp') {
            $('#edit_cp_id').val(id);
        } else if($(this).data('type')=='delete') {
            var str='<ul>';
            str+='<li><input type="hidden" name="tdel[]" value="' + $(this).data('id') + '" /> [ <label>' + $(this).data('id') + '</label> ] - <label><i>' + $(this).data('user_name') + '</i></label></li>';
            str+='</ul>';
            $('#form_del_user .ditems').html(str);
        }
    });

    $('#edituserModal').on('shown.bs.modal', function () {
        $('#edit_user_name').focus();
    });

    var add_request;

    $("#form_add_user").submit(function(e){
        e.preventDefault();

        if (add_request) {
            add_request.abort();
        }

        var $form = $(this);

        var $inputs = $form.find("input, select, button, textarea");

        var serializedData = $form.serialize();

        $inputs.prop("disabled", true);

        add_request = $.ajax({
            url: $('#base_url').val()+"user/add",
            type: "post",
            data: serializedData
        });

        // Callback handler that will be called on success
        add_request.done(function (response, textStatus){
            // Log a message to the console
            if(textStatus == 'success') {
                var response = JSON.parse(response);
                if(response.status == 'success') {
                    $('#form_add_user .info').html('User Added Successfully!');
                    $('#user_name').val('');
                    $('#user_password').val('');
                    $('#user_type').val(0);
                    table.ajax.reload( null, false );
                    setTimeout(function() {
                        $('#userModal').modal('hide');
                        $('#form_add_user .info').html('');
                    }, 1500);
                } else {

                   $('#form_add_user .info').html(response.error);
                }
            } else {
                $('#form_add_user .info').html('Error saving data.');
            }
        });

        // Callback handler that will be called on failure
        add_request.fail(function (response, textStatus){
            // Log the error to the console
            $('#form_add_user .info').html('The following error occurred: '+ response,textStatus);
        });

        // Callback handler that will be called regardless
        // if the request failed or succeeded
        add_request.always(function () {
            // Reenable the inputs
            $inputs.prop("disabled", false);
        });
    });

    var edit_request;

    $("#form_edit_user").submit(function(e){
        e.preventDefault();

        if (edit_request) {
            edit_request.abort();
        }

        var $form = $(this);

        var $inputs = $form.find("input, select, button, textarea");

        var serializedData = $form.serialize();

        $inputs.prop("disabled", true);
        edit_request = $.ajax({
            url: $('#base_url').val()+"user/edit/"+$($inputs[3]).val(),
            type: "post",
            data: {
                'edit_user_type': $($inputs[2]).val()
            }
        });

        // Callback handler that will be called on success
        edit_request.done(function (response, textStatus){
            // Log a message to the console
            if(textStatus == 'success') {
                var response = JSON.parse(response);
                if(response.status == 'success') {
                    $('#form_edit_user .info').html('User Saved Successfully!');
                    $('#edit_id').val('');
                    $('#edit_user_name').val('');
                    $('#edit_user_type').val(0);
                    table.ajax.reload( null, false );
                    setTimeout(function() {
                        $('#edituserModal').modal('hide');
                        $('#form_edit_user .info').html('');
                    }, 1500);
                } else {
                   $('#form_edit_user .info').html(response.error);
                }
            } else {
                $('#form_edit_user .info').html('Error saving data.');
            }
        });

        // Callback handler that will be called on failure
        edit_request.fail(function (textStatus, errorThrown){
            // Log the error to the console
            $('#form_edit_user .info').html('The following error occurred: '+
                textStatus, errorThrown);
        });

        // Callback handler that will be called regardless
        // if the request failed or succeeded
        edit_request.always(function () {
            // Reenable the inputs
            $inputs.prop("disabled", false);
        });
    });

    var cp_request;

    $("#form_edit_cp").submit(function(e){
        e.preventDefault();

        if (cp_request) {
            cp_request.abort();
        }

        var $form = $(this);

        var $inputs = $form.find("input, select, button, textarea");

        var serializedData = $form.serialize();
        $inputs.prop("disabled", true);
        cp_request = $.ajax({
            url: $('#base_url').val()+"user/cp/"+$($inputs[3]).val(),
            type: "post",
            data: {
                'edit_cp_password': $($inputs[1]).val()
            }
        });

        // Callback handler that will be called on success
        cp_request.done(function (response, textStatus){
            // Log a message to the console
            if(textStatus == 'success') {
                var response = JSON.parse(response);
                if(response.status == 'success') {
                    $('#form_edit_cp .info').html('Password Updated Successfully!');
                    $('#edit_cp_id').val('');
                    $('#edit_cp_password').val('');
                    table.ajax.reload( null, false );
                    setTimeout(function() {
                        $('#editcpModal').modal('hide');
                        $('#form_edit_cp .info').html('');
                    }, 1500);
                } else {
                   $('#form_edit_cp .info').html(response.error);
                }
            } else {
                $('#form_edit_cp .info').html('Error saving data.');
            }
        });

        // Callback handler that will be called on failure
        cp_request.fail(function (textStatus, errorThrown){
            // Log the error to the console
            $('#form_edit_cp .info').html('The following error occurred: '+
                textStatus, errorThrown);
        });

        // Callback handler that will be called regardless
        // if the request failed or succeeded
        cp_request.always(function () {
            // Reenable the inputs
            $inputs.prop("disabled", false);
        });
    });

    var del_request;

    $("#form_del_user").submit(function(e){
        e.preventDefault();

        if (del_request) {
            del_request.abort();
        }

        var $form = $(this);

        var $inputs = $form.find("input");

        var serializedData = $form.serialize();

        $inputs.prop("disabled", true);

        del_request = $.ajax({
            url: $('#base_url').val()+"user/remove",
            type: "post",
            data: serializedData
        });

        // Callback handler that will be called on success
        del_request.done(function (response, textStatus){
            // Log a message to the console
            if(textStatus == 'success') {
                $('#form_del_user .info').html('User Deleted Successfully!');
                $('#form_del_user .ditems').text("");
                table.ajax.reload( null, false );
                setTimeout(function() {
                    $('#deluserModal').modal('hide');
                    $('#form_del_user .info').html('');
                    $('#delete_user').prop("disabled", true);
                }, 1500);
            } else {
                $('#form_del_user .info').html('Error deleting data.');
            }
        });

        // Callback handler that will be called on failure
        del_request.fail(function (textStatus, errorThrown){
            // Log the error to the console
            $('#form_del_user .info').html('The following error occurred: '+
                textStatus, errorThrown);
        });

        // Callback handler that will be called regardless
        // if the request failed or succeeded
        del_request.always(function () {
            // Reenable the inputs
            $inputs.prop("disabled", false);
        });
    });

    $('#btn_gen_pword').on('click', function() {
        var gen_pword = generate_pword();
        $('#user_password').val(gen_pword);
        $('#gen_pword_txt').html('Generated Password: <b>'+gen_pword+'</b>');
    });
    $('#btn_gen_pword_cp').on('click', function() {
        var gen_pword = generate_pword();
        $('#edit_cp_password').val(gen_pword);
        $('#gen_pword_txt_cp').html('Generated Password: <b>'+gen_pword+'</b>');
    });

    function cb_event() {
        $("#user_table :checkbox").on("click", function() {
            var allChecked, trigger_btn;
            var $allCheckBox = $("#user_table :checkbox");
            var checkedCount = $allCheckBox.filter(":not(:first)").filter(":checked").length;
            if(this == $allCheckBox[0]) {
                $allCheckBox.prop("checked", this.checked);
                $("#user_table tr").toggleClass('selected', this.checked);
                trigger_btn = this.checked;
            } else {
                allChecked = (checkedCount+1) == $allCheckBox.length;
                $allCheckBox[0].checked = allChecked;
                trigger_btn = checkedCount>0;
            }
            button_enable("form_del_user","delete_user", trigger_btn);
        });
    }

    //Judgement if the row can be deleted
    function button_enable(form_id, button_id, enable) {
        $('#' + button_id).prop('disabled', !enable);
        $('#'+form_id+' .ditems').html(disDel());
    }

    function disDel() {
        var $allCheckBox = $("#user_table :checkbox");
        var checked, str = '', checkedCount, i;
        checked = $allCheckBox.filter(":not(:first)").filter(":checked");
        checkedCount = checked.length;
        str+='<ul>';
        for(i=0;i<checkedCount;i++) {
            str+='<li><input type="hidden" name="tdel[]" value="' + checked[i].id + '" /> [ <label>' + checked[i].id + '</label> ] - <label><i>' + $(checked[i]).data('user_name') + '</i></label></li>';
        }
        str+='</ul>';
        return str;
    }

    //Generate Random Password
    function generate_pword()
    {
        var chars = "0123456789abcdefghijklmnopqrstuvwxyz!@#$%^&*()ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        var passwordLength = 10;
        var password = "";
        for (var i = 0; i <= passwordLength; i++) {
            var randomNumber = Math.floor(Math.random() * chars.length);
            password += chars.substring(randomNumber, randomNumber +1);
        }

        return password;
    }

} );