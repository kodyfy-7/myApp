<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\Classroom;
use App\Subject;
use Validator;
use DB;

class SubjectsController extends Controller
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
            $subjects =  DB::table('subjects')->join('employees', 'employees.id', '=', 'subjects.employee_id')->select('subjects.id','subjects.subject_title', 'employees.name', 'subjects.level');
                return datatables()->of($subjects) 
                    ->addIndexColumn()
                    ->addColumn('level', function($data){                        
                        if($data->level =='JN'){
                            $level= '<span class="badge badge-secondary">Junior</span>';
                        }elseif ($data->level == 'SN'){
                            $level= '<span class="badge badge-dark">Senior</span>';
                        }
                        
                        return $level;
                    })
                    ->addColumn('action', function($data){                        
                        $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-warning btn-sm"><span><i class="fa fa-fw fa-edit"></i></span></button>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm"><span><i class="fa fa-fw fa-trash"></i></span></button>';
                        return $button;
                    })
                    ->rawColumns(['action', 'level'])
                    ->make(true);            
        }
        $classrooms = Classroom::all();
        return view('sysAdmin.subjects.index', compact('classrooms'));
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
            'level' => 'required',
            'teacher' => 'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'subject_title'        =>  $request->title,
            'level' => $request->level,
            'employee_id'        =>  $request->teacher,
        );

        $saveSubject = Subject::create($form_data);
        
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
        //
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
            $data = Subject::findOrFail($id);
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
            'title'    =>  'required',
            'classroom' => 'required',
            'teacher' => 'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'title'        =>  $request->title,
            'classroom_id' => $request->classroom,
            'employee_id'        =>  $request->teacher,
        );

        Subject::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => ''.$request->title.' details has been updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Subject::findOrFail($id);
        $data->delete();
    }
}
