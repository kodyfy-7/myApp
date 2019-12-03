<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classroom;
use App\Subject;
use App\Employee;
use App\Student;
use App\ClassroomSubject;
use App\SessionTerm;
use App\Result;
use App\ResultDetail;
use Validator;
use Auth;
use DB;


class StudentResultController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:teacher');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user()->employee_id;
            $classroom = Employee::find($user)->classroom;
            $session_term = DB::table('session_term')->find(1);
            $start = $session_term->start;
            $end= $session_term->end;
            $session = $start ."/". $end;
            $term = $session_term->term;
        if(request()->ajax())
        {
            
            //$students = Result::latest()->get();
            $students = DB::table('results')->join('classrooms', 'classrooms.id', '=', 'results.classroom_id')->join('students', 'students.id', '=', 'results.student_id')->where('results.session', '=', $session)->where('results.term', '=', $term)->where('results.classroom_id', '=', $classroom->id)->select('results.id', 'results.rstatus', 'classrooms.title', 'students.name');
                return datatables()->of($students) 
                    ->addIndexColumn()
                    ->addColumn('status', function($data){                        
                        if($data->rstatus =='1'){
                            $status= '<span class="badge badge-success">Set</span>';
                        }elseif ($data->rstatus == '0'){
                            $status= '<span class="badge badge-secondary">Not Set</span>';
                        }
                        
                        return $status;
                    })
                    ->addColumn('action', function($data){                        
                        $button = '<a class="dropdown-item" href="/teacher/student-results/'.$data->id.'">Enter Result</a>';
                        
                        return $button;
                    })
                    ->rawColumns(['action', 'status'])
                    ->make(true);            
        }
        return view('sysTeacher.results.index', compact('user', 'classroom'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        for($count=0; $count<$request->total_subject; $count++) {
                      
            $form_data = array('subject_id' => $request->subject_title[$count], 'ca1' => $request->first_ca_score[$count], 'exam' => $request->exam_score[$count], 'total' => $request->total_scores[$count], 'result_id' => $request->hidden_id);
             $save = ResultDetail::create($form_data);

             

                /*$results = DB::table('result_details')->where('result_id', $request->result_id[$count])->where('subject_id', $request->subject_id)->get();
            foreach($results as $result){
                $ca = $result->ca1;
            }*/
        }
        $ovrScore = 0;
        $ovrScore = $ovrScore + floatval(trim($request->overall_total));

        $resultAverage = $ovrScore / floatval(trim($request->total_subject));  
        $form_data = array('total' => $request->overall_total, 'average' => $resultAverage, 'rstatus' => 1);
        $sa = Result::whereId($request->hidden_id)->update($form_data);
        
        return redirect('/teacher/student-results')->with('success', 'details has been saved successfully');
        //return response()->json(['success' =>  ' details has been saved successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::user()->employee_id;
        $classroom = Employee::find($user)->classroom;
        $session_term = DB::table('session_term')->find(1);
        $start = $session_term->start;
        $end= $session_term->end;
        $session = $start ."/". $end;
        $term = $session_term->term;

        //$classroom_subjects = Classroom::find($classroom->id)->subjects;
        $classroom_subjects = DB::table('classroom_subjects')->join('classrooms', 'classrooms.id', '=', 'classroom_subjects.classroom_id')->join('subjects', 'subjects.id', '=', 'classroom_subjects.subject_id')->where('classroom_subjects.classroom_id', '=', $classroom->id)->select('subjects.id', 'subjects.subject_title')->get();
        $subs = Subject::all();
        $student = Result::find($id)->student;
        return view('sysTeacher.results.show', compact('id', 'classroom', 'student', 'session', 'term', 'classroom_subjects', 'subs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
