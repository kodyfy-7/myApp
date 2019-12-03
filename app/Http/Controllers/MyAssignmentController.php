<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\Classroom;
use App\SessionTerm;
use App\Assignment;
use App\AssignmentDetail;
use App\Subject;
use Auth;
use DB;

class MyAssignmentController extends Controller
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
            $user = Auth::user()->student_id;
            $class_id = Student::find($user)->classroom_id;
            $session_term = DB::table('session_term')->find(1);
            $start = $session_term->start;
            $end= $session_term->end;
            $session = $start ."/". $end;
            $term = $session_term->term;
            $assignments = DB::table('assignments')->join('classrooms', 'classrooms.id', '=', 'assignments.classroom_id')->join('subjects', 'subjects.id', '=', 'assignments.subject_id')->where('assignments.session', '=', $session)->where('assignments.term', '=', $term)->where('assignments.classroom_id', '=', $class_id)->select('assignments.id','assignments.topic', 'assignments.description', 'assignments.afile', 'subjects.subject_title');
                return datatables()->of($assignments) 
                    ->addIndexColumn()
                    ->addColumn('action', function($data){  
                        $button = '<a href="/storage/files/pdf/'.$data->afile.'" download="'.$data->afile.'"><button type="button" class="btn btn-primary"><i class="fa fa-fw fa-download"></i></span></button></a>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-warning btn-sm"><span><i class="fa fa-fw fa-upload"></i></span></button>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);            
                    
        }
        
        return view('sysStudent.assignment.index', compact('user', 'class', 'session', 'term'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*$rules = array(
            'adfile' => 'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }*/

        //Handle file upload
        // Get filename with the extension
        $filenameWithExt = $request->file('adfile')->getClientOriginalName();
        // Get just filename
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        // Get just extension
        $extension = $request->file('adfile')->getClientOriginalExtension();
        // Filename to store
        $fileNameToStore = $filename.'_'.time().'.'.$extension;
        // Upload Image
        $path = $request->file('adfile')->storeAs('public/files/pdf', $fileNameToStore);
        

        $user = Auth::user()->student_id;

        $form_data = array(
            'student_id' => $user,
            'assignment_id' => $request->hidden_id,
            'student_status' => 1,
            'adfile' => $fileNameToStore
        );

        $saveAssignment = AssignmentDetail::create($form_data);
        //DB::table('assignment_details')->insert($form_data);
        return response()->json(['success' => ' Result uploaded successfully.']);
    }

    public function edit($id)
    {   
        if(request()->ajax())
        {
            $data = Assignment::findOrFail($id);
            return response()->json(['data' => $data]);
        }
    }

    public function update(Request $request)
    {
        /*$rules = array(
            'adfile'    =>  'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }*/

        //Handle file upload
        if($request->hasFile('adfile')){
            // Get filename with the extension
            $filenameWithExt = $request->file('adfile')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just extension
            $extension = $request->file('adfile')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('adfile')->storeAs('public/files/pdf', $fileNameToStore);
        }

        $user = Auth::user()->student_id;
        $form_data = array(
            'student_id' => $user,
            'assignment_id' => $request->hidden_id,
            'adfile' => $fileNameToStore      
        );

        $saveAssignment = AssignmentDetail::create($form_data);

        

        return response()->json(['success' => ' has been updated successfully.']);
    }

    
}
