<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classroom;
use App\Employee;
use App\Subject;
use App\SessionTerm;
use App\ClassroomSubject;
use Validator;
use DB;

class ClassroomsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
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
            $classrooms = DB::table('classrooms')->join('employees', 'employees.classroom_id', '=', 'classrooms.id')->select('classrooms.id','classrooms.title', 'employees.name', 'classrooms.category');
            //$classrooms = Classroom::latest()->get();
                return datatables()->of($classrooms) 
                    ->addIndexColumn()
                    ->addColumn('category', function($data){                        
                        if($data->category =='N'){
                            $category= 'Nill';
                        }elseif ($data->category == 'Sc'){
                            $category= 'Science';
                        }elseif ($data->category == 'Cm'){
                            $category= 'Commercial';
                        }elseif ($data->category == 'Ar'){
                            $category= 'Arts';
                        }
                        
                        return $category;
                    })
                    ->addColumn('action', function($data){                        
                        $button = '';
                        return $button;
                    })
                    ->rawColumns(['action', 'category'])
                    ->make(true);            
                    
        }
        $subjects = Subject::all();
        $session_year = SessionTerm::find(1);
        $start = $session_year->start;
        $end= $session_year->end;
        $session = $start ."/". $end;
        $term = $session_year->term;
        $classrooms = Classroom::all();
        return view('sysAdmin.classrooms.index', compact('subjects', 'session', 'classrooms'));
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
        $rules = array(
            'title'    =>  'required',
            'category'    =>  'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'title'        =>  $request->title,
            'category' => $request->category
        );

        $saveClassroom = Classroom::create($form_data);

        $form_data = array('classroom_id' => $saveClassroom->id);

        $updateEmployee = Employee::whereId($request->class_teacher)->update($form_data);
        for($count=0; $count<$request->total_item; $count++)
	    {
            $form_data1 =array('classroom_id' => $saveClassroom->id,
                                'subject_id' => $request->subject[$count]);
            ClassroomSubject::create($form_data1);
        }

        return response()->json(['success' => ''.$request->title.' details has been saved successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $classroom = Classroom::findOrFail($id);
        $students = Classroom::find($id)->students;
        $classrooms = Classroom::all();
        return view('sysAdmin.classrooms.show', compact('students', 'classrooms', 'classroom'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
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
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }
}
