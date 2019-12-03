@extends('sysTeacher.layouts.app')

@section('title')
    Teacher | Results
@endsection

@section('content')

<div class="">
        <div class="page-title">
          <div class="title_left">
            <h3>Assignments</h3>
          </div>

          <div class="title_right">
            <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
              
            </div>
          </div>
        </div>
        <div class="clearfix"></div>

        <div class="row">

            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Add Score</h2>
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
                    {!! Form::open(['id' => 'data_form', 'method' =>'POST']) !!}
                        <p class="text-muted font-13 m-b-30"><span id="form_result"></span></p> 
                        <div class="form-group">
                            <input type="text" value="{{$assignment->topic}}" class="form-control" disabled>   <input type="hidden" name="assignment_id" id="assignment_id" value="{{$assignment->id}}" />
                        </div>  
                        <table class="table table-bordered" id="data_table">
                            <thead>
                                <tr>
                                    <th>Student</th>
                                    <th>File</th>
                                    <th>Score</th>
                                </tr>
                            </thead>
                            <tbody>                                   
                                @foreach ($details as $detail)              
                                    <tr>
                                        <td>{{$detail->name}}</td>
                                        <td>{{$detail->adfile}}</td>
                                        <td>{{Form::text('score[]', '', ['id' => 'score', 'class' => 'form-control'])}}<input type="hidden" name="assignment_id[]" id="assignment_id" value="{{$assignment->id}}" /></td>
                                            
                                    </tr>   
                                                                                        
                                @endforeach
                                    
                            </tbody>
                        </table>
                        <div class="col-md-12">
                            {{Form::hidden('action', '', ['id' => 'action', 'class' => 'form-control'])}}
                            <input type="hidden" name="total_item" id="total_item" value="{{$detailNum}}" />
                            {{Form::submit('Submit', ['id' => 'action_button', 'class' => 'btn btn-success btn-block'])}}
                        </div>                            
                    {!! Form::close() !!}
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
        $('#data_form').on('submit', function(event){
            event.preventDefault();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url:"{{ route('student-assignments.add_score') }}",
                    method:"POST",
                    data: new FormData(this),
                    contentType: false,
                    cache:false,
                    processData: false,
                    dataType:"json",
                    beforeSend:function() {
                        $('#action_button').val('Processing, please wait...');
                        $('#action_button').attr('disabled','disabled');
                    },
                    success:function(data){
                        var html = '';
                        if(data.errors) {
                            html = '<div class="alert alert-danger">';
                            for(var count = 0; count < data.errors.length; count++) {
                                html += '<p>' + data.errors[count] + '</p>';
                            }
                            html += '</div>';
                            $('#form_result').fadeIn().html(html);
                        }
                        if(data.success) {
                            html = '<div class="alert alert-success">' + data.success + '</div>';
                            $('#data_form')[0].reset(); 
                            $('#action_button').val('Add');
                            $('#action_button').attr('disabled', false);
                            $('#form_result').fadeIn().html(html);
                        }
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