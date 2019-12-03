@extends('sysTeacher.layouts.app')

@section('content')

<div class="">
        <div class="page-title">
          <div class="title_left">
            <h3>Result</h3>
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
                  <h2>{{$student->name}}</h2>
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
                    {!! Form::open(['action' => 'StudentResultController@store', 'id' => 'result_form', 'method' =>'POST']) !!}
                    <table class="table table-bordered">
                        
                                    <tr>
                                      <td colspan="2" align="center"><h2 style="margin-top:10.5px">Add Result</h2></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                          <div class="row">
                                            <div class="col-md-8">
                                                <input type="text" name="student" id="student" class="form-control input-sm" value="{{$student->name}}" readonly/>
                                                <input type="text" name="classroom" id="classroom" class="form-control input-sm" value="{{$classroom->title}}" readonly/>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" name="session" id="session" class="form-control input-sm" value="{{$session}}" readonly/>
                                                <input type="text" name="term" id="term" class="form-control input-sm" value="{{$term}}" readonly/>
                                            </div>
                                          </div>
                                          <br />
                                          <table id="result-subject-table" class="table table-bordered">
                                            <tr>
                                              <th width="7%">Sr No.</th>
                                              <th width="20%">Subject</th>
                                              <th width="5%">CA</th>
                                              <th width="5%">Exam</th>
                                              <th width="12.5%">Total</th>
                                              <th width="3%"></th>
                                            </tr>
                                            <tr>
                                              <td><span id="sr_no">1</span></td>
                                              <td>
                                                <select class="form-control" name="subject_title[]" id="subject_title1">
                                                        <option value="">Select Subject</option>
                                                        @foreach ($classroom_subjects as $subject)
                                                        <option value="{{$subject->id}}">{{$subject->subject_title}}</option>
                                                    @endforeach  
                                                </select>

                                              </td>
                                              <td><input type="text" name="first_ca_score[]" id="first_ca_score1" data-srno="1" class="form-control number_only input-sm first_ca_score" /></td>
                                              <td><input type="text" name="exam_score[]" id="exam_score1" data-srno="1" class="form-control input-sm number_only exam_score" /></td>
                                              <td><input type="text" name="total_scores[]" id="total_scores1" data-srno="1" readonly class="form-control input-sm total_scores" /></td>
                                              <td></td>
                                            </tr>
                                          </table>
                                          <div align="right">
                                            <button type="button" name="add_row" id="add_row" class="btn btn-success btn-xs">+</button>
                                          </div>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td align="right"><b>Total</td>
                                        <td align="right"><input type="text" id="overall_total" class="form-control" name="overall_total" readonly></td>
                                      </tr>
                                      <tr>
                                        <td colspan="2"></td>
                                      </tr>
                                      <tr>
                                        <td colspan="2" align="center">
                                          <input type="hidden" name="total_subject" id="total_subject" value="1" />
                                          <input type="hidden" name="hidden_id" id="hidden_id" value="{{$id}}" />
                                          <input type="submit" name="add_result" id="add_result" class="btn btn-info" value="Save" />
                                        </td>
                                      </tr>
                                  </table>
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
        $(document).ready(function(){
            var overall_total = $('#overall_total').val();
            var count = 1;
              
            $(document).on('click', '#add_row', function(){
                count++;
                $('#total_subject').val(count);
                var html_code = '';
                html_code += '<tr id="row_id_'+count+'">';
                html_code += '<td><span id="sr_no">'+count+'</span></td>';
                html_code += '<td><select class="form-control" name="subject_title[]" id="subject_title'+count+'"><option value="">Select Subject</option> @foreach ($classroom_subjects as $subject)<option value="{{$subject->id}}">{{$subject->subject_title}}</option> @endforeach </select></td>';
                html_code += '<td><input type="text" name="first_ca_score[]" id="first_ca_score'+count+'" data-srno="'+count+'" class="form-control input-sm number_only first_ca_score" /></td>';
                html_code += '<td><input type="text" name="exam_score[]" id="exam_score'+count+'" data-srno="'+count+'" class="form-control input-sm number_only exam_score" /></td>';
                html_code += '<td><input type="text" name="total_scores[]" id="total_scores'+count+'" data-srno="'+count+'" readonly class="form-control input-sm total_scores" /></td>';
                html_code += '<td><button type="button" name="remove_row" id="'+count+'" class="btn btn-danger btn-xs remove_row">X</button></td>';
                html_code += '</tr>';
                $('#result-subject-table').append(html_code);
            });
              
            $(document).on('click', '.remove_row', function(){
                var row_id = $(this).attr("id");
                var ovr_sco = $('#total_scores'+row_id).val();
                var total_score = $('#overall_total').val();
                var result_total = parseFloat(total_score) - parseFloat(ovr_sco);
                $('#overall_total').val(result_total);
                $('#row_id_'+row_id).remove();
                count--;
                $('#total_subject').val(count);
            });
      
            function cal_final_total(count) {
                var overallTotal = 0;
                for(j=1; j<=count; j++) {
                  var firstCaScore = 0;
                  var examScore = 0;
                  var totalScores = 0;
                  firstCaScore = $('#first_ca_score'+j).val();
                  if(firstCaScore > 0) {
                    examScore = $('#exam_score'+j).val();
                    if(examScore > 0) {
                      totalScores = parseFloat(firstCaScore) + parseFloat(examScore);
                      overallTotal = parseFloat(overallTotal) + parseFloat(totalScores);
                      $('#total_scores'+j).val(totalScores);
                    }
                  }
                }
                $('#overall_total').val(overallTotal);
            }
      
            $(document).on('blur', '.exam_score', function(){
                cal_final_total(count);
            });
      
            $('#add_result').click(function(){
                
                for(var no=1; no<=count; no++) {
                    if($.trim($('#subject_title'+no).val()).length == 0) {
                        alert("Please Enter Item Name");
                        $('#subject_title'+no).focus();
                        return false;
                    }
        
                    if($.trim($('#first_ca_score'+no).val()).length == 0) {
                        alert("Please Enter ca score");
                        $('#first_ca_score'+no).focus();
                        return false;
                    }
        
                    if($.trim($('#exam_score'+no).val()).length == 0){
                        alert("Please Enter examScore");
                        $('#exam_score'+no).focus();
                        return false;
                    }
        
                }
        
                $('"result_form').submit();
        
            });
      
         });
    </script>

    <script>
        $(document).ready(function(){
            $('.number_only').keypress(function(e){
            return isNumbers(e, this);      
            });
            function isNumbers(evt, element) 
            {
            var charCode = (evt.which) ? evt.which : event.keyCode;
            if (
            (charCode != 46 || $(element).val().indexOf('.') != -1) &&      // “.” CHECK DOT, AND ONLY ONE.
            (charCode < 48 || charCode > 57))
            return false;
            return true;
            }
        });
    </script>
    
@endsection