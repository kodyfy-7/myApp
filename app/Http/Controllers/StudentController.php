<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\Classroom;
use App\SessionTerm;
use App\Assignment;
use App\Subject;
use Auth;
use DB;

class StudentController extends Controller
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
        
        
        if(request()->ajax())
        {
            $assignments = DB::table('assignments')->join('classrooms', 'classrooms.id', '=', 'assignments.classroom_id')->where('assignments.session', '=', $session)->where('assignments.term', '=', $term)->where('assignments.classroom_id', '=', $class)->select('assignments.id','assignments.topic', 'assignments.question');
                return datatables()->of($assignments) 
                    ->addIndexColumn()
                    ->addColumn('action', function($data){                        
                        $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-warning btn-sm"><span><i class="fas fa-fw fa-edit"></i></span></button>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm"><span><i class="fas fa-fw fa-trash"></i></span></button>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);            
        }
        
        return view('sysStudent.dashboard', compact('user', 'class', 'session', 'term'));
    }

    
}
