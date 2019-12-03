@extends('sysTeacher.layouts.app')

@section('content')

<div class="">
        <div class="page-title">
          <div class="title_left">
            <h3>Examination</h3>
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
                  <h2></h2>
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
                    @if(!empty($classrooms))
                        <div class="dropdown dropright">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Select Class</button>
                            <div class="dropdown-menu">
                    
                                @forelse($classrooms as $classroom)
                                        <a class="dropdown-item" href="/teacher/exam/{{$classroom->id}}">{{$classroom->title}}</a>
                                        
                                    @empty
                                        <div class="col-md-12"><p>No data</p></div>
                                @endforelse
                            </div>
                        </div>
                    @endif

                @if(!empty($students))
                    {!! Form::open([ 'id' => 'data_form', 'method' =>'POST']) !!}
                    <p class="text-muted font-13 m-b-30"><span id="form_result"></span></p>  
                      <div class="form-group">
                          <select name="subject_id" class="form-control" id="subject_id">
                              <option value="">Select subject</option>
                              @foreach($subjects as $subject)
                                  <option value="{{$subject->id}}">{{$subject->subject_title}}</small>
                                  </option>
                              @endforeach
                          </select>    
                      </div>  
                      <table class="table table-bordered" id="data_table">
                          <thead>
                              <tr>
                                  <th>Student</th>
                                  <th>Score</th>
                              </tr>
                          </thead>
                          <tbody>
                              @foreach ($students as $student)
                                  <tr>
                                  <td><input type="text" value="{{$student->name}}" class="form-control" disabled><input name="student_id[]" type="hidden" value="{{$student->id}}"></td>
                                      <td>{{Form::text('score[]', '', ['id' => 'score', 'class' => 'form-control'])}}{{Form::hidden('classroom_id[]', $id, ['id' => 'classroom_id', 'class' => 'form-control'])}}</td>
                                  </tr>                                                  
                              @endforeach
                          </tbody>
                      </table>
                      <div class="col-md-8 offset-2">
                          {{Form::hidden('action', '', ['id' => 'action', 'class' => 'form-control'])}}
                          
                          <input type="hidden" name="total_item" id="total_item" value="{{$studentNum}}" />
                          {{Form::submit('Submit', ['id' => 'action_button', 'class' => 'btn btn-success btn-block'])}}
                      </div>                            
                  {!! Form::close() !!}
                @endif
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
                    url:"{{ route('exam.store') }}",
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
                            $('#action_button').attr('disabled', false);
                            $('#action_button').val('Submit');
                        }
                        if(data.success) {
                            html = '<div class="alert alert-success">' + data.success + '</div>';
                            $('#form_result').fadeIn().html(html);              
                            $('#action_button').attr('disabled', false);
                            $('#action_button').val('Submit');
                        }
                        
                    }
                });
        });


    </script>
@endsection