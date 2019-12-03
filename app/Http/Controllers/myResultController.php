<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\Classroom;
use App\SessionTerm;
use App\Result;
use App\ResultDetail;
use App\Subject;
use Auth;
use DB;
use PDF;

class myResultController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:student');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user()->student_id;
        $class_id = Student::find($user)->classroom_id;
        $class = Classroom::find($class_id);
        /*$subjects = Employee::find($user)->subjects;*/
        $session_year = SessionTerm::find(1);
        $start = $session_year->start;
        $end= $session_year->end;
        $session = $start ."/". $end;
        $term = $session_year->term;

        //$results = DB::table('results')->where('results.student_id', '=', $user)->get();
        $results = DB::table('results')->join('classrooms', 'classrooms.id', '=', 'results.classroom_id')->where('results.student_id', '=', $user)->select('results.id','results.session', 'results.term', 'classrooms.title')->get();
        /*if(request()->ajax())
        {
            $results = DB::table('results')->join('classrooms', 'classrooms.id', '=', 'results.classroom_id')->where('results.student_id', '=', $user)->select('results.id','results.session', 'results.term', 'classrooms.title');
                return datatables()->of($results) 
                    ->addIndexColumn()
                    ->addColumn('action', function($data){                        
                        $button = '<a href="/student/my-result/'.$data->id.'" class="btn btn-secondary">View Result</a>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<a href="/student/my-result/'.$data->id.'" class="btn btn-success"> Download</a>';                       
                        
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);            
        }*/
        
        
        return view('sysStudent.result.index', compact('user', 'class', 'session', 'term', 'results'));
    }

    public function show($id)
    {
        /*$result_data = DB::table('result_details')->join('subjects', 'subjects.id', '=', 'result_details.subject_id')->join('results', 'results.id', '=', 'result_details.result_id')->where('results.id', '=', $id)->select('subjects.subject_title','result_details.ca1', 'result_details.exam', 'result_details.total')->get();*/

        $result_data = DB::table('result_details')->join('subjects', 'subjects.id', '=', 'result_details.subject_id')->join('results', 'results.id', '=', 'result_details.result_id')->where('results.id', '=', $id)->select(['result_details.id', 'result_details.subject_id','subjects.subject_title','result_details.ca1', 'result_details.exam', 'result_details.total',

            DB::raw("(ca1+exam) as total")
        ])->get();

        //$result_data = ResultDetail::find($id);


        
        /*foreach($result_data as $data){
            for($i=0; $i<$data->subject_title; $i++){
                $r = $data->ca1 + $data->exam;
                return $r;
            }
            
        }*/

        //$sum = DB::table('result_details')->where('result_id', $id)->sum('total');
        //$avg = DB::table('result_details')->where('result_id', $id)->avg('total');
        return view('sysStudent.result.show', compact('result_data'));
    }

    public function get_result_data($id)
    {
        $result_data = DB::table('result_details')->join('subjects', 'subjects.id', '=', 'result_details.subject_id')->join('results', 'results.id', '=', 'result_details.result_id')->where('results.id', '=', $id)->select('result_details.result_id', 'subjects.subject_title','result_details.ca1', 'result_details.exam', 'result_details.total')->get();

        $sum = DB::table('result_details')->where('result_id', $id)->sum('total');
        $avg = DB::table('result_details')->where('result_id', $id)->avg('total');

        
        return $result_data;
    }

    /*function pdf(){
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->convert_result_data_to_html($id));
        $pdf->stream();
    }

    function convert_result_data_to_html($id)
    {
        $result_data = $this->get_result_data();
        $output = '
                <h3>Result</h3>
                <table class="table table-bordered" id="datatable">
                                   
                                        <tr>
                                            <th>Subject</th>
                                            <th>Ca</th>
                                            <th>Exam</th>
                                            <th></th>
                                            <th>Total</th>
                                        </tr>
                                    
        
        
        ';
        foreach($result_data as $result)
        {
            $output .= '
                    <tr colspan="2">
                    <td>'.$result->subject_title.'</td>
                    <td>'.$result->ca1.'</td>
                    <td>'.$result->exam.'</td>
                    <td></td>
                    <td>'.$result->ca1 + $result->exam.'</td>
                </tr>           
            
            
            ';
        }
        $output .= '</table>';
        return $output;
    }*/

    public function downloadPDF($id){
        $user = Auth::user()->student_id;
        //$result = Result::find($id);
        $result = DB::table('results')->join('classrooms', 'classrooms.id', '=', 'results.classroom_id')->where('results.id', '=', $id)->where('results.student_id', '=', $user)->select('results.id','results.session', 'results.term', 'classrooms.title')->get(1);
        

        $result = DB::table('result_details')->join('subjects', 'subjects.id', '=', 'result_details.subject_id')->join('results', 'results.id', '=', 'result_details.result_id')->where('results.id', '=', $id)->select(['result_details.id', 'result_details.subject_id','subjects.subject_title','result_details.ca1', 'result_details.exam', 'result_details.total',

            DB::raw("(ca1+exam) as total")
        ])->get();
  
        $pdf = PDF::loadView('sysStudent.result.pdf', compact('result'));
        return $pdf->download('result.pdf');
  
      }
    
}
