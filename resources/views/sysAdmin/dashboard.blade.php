@extends('sysAdmin.layouts.app')

@section('content')

                <!-- top tiles -->
                <div class="row tile_count">
                    <div class="animated flipInY col-md-4 col-sm-6 col-xs-12 tile_stats_count">
                    <div class="left"></div>
                    <div class="right">
                        <span class="count_top"><i class="fa fa-calendar"></i> Session</span>
                        <div class="count">{{$session}}</div>
                        <span class="count_bottom"><i class="green">{{$term}}</i> term</span>
                    </div>
                    </div>
                    <div class="animated flipInY col-md-4 col-sm-6 col-xs-12 tile_stats_count">
                    <div class="left"></div>
                    <div class="right">
                        <span class="count_top"><i class="fa fa-user"></i> Employees</span>
                        <div class="count">{{App\Employee::count()}}</div>
                    </div>
                    </div>
                    <div class="animated flipInY col-md-4 col-sm-6 col-xs-12 tile_stats_count">
                    <div class="left"></div>
                    <div class="right">
                        <span class="count_top"><i class="fa fa-users"></i> Students</span>
                        <div class="count">{{App\Student::count()}}</div>
                    </div>
                    </div>        
                </div>
              <!-- /top tiles -->
              <div class="clearfix"></div>

        <div class="row">

            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Session | Term Controller</h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a href="#"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                      <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Settings 1</a>
                        </li>
                        <li><a href="#">Settings 2</a>
                        </li>
                      </ul>
                    </li>
                    <li><a href="#"><i class="fa fa-close"></i></a>
                    </li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <div id="message"></div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="data_table" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                   <th>Start Year</th>
                                   <th>End Year</th>
                                   <th>Term</th>
                                   <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                             
                            </tbody>
                        </table>
                        {{ csrf_field() }}
                    </div>
                </div>
              </div>
            </div>
        </div>
@endsection


@section('datatable')
    <!-- Datatables-->
    <script src="{{asset('library/plugins/js/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('library/plugins/js/datatables/dataTables.bootstrap.js')}}"></script>
    <script src="{{asset('library/plugins/js/datatables/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('library/plugins/js/datatables/buttons.bootstrap.min.js')}}"></script>
    <script src="{{asset('library/plugins/js/datatables/jszip.min.js')}}"></script>
    <script src="{{asset('library/plugins/js/datatables/pdfmake.min.js')}}"></script>
    <script src="{{asset('library/plugins/js/datatables/vfs_fonts.js')}}"></script>
    <script src="{{asset('library/plugins/js/datatables/buttons.html5.min.js')}}"></script>
    <script src="{{asset('library/plugins/js/datatables/buttons.print.min.js')}}"></script>
    <script src="{{asset('library/plugins/js/datatables/dataTables.fixedHeader.min.j')}}s"></script>
    <script src="{{asset('library/plugins/js/datatables/dataTables.keyTable.min.js')}}"></script>
    <script src="{{asset('library/plugins/js/datatables/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('library/plugins/js/datatables/responsive.bootstrap.min.js')}}"></script>
    <script src="{{asset('library/plugins/js/datatables/dataTables.scroller.min.js')}}"></script>


    <!-- pace -->
    <script src="{{asset('library/plugins/js/pace/pace.min.js')}}"></script>
    <script>
        $(document).ready(function(){
        
         fetch_data();
        
         function fetch_data()
         {
          $.ajax({
           url:"{{ route('admin.fetch_data') }}",
           dataType:"json",
           success:function(data)
           {
            var html = '';
            html += '<tr>';
            html += '<td contenteditable id="start"></td>';
            html += '<td contenteditable id="end"></td>';
            html += '<td contenteditable id="term"></td>';
            html += '<td><button type="button" class="btn btn-success btn-xs" id="add">Add</button></td></tr>';
            for(var count=0; count < data.length; count++)
            {
             html +='<tr>';
             html +='<td contenteditable class="column_name" data-column_name="start" data-id="'+data[count].id+'">'+data[count].start+'</td>';
             html += '<td contenteditable class="column_name" data-column_name="end" data-id="'+data[count].id+'">'+data[count].end+'</td>';
             html += '<td contenteditable class="column_name" data-column_name="term" data-id="'+data[count].id+'">'+data[count].term+'</td>';
             html += '<td><button type="button" class="btn btn-danger btn-xs delete" id="'+data[count].id+'">Delete</button></td></tr>';
            }
            $('tbody').html(html);
           }
          });
         }
        
        var _token = $('input[name="_token"]').val();

        $(document).on('click', '#add', function(){
        var start = $('#start').text();
        var end = $('#end').text();
        var term = $('#term').text();
        if(start != '' && end != '' && term != '')
        {
        $.ajax({
        url:"{{ route('admin.add_data') }}",
        method:"POST",
        data:{start:start, end:end, term:term, _token:_token},
        success:function(data)
        {
            $('#message').html(data);
            fetch_data();
        }
        });
        }
        else
        {
        $('#message').html("<div class='alert alert-danger'>Both Fields are required</div>");
        }
        });
        
         $(document).on('blur', '.column_name', function(){
          var column_name = $(this).data("column_name");
          var column_value = $(this).text();
          var id = $(this).data("id");
          
          if(column_value != '')
          {
           $.ajax({
            url:"{{ route('admin.update_data') }}",
            method:"POST",
            data:{column_name:column_name, column_value:column_value, id:id, _token:_token},
            success:function(data)
            {
             $('#message').html(data);
            }
           })
          }
          else
          {
           $('#message').html("<div class='alert alert-danger'>Enter some value</div>");
          }
         });
        
         $(document).on('click', '.delete', function(){
          var id = $(this).attr("id");
          if(confirm("Are you sure you want to delete this records?"))
          {
           $.ajax({
            url:"{{ route('admin.delete_data') }}",
            method:"POST",
            data:{id:id, _token:_token},
            success:function(data)
            {
             $('#message').html(data);
             fetch_data();
            }
           });
          }
         });
        
        
        });
        </script>
    <script>
      var handleDataTableButtons = function() {
          "use strict";
          0 !== $("#datatable-buttons").length && $("#datatable-buttons").DataTable({
            dom: "Bfrtip",
            buttons: [{
              extend: "copy",
              className: "btn-sm"
            }, {
              extend: "csv",
              className: "btn-sm"
            }, {
              extend: "excel",
              className: "btn-sm"
            }, {
              extend: "pdf",
              className: "btn-sm"
            }, {
              extend: "print",
              className: "btn-sm"
            }],
            responsive: !0
          })
        },
        TableManageButtons = function() {
          "use strict";
          return {
            init: function() {
              handleDataTableButtons()
            }
          }
        }();
    </script>
    <script type="text/javascript">
      $(document).ready(function() {
        $('#datatable-keytable').DataTable({
          keys: true
        });
        $('#datatable-responsive').DataTable();
        $('#datatable-scroller').DataTable({
          ajax: "js/datatables/json/scroller-demo.json",
          deferRender: true,
          scrollY: 380,
          scrollCollapse: true,
          scroller: true
        });
        var table = $('#datatable-fixed-header').DataTable({
          fixedHeader: true
        });
      });
      TableManageButtons.init();
    </script>
@endsection

