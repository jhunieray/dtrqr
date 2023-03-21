$(document).ready(function() {
    // Call the dataTables jQuery plugin
    var table = $('#employee_table').DataTable({
        "processing": true,
        "serverSide": true,
        // "select": {
        //     style: 'multi'
        // },
        "ajax":{
            "url": $('#base_url').val()+"employee/list",
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
                    return '<input type="checkbox" class="select-checkbox" id="'+data.id+'" value="'+data.id+'" data-fullname="'+data.first_name+' '+data.last_name+'">';
                },
                "className": "text-left"
            },
            { 
                "data": "id",
                "className": "text-left"
            },
            { 
                "data": "first_name",
                "className": "text-left"
            },
            { 
                "data": "last_name",
                "className": "text-left"
            },
            { 
                "data": "created_by",
                "className": "text-left"
            },
            { 
                "data": "datetime_added",
                "className": "text-left" 
            },
            { 
                "data": "datetime_updated",
                "className": "text-left" 
            },
            {
                "data": {
                    id: "id",
                    first_name: "first_name",
                    last_name: "last_name",
                    created_by: "created_by",
                    datetime_added: "datetime_added",
                    datetime_updated: "datetime_updated"
                },
                render: function ( data, type, row ) {
                    return '<button class="btn btn-info btn-sm btn-qr" data-type="qr" data-id="'+data.id+'" data-toggle="modal" data-target="#qremployeeModal"><i class="fa fa-qrcode"></i> Generate QR</button> <button class="btn btn-warning btn-sm btn-edit" data-type="edit" data-id="'+data.id+'" data-first_name="'+data.first_name+'" data-last_name="'+data.last_name+'" data-toggle="modal" data-target="#editemployeeModal"><i class="fa fa-edit"></i> Edit</button> <button class="btn btn-danger btn-sm" data-type="delete" data-id="'+data.id+'" data-first_name="'+data.first_name+'" data-last_name="'+data.last_name+'" data-toggle="modal" data-target="#delemployeeModal"><i class="fa fa-trash"></i> Delete</button>';
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

    $('#employee_table tbody').on( 'click', 'tr', function () {
        //$(this).toggleClass('selected');
        //$('#'+table.row( this ).data().id).prop("checked", $(this).hasClass('selected'));
    } );

    table.on('xhr.dt', function ( e, settings, json, xhr ) {
        //tbh
    } );

    $('#employee_table tbody').on('click', 'button', function() {
        var id = $(this).data('id');

        if($(this).data('type')=='edit') {
            $('#edit_id').val(id);
            $('#edit_first_name').val($(this).data('first_name'));
            $('#edit_last_name').val($(this).data('last_name'));
        } else if($(this).data('type')=='delete') {
            var str='<ul>';
            str+='<li><input type="hidden" name="tdel[]" value="' + $(this).data('id') + '" /> [ <label>' + $(this).data('id') + '</label> ] - <label><i>' + $(this).data('first_name') + ' ' + $(this).data('last_name') + '</i></label></li>';
            str+='</ul>';
            $('#form_del_employee .ditems').html(str);
        } else if($(this).data('type')=='qr') {
            $.get($('#base_url').val()+'employee/my_qr/'+id, function(data, status){
                var d = JSON.parse(data);
                $('#print_qr_btn').attr('href',$('#base_url').val()+d.file);
                $('#qr_img').attr("src",$('#base_url').val()+d.file);
            });
        }
    });

    $('#editemployeeModal').on('shown.bs.modal', function () {
        $('#edit_first_name').focus();
    });

    var add_request;

    $("#form_add_employee").submit(function(e){
        e.preventDefault();

        if (add_request) {
            add_request.abort();
        }

        var $form = $(this);

        var $inputs = $form.find("input, select, button, textarea");

        var serializedData = $form.serialize();

        $inputs.prop("disabled", true);

        add_request = $.ajax({
            url: $('#base_url').val()+"employee/add",
            type: "post",
            data: serializedData
        });

        // Callback handler that will be called on success
        add_request.done(function (response, textStatus){
            // Log a message to the console
            if(textStatus == 'success') {
                $('#form_add_employee .info').html('Employee Added Successfully!');
                $('#first_name').val('');
                $('#last_name').val('');
                table.ajax.reload( null, false );
                setTimeout(function() {
                    $('#employeeModal').modal('hide');
                    $('#form_add_employee .info').html('');
                }, 1500);
            } else {
                $('#form_add_employee .info').html('Error saving data.');
            }
        });

        // Callback handler that will be called on failure
        add_request.fail(function (textStatus, errorThrown){
            // Log the error to the console
            $('#form_add_employee .info').html('The following error occurred: '+
                textStatus, errorThrown);
        });

        // Callback handler that will be called regardless
        // if the request failed or succeeded
        add_request.always(function () {
            // Reenable the inputs
            $inputs.prop("disabled", false);
        });
    });

    var edit_request;

    $("#form_edit_employee").submit(function(e){
        e.preventDefault();

        if (edit_request) {
            edit_request.abort();
        }

        var $form = $(this);

        var $inputs = $form.find("input, select, button, textarea");

        var serializedData = $form.serialize();

        $inputs.prop("disabled", true);
        edit_request = $.ajax({
            url: $('#base_url').val()+"employee/edit/"+$($inputs[3]).val(),
            type: "post",
            data: {
                'first_name': $($inputs[1]).val(),
                'last_name': $($inputs[2]).val()
            }
        });

        // Callback handler that will be called on success
        edit_request.done(function (response, textStatus){
            // Log a message to the console
            if(textStatus == 'success') {
                $('#form_edit_employee .info').html('Employee Saved Successfully!');
                $('#edit_id').val('');
                $('#edit_first_name').val('');
                $('#edit_last_name').val('');
                table.ajax.reload( null, false );
                setTimeout(function() {
                    $('#editemployeeModal').modal('hide');
                    $('#form_edit_employee .info').html('');
                }, 1500);
            } else {
                $('#form_edit_employee .info').html('Error saving data.');
            }
        });

        // Callback handler that will be called on failure
        edit_request.fail(function (textStatus, errorThrown){
            // Log the error to the console
            $('#form_edit_employee .info').html('The following error occurred: '+
                textStatus, errorThrown);
        });

        // Callback handler that will be called regardless
        // if the request failed or succeeded
        edit_request.always(function () {
            // Reenable the inputs
            $inputs.prop("disabled", false);
        });
    });

    var del_request;

    $("#form_del_employee").submit(function(e){
        e.preventDefault();

        if (del_request) {
            del_request.abort();
        }

        var $form = $(this);

        var $inputs = $form.find("input");

        var serializedData = $form.serialize();

        $inputs.prop("disabled", true);

        del_request = $.ajax({
            url: $('#base_url').val()+"employee/remove",
            type: "post",
            data: serializedData
        });

        // Callback handler that will be called on success
        del_request.done(function (response, textStatus){
            // Log a message to the console
            if(textStatus == 'success') {
                $('#form_del_employee .info').html('Employee Deleted Successfully!');
                $('#form_del_employee .ditems').text("");
                table.ajax.reload( null, false );
                setTimeout(function() {
                    $('#delemployeeModal').modal('hide');
                    $('#form_del_employee .info').html('');
                    $('#delete_employee').prop("disabled", true);
                }, 1500);
            } else {
                $('#form_del_employee .info').html('Error deleting data.');
            }
        });

        // Callback handler that will be called on failure
        del_request.fail(function (textStatus, errorThrown){
            // Log the error to the console
            $('#form_del_employee .info').html('The following error occurred: '+
                textStatus, errorThrown);
        });

        // Callback handler that will be called regardless
        // if the request failed or succeeded
        del_request.always(function () {
            // Reenable the inputs
            $inputs.prop("disabled", false);
        });
    });

    function cb_event() {
        $("#employee_table :checkbox").on("click", function() {
            var allChecked, trigger_btn;
            var $allCheckBox = $("#employee_table :checkbox");
            var checkedCount = $allCheckBox.filter(":not(:first)").filter(":checked").length;
            if(this == $allCheckBox[0]) {
                $allCheckBox.prop("checked", this.checked);
                $("#employee_table tr").toggleClass('selected', this.checked);
                trigger_btn = this.checked;
            } else {
                allChecked = (checkedCount+1) == $allCheckBox.length;
                $allCheckBox[0].checked = allChecked;
                trigger_btn = checkedCount>0;
            }
            button_enable("form_del_employee","delete_employee", trigger_btn);
        });
    }

    //Judgement if the row can be deleted
    function button_enable(form_id, button_id, enable) {
        $('#' + button_id).prop('disabled', !enable);
        $('#'+form_id+' .ditems').html(disDel());
    }

    function disDel() {
        var $allCheckBox = $("#employee_table :checkbox");
        var checked, str = '', checkedCount, i;
        checked = $allCheckBox.filter(":not(:first)").filter(":checked");
        checkedCount = checked.length;
        str+='<ul>';
        for(i=0;i<checkedCount;i++) {
            str+='<li><input type="hidden" name="tdel[]" value="' + checked[i].id + '" /> [ <label>' + checked[i].id + '</label> ] - <label><i>' + $(checked[i]).data('fullname') + '</i></label></li>';
        }
        str+='</ul>';
        return str;
    }
} );