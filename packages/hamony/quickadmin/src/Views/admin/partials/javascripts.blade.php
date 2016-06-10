<!-- jQuery 2.2.0 -->
<script src="{{ url('quickadmin') }}/plugins/jQuery/jQuery-2.2.0.min.js"></script>
<script src="{{ url('quickadmin') }}/plugins/datatables/jQuery-2.2.0.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="{{ url('quickadmin') }}/bootstrap/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="{{ url('quickadmin') }}/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{ url('quickadmin') }}/plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- quickadmin App -->
<script src="{{ url('quickadmin/js') }}/app.min.js"></script>
<script src="{{ url('quickadmin/js') }}/main.js"></script>

<script>

    /*$('.datepicker').datepicker({
        autoclose: true,
        dateFormat: "{{ config('quickadmin.date_format_jquery') }}"
    });

    $('.datetimepicker').datetimepicker({
        autoclose: true,
        dateFormat: "{{ config('quickadmin.date_format_jquery') }}",
        timeFormat: "{{ config('quickadmin.time_format_jquery') }}"
    });

    $('#datatable').dataTable( {
        "language": {
            "url": "{{ trans('quickadmin::strings.datatable_url_language') }}"
        }
    });*/

    $('#datatable').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "rowReorder": true
    });
</script>
