<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classroom;
use App\Subject;
use App\Employee;
use App\Student;
use App\ClassroomSubject;
use App\Exam;
use App\SessionTerm;
use App\Result;
use App\ResultDetail;
use Validator;
use Auth;
use DB;
use PDF;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*$user = Auth::user()->employee_id;
        $subjects = Employee::find($user)->subjects;*/

        $students = Student::all();
        return view('test',  compact('students'));
    }

    public function downloadPDF($id){
        $student = Student::find($id);
        //$students = Student::all();
  
        $pdf = PDF::loadView('pdf', compact('student'));
        return $pdf->download('invoice.pdf');
  
      }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = array(
            'subject_id'    =>  'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        
        for($count=0; $count<$request->total_item; $count++) {
          /* 
            
            $form_data = array('exam' => $request->score[$count]);*/

            /*DB::table('result_details')
                ->where('result_id', $request->result_id[$count])->where('subject_id', $request->subject_id)
                ->update($form_data);*/
             $save = ResultDetail::updateOrCreate(['result_id'=> $request->result_id[$count], 'subject_id'=> $request->subject_id], ['result_id' => $request->result_id[$count], 'subject_id' => $request->subject_id, 'exam' => $request->score[$count]]);

             $ids = $save->id;
            /*$xc = $request->result_id[$count];
             for($count=0; $count<$request->total_item; $count++){
                $xxx= DB::table('result_details')
                ->where('result_id', $xc)->where('subject_id', $request->subject_id)->select('ca1')
                ->get();
             }*/
             

                /*$results = DB::table('result_details')->where('result_id', $request->result_id[$count])->where('subject_id', $request->subject_id)->get();
            foreach($results as $result){
                $ca = $result->ca1;
            }*/
        }
        
        return response()->json(['success' =>  ' details has been saved successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $i = $id;
        /*$classrooms = ClassroomSubject::findOrFail($id)->classrooms;
        $user = Auth::user()->employee_id;
        $subjects = Employee::find($user)->subjects;

        $classrooms = DB::table('classroom_subjects')->join('subjects', 'subjects.id', '=', 'classroom_subjects.subject_id')->join('classrooms', 'classrooms.id', '=', 'classroom_subjects.classroom_id')->where('subjects.id', '=', $i)->select( 'classrooms.title', 'classrooms.id');
        $classrooms = $classrooms->get();*/
        $classroom = Classroom::findorFail($id)->classrooms;
        $students = Classroom::find($id)->students;
        //$results = Student::find($students->id)->results;
        $matchThese = ['session' => '2019/2020', 'term' => '1'];

        $session_year = SessionTerm::find(1);
            $start = $session_year->start;
            $end= $session_year->end;
            $session = $start ."/". $end;
            $term = $session_year->term;
        
        $results = DB::table('results')->where([['session', $session], ['term', $term]])->get();
        
        
        $studentNum = count($students);
        $user = Auth::user()->employee_id;
        $subjects = Employee::find($user)->subjects;
        return view('sysTeacher.test.index', compact('classroom', 'students', 'id', 'subjects', 'studentNum', 'results'));
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
