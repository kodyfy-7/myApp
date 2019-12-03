<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classroom;
use App\Student;
use App\StudentLogin;
use App\Subject;
use App\Result;
use App\Payment;
use App\ClassroomSubject;
use App\SessionTerm;
use Validator;
use App\User;
use DB;

class StudentsController extends Controller
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
            $session_year = SessionTerm::find(1);
            $start = $session_year->start;
            $end= $session_year->end;
            $session = $start ."/". $end;
            $term = $session_year->term;
            
            $students =  DB::table('students')->join('classrooms', 'classrooms.id', '=', 'students.classroom_id')->join('payments', 'payments.id', '=', 'students.id')->where('payments.psession', '=', $session)->where('payments.pterm', '=', $term)->select('students.id', 'students.name', 'classrooms.title', 'payments.pstatus');
                return datatables()->of($students) 
                    ->addIndexColumn()
                    ->addColumn('pstatus', function($data){                        
                        
                        if($data->pstatus =='1'){
                            $pstatus= '<span class="badge badge-success">Paid</span>';
                        }elseif ($data->pstatus == '0'){
                            $pstatus= '<span class="badge badge-secondary">Not Paid</span>';
                        }
                        
                        return $pstatus;
                    })
                    ->addColumn('action', function($data){                        
                        $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-warning btn-sm"><span><i class="fa fa-fw fa-edit"></i></span></button>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<button type="button" name="view" id="'.$data->id.'" class="view btn btn-info btn-sm"><span><i class="fa fa-fw fa-eye"></i></span></button>';
                        $button .= '&nbsp;&nbsp;';
                        //$button .= '<button data-toggle="modal" data-target="#make-payment" data-id="'.$data->id.'" ';
                        if($data->pstatus =='1'){
                            $button .= '<button type="button" name="" id="" class=" btn btn-warning btn-sm disabled"><span><i class="fa fa-fw fa-credit-card"></i></span></button>';
                        }elseif ($data->pstatus == '0'){
                            $button .= '<button type="button" name="make-payment" id="'.$data->id.'" class="make-payment btn btn-warning btn-sm"><span><i class="fa fa-fw fa-credit-card"></i></span></button>';
                        }
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm"><span><i class="fa fa-fw fa-trash"></i></span></button>';
                        return $button;
                    })
                    ->rawColumns(['action', 'status', 'pstatus'])
                    ->make(true);            
        }
        $classrooms = Classroom::all();
        return view('sysAdmin.students.index', compact('classrooms'));
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
            'dob'    =>  'required',
            'gender'    =>  'required',
            'classroom'    =>  'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'name'        =>  $request->name,
            'dob' => $request->dob,
            'gender'        =>  $request->gender,
            'classroom_id' => $request->classroom
        );

        $saveStudent = Student::create($form_data);

        $rand = mt_rand(0,100);
        $strpusername = str_replace(' ', '', $saveStudent->name);
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
        //$password = str_shuffle($password);
        $password = 'qwerty';
        $passwordHash = bcrypt($password);

        $login_data = array(
            'student_id' => $saveStudent->id,
            'username' => $username,
            'password' => $passwordHash
        );
        StudentLogin::create($login_data);

        $session_year = SessionTerm::find(1);
        $start = $session_year->start;
        $end= $session_year->end;
        $session = $start ."/". $end;
        $term = $session_year->term;

        $payment_data = array(
            'student_id' => $saveStudent->id,
            'classroom_id' => $saveStudent->classroom_id,
            'pstatus' => '0',
            'psession' => $session,
            'pterm' => $term
        );
        Payment::create($payment_data);


        $result_data = array(
            'student_id' => $saveStudent->id,
            'classroom_id' => $saveStudent->classroom_id,
            'rstatus' => '0',
            'total' => '0',
            'average' => '0',
            'session' => $session,
            'term' => $term
        );
        $saveResult = Result::create($result_data);        

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

    public function pay(Request $request) 
    {
        $rules = array(
            'amount'    =>  'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'amount'        =>  $request->amount,
            'pstatus' => '1'
        );

        Payment::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Payment successfull.']);
    }

    public function get_student($id)
    {
        if(request()->ajax())
        {
            $data = Student::find($id);
            //$student =  DB::table('students')->where('id', '=', $stuid)->get();
            //Payment::find($data)->student;
            //$data =  DB::table('payments')->join('students', 'students.id', '=', 'payments.student_id')->where('payments.id', '=', $id)->select('payments.id', 'students.name', 'payments.psession', 'payments.pterm');
            return response()->json(['data' => $data]);
        }
    }

    public function get_payment($id)
    {
        if(request()->ajax())
        {
            $data = Payment::findOrFail($id);
            $stuid = $data->student_id;
            $student = Payment::find($stuid)->student;
            //$student =  DB::table('students')->where('id', '=', $stuid)->get();
            //Payment::find($data)->student;
            //$data =  DB::table('payments')->join('students', 'students.id', '=', 'payments.student_id')->where('payments.id', '=', $id)->select('payments.id', 'students.name', 'payments.psession', 'payments.pterm');
            return response()->json(['data' => $data, 'student' => $student]);
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
