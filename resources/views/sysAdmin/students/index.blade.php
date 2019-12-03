@extends('sysAdmin.layouts.app')

@section('content')

<div class="">
        <div class="page-title">
          <div class="title_left">
            <h3>Students</h3>
          </div>

          <div class="title_right">
            <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
              <div class="input-group">
                <button type="button" name="create_record" id="create_record" class="btn btn-primary btn-block">Add a new student</button>
              </div>
            </div>
          </div>
        </div>
        <div class="clearfix"></div>

        <div class="row">

            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>All Students</h2>
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
                  <table id="datatable" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                            <th>Student</th>
                            <th>Class</th>
                            <th>Payment</th>
                            <th>Action</th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
            </div>

            <div class="modal fade bs-example-modal-sm" id="studentModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                  <div class="modal-dialog">
                    <div class="modal-content">

                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel2">Modal title</h4>
                      </div>
                      {!! Form::open(['id' => 'data_student', 'method' =>'POST']) !!}
                        <div class="modal-body">
                                <p class="text-muted font-13 m-b-30"><span id="form_result"></span></p>
                                <div class="form-group">
                                {{Form::label('name', 'Student Name')}}
                                {{Form::text('name', '', ['id' => 'name', 'class' => 'form-control', ])}}
                                </div>
                                <div class="form-group">
                                    <label for="dob">Birthdate</label>
                                    <input id="dob" name="dob" class="date-picker form-control col-md-7 col-xs-12" required="required" type="text">
                                                       
                                </div><br><br>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Gender</label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <div id="gender" class="btn-group" data-toggle="buttons">
                                        <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                            <input type="radio" name="gender" value="Male"> &nbsp; Male &nbsp;
                                        </label>
                                        <label class="btn btn-primary active" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                            <input type="radio" name="gender" value="Female" checked=""> Female
                                        </label>
                                        </div>
                                    </div>                              
                                </div>
                                <div class="form-group">
                                        {{Form::label('classroom', 'Classroom')}}
                                        {{Form::select('classroom', App\Classroom::pluck('title', 'id'), '', ['id' => 'classroom', 'class' => 'form-control', 'placeholder' => 'Select Classroom'])}}                          
                                </div>
                        </div>
                        <div class="modal-footer">
                            <div class="col-md-12">
                                {{Form::hidden('student_action', '', ['id' => 'student_action', 'class' => 'form-control'])}}
                                {{Form::hidden('student_hidden_id', '', ['id' => 'student_hidden_id', 'class' => 'form-control'])}}
                                {{Form::submit('Submit', ['id' => 'student_action_button', 'class' => 'btn btn-success btn-block'])}}
                            </div>              
                        </div>
                      {!! Form::close() !!}
                    </div>
                  </div>
            </div>

            <div class="modal fade bs-example-modal-sm" id="formModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                  <div class="modal-dialog modal-sm">
                    <div class="modal-content">

                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel2">Modal title</h4>
                      </div>
                      {!! Form::open(['id' => 'data_form', 'method' =>'POST']) !!}
                        <div class="modal-body">
                                <p class="text-muted font-13 m-b-30"><span id="form_result"></span></p>
                            <div class="form-group">
                            {{Form::label('name', 'Student Name')}}
                            {{Form::text('name', '', ['id' => 'sname', 'class' => 'form-control', 'disabled' => true])}}
                        </div>
                        <div class="form-group">
                            {{Form::label('session', 'Session')}}
                            {{Form::text('session', '', ['id' => 'session', 'class' => 'form-control', 'disabled' => true])}}                          
                        </div>
                        <div class="form-group">
                            {{Form::label('term', 'Term')}}
                            {{Form::text('term', '', ['id' => 'term', 'class' => 'form-control', 'disabled' => true])}}                          
                        </div>
                        <div class="form-group">
                            {{Form::label('amount', 'Amount')}}
                            {{Form::text('amount', '', ['id' => 'amount', 'class' => 'form-control', 'placeholder' => ''])}}                          
                        </div>
                        <div class="modal-footer">
                            <div class="col-md-12">
                                {{Form::hidden('action', '', ['id' => 'action', 'class' => 'form-control', 'value' => 'Pay'])}}
                                {{Form::hidden('hidden_id', '', ['id' => 'hidden_id', 'class' => 'form-control'])}}
                                {{Form::submit('Submit', ['id' => 'action_button', 'class' => 'btn btn-success btn-block'])}}
                            </div>              
                        </div>
                      {!! Form::close() !!}
                    </div>
                  </div>
            </div>

            <div class="modal fade bs-example-modal-sm" id="viewModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">

                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                            </button>
                            <h4 class="modal-title" id="myModalLabel2">Modal title</h4>
                        </div>
                      
                        <div class="modal-body">
                            <div ><p class="name"></p></div>
                            <div ><p id="dob"></p></div>
                            <div ><p id="gender"></p></div>
                        </div>
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
    <script src="{{asset('library/plugins/js/datatables/dataTables.fixedHeader.min.js')}}"></script>
    <script src="{{asset('library/plugins/js/datatables/dataTables.keyTable.min.js')}}"></script>
    <script src="{{asset('library/plugins/js/datatables/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('library/plugins/js/datatables/responsive.bootstrap.min.js')}}"></script>
    <script src="{{asset('library/plugins/js/datatables/dataTables.scroller.min.js')}}"></script>


    <!-- pace -->
    <script src="{{asset('library/plugins/js/pace/pace.min.js')}}"></script>
    <script>
      $(document).ready(function(){        
        $('#datatable').DataTable({
          processing: true,
          serverSide: true,
          ajax:{
                  url: "{{ route('students.index') }}",
               },
          columns:[
                   /*{data: 'DT_RowIndex', name: 'DT_RowIndex'},*/
                
                    {
                        data: 'name',
                        name: 'students.name',
                        orderable: false
                    },
                    {
                        data: 'title',
                        name: 'classrooms.title',
                        orderable: false
                    },
                    {
                        data: 'pstatus',
                        name: 'payments.pstatus',
                        orderable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    }
          ] 
        });     

        $('#create_record').click(function(){
          $('.modal-title').text("Add a new student");
          $('#action_button').val("Add");
          $('#action').val("Add");
          $('#studentModal').modal('show');
        });

        $('#data_form').on('submit', function(event){
          event.preventDefault();
          if($('#action').val() == 'Add') {

          }
                
          if($('#action').val() == "Pay") {
            $.ajax({
                    headers: {
                              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url:"{{ route('students.pay') }}",
                    method:"POST",
                    data:new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType:"json",
                    beforeSend:function() {
                                           $('#action_button').val('Processing, please wait...');
                                           $('#action_button').attr('disabled','disabled');
                    },
                    success:function(data) {
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
                                                //$('#amount')[3].reset();
                                                $('#action_button').val('Successful');
                                                $('#action_button').attr('disabled', false);
                                                $('#form_result').fadeIn().html(html);
                                                $('#datatable').DataTable().ajax.reload();
                                                
                    }
                  }
                });
              }
        });

            
                
          $(document).on('click', '.make-payment', function(){
            var id = $(this).attr('id');
            $('#form_result').html('');
            $.ajax({
                      url:"students/"+id+"/make-payment",
                      dataType:"json",
                      success:function(html){
                                              $('#sname').val(html.student.name);
                                              $('#session').val(html.data.psession);
                                              $('#term').val(html.data.pterm);
                                              $('#hidden_id').val(html.data.id);
                                              $('.modal-title').text("Make Payment");
                                              $('#action_button').val("Pay");
                                              $('#action').val("Pay");
                                              $('#formModal').modal('show');
                      }
            })
          });

          $(document).on('click', '.view', function(){
            var id = $(this).attr('id');
            $.ajax({
                      url:"students/"+id+"/get-student",
                      dataType:"json",
                      success:function(html){
                            $('.name').text(html.data.name);
                            $('#dob').text(html.data.dob);
                            $('#gender').text(html.data.gender);
                            $('.modal-title').text("View Student");
                            $('#viewModal').modal('show');
                        }
                    })
          });
                
                var data_id;
                
                /*$(document).on('click', '.delete', function(){
                    data_id = $(this).attr('id');
                    $('#confirmModal').modal('show');
                });
                
                $('#ok_button').click(function(){
                    $.ajax({
                    url:"subjects/destroy/"+data_id,
                    beforeSend:function(){
                        $('#ok_button').text('Deleting...');
                    },
                    success:function(data)
                    {
                        setTimeout(function(){
                        $('#confirmModal').modal('hide');
                        $('#datatable').DataTable().ajax.reload();
                        }, 2000);
                    }
                })
                });*/

        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
          $('#dob').daterangepicker({
            singleDatePicker: true,
            calender_style: "picker_4"
          }, function(start, end, label) {
            console.log(start.toISOString(), end.toISOString(), label);
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