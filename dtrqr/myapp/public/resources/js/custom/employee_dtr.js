$(document).ready(function() {
    // Call the dataTables jQuery plugin
    var table = $('#employee_time_table').DataTable({
        "processing": true,
        "serverSide": true,
        // "select": {
        //     style: 'multi'
        // },
        "ajax":{
            "url": $('#base_url').val()+"employee_time/dtr_list",
            "dataType": "json",
            "type": "POST",
            "data":{  '<?= $this->security->get_csrf_token_name() ?>' : '<?= $this->security->get_csrf_hash() ?>' }
        },
        "columns": [
            
            { 
                "data": "id",
                "className": "text-left"
            },
            { 
                "data": "employee",
                "className": "text-left"
            },
            { 
                "data": "logged_by",
                "className": "text-left"
            },
            { 
                "data": "date_added",
                "className": "text-left"
            },
            { 
                "data": "time_in",
                "className": "text-left" 
            },
            { 
                "data": "time_out",
                "className": "text-left" 
            }
        ],
        "lengthMenu": [[5000, 20000, 50000, -1], [5000, 20000, 50000, "All"]],
        "ordering": false,
        "drawCallback": function( settings ) {
            
        }
    });

    
} );