<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SessionTerm;
use App\Employee;
use App\TeacherLogin;
use App\Admin;
use Validator;
use DB;

class EmployeesController extends Controller
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
            $employees = Employee::latest()->get();
                return datatables()->of($employees) 
                    ->addIndexColumn()
                    ->addColumn('designation', function($data){                        
                        if($data->designation =='1'){
                            $designation= 'Admin';
                        }elseif ($data->designation == '2'){
                            $designation= 'Teacher';
                        }
                        
                        return $designation;
                    })
                    ->addColumn('action', function($data){                        
                        $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-warning btn-sm"><span><i class="fa fa-fw fa-edit"></i></span></button>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm"><span><i class="fa fa-fw fa-trash"></i></span></button>';
                        return $button;
                    })
                    ->rawColumns(['action', 'designation'])
                    ->make(true);            
        }
        $session_year = SessionTerm::find(1);
        $start = $session_year->start;
        $end= $session_year->end;
        $session = $start ."/". $end;
        $term = $session_year->term;
        return view('sysAdmin.employees.index', compact('session', 'term'));
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
            'name'    =>  'required',
            'designation'    =>  'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'name'        =>  $request->name,
            'designation' => $request->designation
        );

        $saveEmployee = Employee::create($form_data);

        $rand = mt_rand(0,100);
        $strpusername = str_replace(' ', '', $saveEmployee->name);
        $strlowusername = strtolower($strpusername);
        $username = $strlowusername . $rand;
        $alpha = "abcdefghijklmnopqrstuvwxyz";
        $alpha_upper = strtoupper($alpha);
        $numeric = "0123456789";
        $special = "!@$#*%";
        $chars = $alpha . $alpha_upper . $numeric . $special;
        $length = 10;
        $chars = str_shuffle($chars);
        $len = strlen($chars);
        $password = "";
        for($i=0;$i<$length;$i++) {
            $password .= substr($chars, rand(0, $len-1),1);
        }
        $password = str_shuffle($password);
        $passwordHash = bcrypt($password);
        if($saveEmployee->designation == '1'){
            $login_data = array(
                'employee_id' => $saveEmployee->id,
                'username' => $username,
                'password' => $passwordHash
            );
    
            Admin::create($login_data);
        } else if($saveEmployee->designation == '2'){
            $login_data = array(
                'employee_id' => $saveEmployee->id,
                'username' => $username,
                'password' => $passwordHash
            );
    
            TeacherLogin::create($login_data);
        }

        /*$login_data = array(
            'employee_id' => $saveEmployee->id,
            'username' => $username,
            'password' => $passwordHash
        );

        TeacherLogin::create($login_data);*/
        return response()->json(['success' => ''.$request->name.' details has been saved successfully.']);
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
            $data = Employee::findOrFail($id);
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
            'name'    =>  'required',
            'designation'    =>  'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'name'        =>  $request->name,
            'designation' => $request->designation
        );

        Employee::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => ''.$request->name.' details has been updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //$data = TeacherLogin::find($id)->employee;
        //$data->delete();
        $data = Employee::findOrFail($id);
        $data->delete();
    }
}
