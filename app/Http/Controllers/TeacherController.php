<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\Classroom;
use App\SessionTerm;
use App\Subject;
use Auth;
use DB;

class TeacherController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:teacher');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        $user = Auth::user()->employee_id;
        $subjects = Employee::find($user)->subjects;
        $classroom = Employee::find($user)->classroom;
        if(empty($classroom)) {
            $class = ' ';
        } else {
            $class = $classroom->title;
        }
        $session_year = SessionTerm::find(1);
        $start = $session_year->start;
        $end= $session_year->end;
        $session = $start ."/". $end;
        $term = $session_year->term;
        
        return view('sysTeacher.dashboard', compact('user', 'session', 'subjects', 'term', 'classroom', 'acton', 'class'));
    }

    
}
