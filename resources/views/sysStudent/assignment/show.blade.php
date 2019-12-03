@extends('sysTeacher.layouts.app')

@section('content')

<div class="">
        <div class="page-title">
          <div class="title_left">
            <h3>Results</h3>
          </div>

          <div class="title_right">
            <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
              <div class="input-group">
                <button type="button" name="create_record" id="create_record" class="btn btn-primary btn-block">Current Session</button>
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
                  @if(!empty($details))
                    
                            <div class="table-responsive">
                                <table class="table table-bordered" id="datatable">
                                    <thead>
                                        <tr>
                                            <th>Subject</th>
                                            <th>Ca</th>
                                            <th>Exam</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($details as $detail)
                                                       
                                            <tr colspan="2">
                                                <td>{{$detail->title}}</td>
                                                <td>{{$detail->ca1}}</td>
                                                <td>{{$detail->exam}}</td>
                                                <td>{{$detail->total}}</td>
                                            </tr>    
                                                                        
                                        @endforeach

                                        <tr >
                                            <td colspan="4">Total Score: {{$sum}}</td>
                                        </tr>

                                        <tr >
                                            <td colspan="4">Average Score: {{$avg}}</td>
                                        </tr>
    
                                            
                                    </tbody>
                                    <tfoot>
                                        
                                    </tfoot>
                                </table>
                            </div>
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
    
    
@endsection