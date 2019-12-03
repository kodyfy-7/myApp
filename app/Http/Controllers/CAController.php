<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classroom;
use App\Subject;
use App\Employee;
use App\Student;
use App\ClassroomSubject;
use App\ContinousAssessment;
use App\SessionTerm;
use App\Result;
use App\ResultDetail;
use Validator;
use Auth;
use DB;

class CaController extends Controller
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
        /*$user = Auth::user()->employee_id;
        $subjects = Employee::find($user)->subjects;*/

        $classrooms = Classroom::all();
        return view('sysTeacher.ca.index',  compact('classrooms'));
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
        
        /*foreach($request->student_id as $key=>$request->student_id) {
            $form_data1 = array('student_id' => $request->student_id[$key], 'classroom_id' => $request->classroom_id[$key]);

            $save1 = Result::create($form_data1);
        }*/
        for($count=0; $count<$request->total_item; $count++/*$ii = 0; $ii < count($request->student_id); $ii++*/) {
            /*$form_data1 = array('student_id' => $request->student_id[$count], 'classroom_id' => $request->classroom_id[$count]);

            $save1 = Result::create($form_data1);
            */
            $session_year = SessionTerm::find(1);
            $start = $session_year->start;
            $end= $session_year->end;
            $session = $start ."/". $end;
            $term = $session_year->term;
            $form_data =  array('result_id' => $request->result_id[$count], 'subject_id' => $request->subject_id, 'ca1' => $request->score[$count], 'total' => $request->score[$count]);

            //$save2 = ResultDetail::create($form_data);
            $save = ResultDetail::updateOrCreate(['result_id'=> $request->result_id[$count], 'subject_id'=> $request->subject_id], ['result_id' => $request->result_id[$count], 'subject_id' => $request->subject_id, 'ca1' => $request->score[$count], 'total' => $request->score[$count]]);
        }
        /*for($count = 0; $count < $request->student_id; $count++){
            $form_data1 = array('student_id' => $request->student_id[$count], 'classroom_id' => $request->classroom_id[$count]);

            $save1 = Result::create($form_data1);
        }*/
        /*for($count = 0; $count<=$request->student_id; $count++){
            

            $form_data = array('result_id' => $save1->id, 'subject_id' => $request->subject_id, 'ca1' => $request->ca[$count], 'exam' => $request->exam[$count], 'total' => $request->total[$count]);

            $save2 = ResultDetail::create($form_data);
        }*/
        return response()->json(['success' => ' details has been saved successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //$i = $id;
        /*$classrooms = ClassroomSubject::findOrFail($id)->classrooms;
        $user = Auth::user()->employee_id;
        $subjects = Employee::find($user)->subjects;

        $classrooms = DB::table('classroom_subjects')->join('subjects', 'subjects.id', '=', 'classroom_subjects.subject_id')->join('classrooms', 'classrooms.id', '=', 'classroom_subjects.classroom_id')->where('subjects.id', '=', $i)->select( 'classrooms.title', 'classrooms.id');
        $classrooms = $classrooms->get();*/
        //$classroom = Classroom::findorFail($id)->classrooms;
        //$students = Classroom::find($id)->students;
        //$results = Student::find($students->id)->results;
        //$matchThese = ['session' => '2019/2020', 'term' => '1'];
        //$results = DB::table('results')->where('subject_id', '=', 1)->get();
        //$results = DB::table('results')->where([['session', '2019/2020'], ['term', '1']])->get();
        
        
        //$studentNum = count($students);
        //$user = Auth::user()->employee_id;
        //$subjects = Employee::find($user)->subjects;
        //return view('sysTeacher.ca.index', compact('classroom', 'students', 'id', 'subjects', 'studentNum'/*, 'results'*/));

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
        $results = Result::all();
        //$results = DB::table('results')->where([['session', '2019/2020'], ['term', '1']])->get();
        
        
        $studentNum = count($students);
        $user = Auth::user()->employee_id;
        $subjects = Employee::find($user)->subjects;
        return view('sysTeacher.ca.index', compact('classroom', 'students', 'id', 'subjects', 'studentNum', 'results'));
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
