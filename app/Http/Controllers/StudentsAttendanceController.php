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
use App\StudentAttendance;
use Validator;
use Auth;
use DB;


class StudentsAttendanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:teacher');
    }

    /*public function class_teacher(Request $request) 
    {
        return view('middleware')->withMessage("Class Teacher");
    }*/

    

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
        if (Employee::find(Auth::user()->employee_id)->classroom = ''){
            return redirect('teacher/')->with('error', 'Post Created');
        }
							
	else{
        if(request()->ajax())
        {
            
            //$students = Result::latest()->get();
            $students = DB::table('students')->join('classrooms', 'classrooms.id', '=', 'students.classroom_id')->where('students.classroom_id', '=', $classroom->id)->select('students.id', 'students.id', 'classrooms.title', 'students.name');
                return datatables()->of($students) 
                    ->addIndexColumn()
                    ->addColumn('action', function($data){                        
                        $button = '<div id="attendance" class="btn-group" data-toggle="buttons">
                        <label class="btn btn-success" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                          <input required type="radio" name="attendance['.$data->id.']" value="Present"> &nbsp; Present &nbsp;
                        </label>
                        <label class="btn btn-danger" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                          <input required type="radio" name="attendance['.$data->id.']" value="Absent"> Absent
                        </label>
                      </div>';
                        
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);            
        }
        $user = Auth::user()->employee_id;
        $subjects = Employee::find($user)->subjects;
        $classroom = Employee::find($user)->classroom;
        if(empty($classroom)) {
            $class = ' ';
        } else {
            $class = $classroom->title;
        }
        return view('sysTeacher.attendance.index', compact('user', 'classroom', 'class'));
    }
	
        
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
        $user = Auth::user()->employee_id;
        $classroom = Employee::find($user)->classroom;
        $session_term = DB::table('session_term')->find(1);
        $start = $session_term->start;
        $end= $session_term->end;
        $session = $start ."/". $end;
        $term = $session_term->term;
        $attendanceStatus = $request->attendance;
        $attendanceDate = date('d-m-Y');
        $check = DB::table('student_attendance')->where('created_at', '=', $attendanceDate)->first();
        if(is_null($check)){
            foreach ($attendanceStatus as $key => $value) {
                if($value == "Present") {
                    $form_data = array('classroom_id' => $classroom->id, 'astatus' => 'Present', 'student_id' => $key, 'asession' => $session, 'aterm' => $term, 'attendance_date' => $attendanceDate);
                    $save = StudentAttendance::create($form_data);
                  
                } else {
                    $form_data = array('classroom_id' => $classroom->id, 'astatus' => 'Absent', 'student_id' => $key, 'asession' => $session, 'aterm' => $term, 'attendance_date' => $attendanceDate);
                    $save = StudentAttendance::create($form_data);
                }
            }
            
            return redirect('/teacher/student-attendance')->with('success', 'Attendance taken successfully.');
        } else {
            return redirect('/teacher/student-attendance')->with('error', 'oops.');
        }
        
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
