@extends('admin::layout')

@section('header')
    <section class="content-header">
        <h1>
            <span class="text-capitalize">{!! $xPanel->entity_name_plural !!}</span>
            <small>{{ trans('admin::messages.all') }} <span>{!! $xPanel->entity_name_plural !!}</span> {{ trans('admin::messages.in_the_database') }}.</small>
        </h1>
        <ol class="breadcrumb">
            @if(Auth::user()->user_type_id != config('constant.POST_AUTHOR_ID'))
                <li><a href="{{ url(config('larapen.admin.route_prefix', 'admin')) }}">{{ trans('admin::messages.dashboard') }}</a></li>
            @endif
            <li><a href="{{ url($xPanel->route) }}" class="text-capitalize">{!! $xPanel->entity_name_plural !!}</a></li>
            <li class="active">{{ trans('admin::messages.list') }}</li>
        </ol>
    </section>
@endsection


@section('content')
<section class="content">

    <!-- Default box -->
    <div class="row">

        <!-- THE ACTUAL CONTENT -->
        <div class="col-md-12">
            <div class="box">

                <div class="box-header {{ $xPanel->hasAccess('create')?'with-border':'' }}">
                    @include('admin::panel.inc.button_stack', ['stack' => 'top'])
                    <div id="datatable_button_stack" class="pull-right text-right"></div>
                </div>

                <div class="box-body">

                    {{-- List Filters --}}
					@if ($xPanel->filtersEnabled())
                        @include('admin::panel.inc.filters_navbar')
                    @endif

                    <table id="crudTable" class="table table-bordered table-striped display">
                        <thead>
                        <tr>
                            @if ($xPanel->details_row)
                                <th data-orderable="false"></th> <!-- expand/minimize button column -->
                            @endif

                            {{-- Table columns --}}
                            @foreach ($xPanel->columns as $column)
                                <th {{ isset($column['orderable']) ? 'data-orderable=' .var_export($column['orderable'], true) : '' }}>
                                    {{ $column['label'] }}
                                </th>
                            @endforeach

                            @if ( $xPanel->buttons->where('stack', 'line')->count() )
                                <th data-orderable="false">{{ trans('admin::messages.actions') }}</th>
                            @endif
                        </tr>
                        </thead>

                        <tbody>
                        </tbody>

                        <tfoot>
                        <tr>
                            @if ($xPanel->details_row)
                                <th></th> <!-- expand/minimize button column -->
                            @endif

                            {{-- Table columns --}}
                            @foreach ($xPanel->columns as $column)
                                <th>{{ $column['label'] }}</th>
                            @endforeach

                            @if ( $xPanel->buttons->where('stack', 'line')->count() )
                                <th>{{ trans('admin::messages.actions') }}</th>
                            @endif
                        </tr>
                        </tfoot>
                    </table>

                </div><!-- /.box-body -->

                @include('admin::panel.inc.button_stack', ['stack' => 'bottom'])

            </div><!-- /.box -->
        </div>

    </div>

</section>
@endsection

@section('after_styles')
    <!-- DATA TABLES -->
    <link href="{{ asset('vendor-admin/vendor-admin/adminlte/plugins/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />

    <!-- CRUD LIST CONTENT - crud_list_styles stack -->
    @stack('crud_list_styles')
@endsection

