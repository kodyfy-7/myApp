@extends('sysStudent.layouts.app')

@section('content')

<div class="">
        <div class="page-title">
          <div class="title_left">
            <h3>Assignments</h3>
          </div>

          <div class="title_right">
            <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
              <div class="input-group">
              </div>
            </div>
          </div>
        </div>
        <div class="clearfix"></div>

        <div class="row">

            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>All Assignments</h2>
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
                            <th>Subject</th>
                            <th>Topic</th>
                            <th>Instruction</th>
                            <th>Action</th>
                      </tr>
                    </thead>
                  </table>
                </div>

                <div class="modal fade bs-example-modal-sm" id="formModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                  <div class="modal-dialog">
                    <div class="modal-content">

                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel2">Modal title</h4>
                      </div>
                      {!! Form::open(['id' => 'data_form', 'method' =>'POST', 'enctype' => 'multipart/form-data']) !!}
                        <div class="modal-body">
                            <p class="text-muted font-13 m-b-30"><span id="form_result"></span></p> 
                            <div class="form-group">
                                {{Form::label('topic', 'Topic')}}
                                {{Form::text('topic','', ['id' => 'topic', 'class' => 'form-control', 'disabled' => true])}}   
                                                   
                            </div>
                            <div class="form-group">
                                {{Form::file('adfile')}}
                            </div> 
                        </div>
                      <div class="modal-footer">
                        <div class="col-md-12">
                          {{Form::hidden('action', '', ['id' => 'action', 'class' => 'form-control'])}}
                          {{Form::hidden('hidden_id', '', ['id' => 'hidden_id', 'class' => 'form-control'])}}
                          {{Form::submit('Submit', ['id' => 'action_button', 'class' => 'btn btn-success btn-block'])}}
                        </div>              
                      </div>
                      {!! Form::close() !!}
                    </div>
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
    <script src="{{asset('library/plugins/js/datatables/dataTables.fixedHeader.min.j')}}s"></script>
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
                url: "{{ route('my-assignment.index') }}",
                },
                columns:[
                    /*{data: 'DT_RowIndex', name: 'DT_RowIndex'},*/
                
                    {
                        data: 'subject_title',
                        name: 'subjects.subject_title',
                        orderable: false
                    },
                    {
                        data: 'topic',
                        name: 'assignments.topic',
                        orderable: false
                    },
                    {
                        data: 'description',
                        name: 'assignments.description',
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
                $('.modal-title').text("Add a new assignment");
                $('#action_button').val("Add");
                $('#action').val("Add");
                $('#formModal').modal('show');
            });

            $('#data_form').on('submit', function(event){
                event.preventDefault();
                if($('#action').val() == 'Add') {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url:"{{ route('my-assignment.store') }}",
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
                                 
                                $('#datatable').DataTable().ajax.reload();
                            }
                        }
                    })
                }
                
                if($('#action').val() == "Edit") {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url:"{{ route('my-assignment.update') }}",
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
                            }
                            if(data.success) {
                                html = '<div class="alert alert-success">' + data.success + '</div>';
                                $('#data_form')[0].reset();
                                $('#action_button').val('Successful');
                                $('#action_button').attr('disabled', false);
                                $('#form_result').fadeIn().html(html);
                                $('#datatable').DataTable().ajax.reload();
                            }
                            $('#form_result').fadeIn().html(html);
                        }
                    });
                    }
                });
                
                $(document).on('click', '.edit', function(){
                    var id = $(this).attr('id');
                    $('#form_result').html('');
                    $.ajax({
                        url:"my-assignment/"+id+"/edit",
                        dataType:"json",
                        success:function(html){
                            $('#topic').val(html.data.topic);                            
                            $('#hidden_id').val(html.data.id);
                            $('.modal-title').text("Edit assignment");
                            $('#action_button').val("Update");
                            $('#action').val("Edit");
                            $('#formModal').modal('show');
                        }
                    })
                });
                
                var data_id;
                
                $(document).on('click', '.delete', function(){
                    data_id = $(this).attr('id');
                    $('#confirmModal').modal('show');
                });
                
                $('#ok_button').click(function(){
                    $.ajax({
                    url:"student-assignments/destroy/"+data_id,
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