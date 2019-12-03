<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classroom;
use App\Subject;
use App\Employee;
use App\Student;
use App\Assignment;
use App\AssignmentDetail;
use App\SessionTerm;
use Auth;
use Validator;
use DB;

class StudentsAssignmentsController extends Controller
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
        if(request()->ajax())
        {
            $user = Auth::user()->employee_id;
            $subject = Employee::find($user)->subject;
            $session_term = DB::table('session_term')->find(1);
            $start = $session_term->start;
            $end= $session_term->end;
            $session = $start ."/". $end;
            $term = $session_term->term;
            $assignments = DB::table('assignments')->join('classrooms', 'classrooms.id', '=', 'assignments.classroom_id')->join('employees', 'employees.id', '=', 'assignments.employee_id')->where('employees.id', '=', $user)->where('assignments.session', '=', $session)->where('assignments.term', '=', $term)->select('assignments.id','assignments.topic', 'assignments.description', 'classrooms.title');
                return datatables()->of($assignments) 
                    ->addIndexColumn()
                    ->addColumn('action', function($data){  
                        $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-warning btn-sm"><span><i class="fa fa-fw fa-edit"></i></span></button>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm"><span><i class="fa fa-fw fa-trash"></i></span></button>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<a class="btn btn-info" href="student-assignments/'.$data->id.'"><span><i class="fa fa-fw fa-eye"></i></span></a>';  
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);            
                    
        }
        $user = Auth::user()->employee_id;
        $subjects = Employee::find($user)->subjects;
        
        
        return view('sysTeacher.assignments.index', compact('user', 'subjects'));
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
            'classroom'    =>  'required',
            'subject' => 'required', 
            'topic'    =>  'required',
            'description'    =>  'required',
            'afile' => 'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        //Handle file upload
        // Get filename with the extension
        $filenameWithExt = $request->file('afile')->getClientOriginalName();
        // Get just filename
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        // Get just extension
        $extension = $request->file('afile')->getClientOriginalExtension();
        // Filename to store
        $fileNameToStore = $filename.'_'.time().'.'.$extension;
        // Upload Image
        $path = $request->file('afile')->storeAs('public/files/pdf', $fileNameToStore);
        

        $user = Auth::user()->employee_id;
        $session_term = DB::table('session_term')->find(1);
        $start = $session_term->start;
        $end= $session_term->end;
        $session = $start ."/". $end;
        $term = $session_term->term;
        $form_data = array(
            'topic' => $request->topic,
            'description' => $request->description,
            'afile' => $fileNameToStore,
            'session' => $session,
            'term' => $term,            
            'classroom_id' => $request->classroom,
            'subject_id' => $request->subject,
            'employee_id' => $user            
        );

        $saveAssignment = Assignment::create($form_data);

        return response()->json(['success' => ' Assignment saved successfully.']);
    }

    public function add_score(Request $request)
    {
        /*$rules = array(
            'score[]'    =>  'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }*/

        for($count=0; $count<$request->total_item; $count++) {
            $form_data = array( 'ascore' => $request->score[$count]);

            AssignmentDetail::whereAssignmentId($request->assignment_id[$count])->update($form_data);
        }

        return response()->json(['success' => ' Assignment saved successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $assignment = Assignment::findOrFail($id);
        //$details = Assignment::find($id)->details;
        //$detailNum = count($details);
        //$details = Student::find($assignment->id)->details;
        //$asses = AssignmentDetail::all(); 
        //$students = DB::table('assignment_details')->where('student_id', '=', $id);
        //$students = AssignmentDetail::where('assignment;_id', $id);

        /*$details = DB::table('assignment_details')->join('students', 'students.id', '=', 'assignment_details.student_id')->join('assignments', 'assignments.id', '=', 'assignment_details.assignment_id')->join('subjects', 'subjects.id', '=', 'assignments.subject_id')->join('classrooms', 'classrooms.id', '=', 'assignments.classroom_id')->where('assignments.id', '=', $id)->select('students.name','assignment_details.adfile')->get();*/

        $details = DB::table('assignment_details')->join('assignments', 'assignments.id', '=', 'assignment_details.assignment_id')->join('subjects', 'subjects.id', '=', 'assignments.subject_id')->join('students', 'students.id', '=', 'assignment_details.student_id')->where('assignments.id', '=', $id)->select('students.name','assignment_details.adfile')->get();
        $detailNum = count($details);
    return view('sysTeacher.assignments.show', compact('details', 'assignment', 'detailNum'));
    }

    public function view()
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = Assignment::findOrFail($id);
            return response()->json(['data' => $data]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $rules = array(
            'class'    =>  'required',
            'topic'    =>  'required',
            'description'    =>  'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        //Handle file upload
        if($request->hasFile('afile')){
            // Get filename with the extension
            $filenameWithExt = $request->file('afile')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just extension
            $extension = $request->file('afile')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('afile')->storeAs('public/files/pdf', $fileNameToStore);
        }

        $user = Auth::user()->employee_id;
        $session_term = DB::table('session_term')->find(1);
        $start = $session_term->start;
        $end= $session_term->end;
        $session = $start ."/". $end;
        $term = $session_term->term;
        $form_data = array(
            'topic' => $request->topic,
            'description' => $request->description,
            'session' => $session,
            'term' => $term,            
            'classroom_id' => $request->class,
            'employee_id' => $user            
        );

        $saveAssignment = Assignment::whereId($request->hidden_id)->update($form_data);

        $assignment = Assignment::find($saveAssignment->id);
        if($request->hasFile('afile')){
            $assignment->afile = $fileNameToStore;
            
        }     
$assignment->save();

        return response()->json(['success' => ' has been updated successfully.']);
    }

    public function uploadScore(){
        print ('yes');
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