@section('after_scripts')
    <!-- DATA TABLES SCRIPT -->
    <script src="{{ asset('vendor-admin/vendor-admin/adminlte/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>

    @if (isset($xPanel->export_buttons) and $xPanel->export_buttons)
        <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js" type="text/javascript"></script>
        <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js" type="text/javascript"></script>
        <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.bootstrap.min.js" type="text/javascript"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js" type="text/javascript"></script>
        <script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js" type="text/javascript"></script>
        <script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js" type="text/javascript"></script>
        <script src="//cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js" type="text/javascript"></script>
        <script src="//cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js" type="text/javascript"></script>
        <script src="//cdn.datatables.net/buttons/1.2.2/js/buttons.colVis.min.js" type="text/javascript"></script>
    @endif

    <script src="{{ asset('vendor-admin/vendor-admin/adminlte/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
        jQuery(document).ready(function($) {

            @if ($xPanel->export_buttons)
            var dtButtons = function(buttons){
                    var extended = [];
                    for(var i = 0; i < buttons.length; i++){
                        var item = {
                            extend: buttons[i],
                            exportOptions: {
                                columns: [':visible']
                            }
                        };
                        switch(buttons[i]){
                            case 'pdfHtml5':
                                item.orientation = 'landscape';
                                break;
                        }
                        extended.push(item);
                    }
                    return extended;
                }
            @endif

            var table = $("#crudTable").DataTable({
                    "pageLength": {{ $xPanel->getDefaultPageLength() }},
					"lengthMenu": [[10, 25, 50, 100, 250, 500], [10, 25, 50, 100, 250, 500]],
					/* Disable initial sort */
					"aaSorting": [],
                    "language": {
                        "emptyTable":     "{{ trans('admin::messages.emptyTable') }}",
                        "info":           "{{ trans('admin::messages.info') }}",
                        "infoEmpty":      "{{ trans('admin::messages.infoEmpty') }}",
                        "infoFiltered":   "{{ trans('admin::messages.infoFiltered') }}",
                        "infoPostFix":    "{{ trans('admin::messages.infoPostFix') }}",
                        "thousands":      "{{ trans('admin::messages.thousands') }}",
                        "lengthMenu":     "{{ trans('admin::messages.lengthMenu') }}",
                        "loadingRecords": "{{ trans('admin::messages.loadingRecords') }}",
                        "processing":     "{{ trans('admin::messages.processing') }}",
                        "search":         "{{ trans('admin::messages.search') }}",
                        "zeroRecords":    "{{ trans('admin::messages.zeroRecords') }}",
                        "paginate": {
                            "first":      "{{ trans('admin::messages.paginate_first') }}",
                            "last":       "{{ trans('admin::messages.paginate_last') }}",
                            "next":       "{{ trans('admin::messages.paginate_next') }}",
                            "previous":   "{{ trans('admin::messages.paginate_previous') }}"
                        },
                        "aria": {
                            "sortAscending":  "{{ trans('admin::messages.aria_sortAscending') }}",
                            "sortDescending": "{{ trans('admin::messages.aria_sortDescending') }}"
                        }
                    },

                    @if ($xPanel->ajax_table)
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        "url": "{{ url($xPanel->route.'/search').'?'.Request::getQueryString() }}",
                        "type": "POST"
                    },
                    @endif

                    @if ($xPanel->export_buttons)
                    // show the export datatable buttons
                    dom: '<"p-l-0 col-md-6"l>B<"p-r-0 col-md-6"f>rt<"col-md-6 p-l-0"i><"col-md-6 p-r-0"p>',
                    buttons: dtButtons([
                        'copyHtml5',
                        'excelHtml5',
                        'csvHtml5',
                        'pdfHtml5',
                        'print',
                        'colvis'
                    ]),
                    @endif
                });

            @if ($xPanel->export_buttons)
            // move the datatable buttons in the top-right corner and make them smaller
            table.buttons().each(function(button) {
                if (button.node.className.indexOf('buttons-columnVisibility') == -1)
                {
                    button.node.className = button.node.className + " btn-sm";
                }
            });
            $(".dt-buttons").appendTo($('#datatable_button_stack' ));
            @endif

            $.ajaxPrefilter(function(options, originalOptions, xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');

                if (token) {
                    return xhr.setRequestHeader('X-XSRF-TOKEN', token);
                }
            });

            // make the delete button work in the first result page
            register_delete_button_action();

            // make the delete button work on subsequent result pages
            $('#crudTable').on('draw.dt', function () {
                register_delete_button_action();

                @if ($xPanel->details_row)
                 register_details_row_button_action();
                @endif
            }).dataTable();

            function register_delete_button_action() {
                $("[data-button-type=delete]").unbind('click');
                // CRUD Delete
                // ask for confirmation before deleting an item
                $("[data-button-type=delete]").click(function(e) {
                    e.preventDefault();
                    var delete_button = $(this);
                    var delete_url = $(this).attr('href');

                    if (confirm("{{ trans('admin::messages.delete_confirm') }}") == true) {
                        $.ajax({
                            url: delete_url,
                            type: 'DELETE',
                            success: function(result) {
                                // Show an alert with the result
                                new PNotify({
                                    title: "{{ trans('admin::messages.delete_confirmation_title') }}",
                                    text: "{{ trans('admin::messages.delete_confirmation_message') }}",
                                    type: "success"
                                });
                                // delete the row from the table
                                delete_button.parentsUntil('tr').parent().remove();
                            },
                            error: function(result) {
                                // Show an alert with the result
                                new PNotify({
                                    title: "{{ trans('admin::messages.delete_confirmation_not_title') }}",
                                    text: "{{ trans('admin::messages.delete_confirmation_not_message') }}",
                                    type: "warning"
                                });
                            }
                        });
                    } else {
                        new PNotify({
                            title: "{{ trans('admin::messages.delete_confirmation_not_deleted_title') }}",
                            text: "{{ trans('admin::messages.delete_confirmation_not_deleted_message') }}",
                            type: "info"
                        });
                    }
                });
            }


            @if ($xPanel->details_row)
            function register_details_row_button_action() {
                // Add event listener for opening and closing details
                $('#crudTable tbody').on('click', 'td .details-row-button', function () {
                    var tr = $(this).closest('tr');
                    var btn = $(this);
                    var row = table.row( tr );

                    if ( row.child.isShown() ) {
                        // This row is already open - close it
                        $(this).removeClass('fa-minus-square-o').addClass('fa-plus-square-o');
                        $('div.table_row_slider', row.child()).slideUp( function () {
                            row.child.hide();
                            tr.removeClass('shown');
                        } );
                    }
                    else {
                        // Open this row
                        $(this).removeClass('fa-plus-square-o').addClass('fa-minus-square-o');
                        // Get the details with ajax
                        $.ajax({
                            url: '{{ Request::url() }}/'+btn.data('entry-id')+'/details',
                            type: 'GET',
                            // dataType: 'default: Intelligent Guess (Other values: xml, json, script, or html)',
                            // data: {param1: 'value1'},
                        })
                            .done(function(data) {
                                // console.log("-- success getting table extra details row with AJAX");
                                row.child("<div class='table_row_slider'>" + data + "</div>", 'no-padding').show();
                                tr.addClass('shown');
                                $('div.table_row_slider', row.child()).slideDown();
                                register_delete_button_action();
                            })
                            .fail(function(data) {
                                // console.log("-- error getting table extra details row with AJAX");
                                row.child("<div class='table_row_slider'>{{ trans('admin::messages.details_row_loading_error') }}</div>").show();
                                tr.addClass('shown');
                                $('div.table_row_slider', row.child()).slideDown();
                            })
                            .always(function(data) {
                                // console.log("-- complete getting table extra details row with AJAX");
                            });
                    }
                } );
            }

            register_details_row_button_action();
            @endif

        });
    </script>

    <!-- CRUD LIST CONTENT - crud_list_scripts stack -->
    @stack('crud_list_scripts')
@endsection