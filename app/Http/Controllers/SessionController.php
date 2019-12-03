<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SessionTerm;
use DB;

class SessionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    
    function index()
    {
        if(request()->ajax())
        {   
           
                
              
              
                       
            $sessions =  DB::table('session_term')->where('id', '=', '1')->select('id', 'start', 'end', 'term');
                return datatables()->of($sessions) 
                    ->addIndexColumn()
                    ->addColumn('action', function($data){                        
                        $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-warning btn-sm"><span><i class="fas fa-fw fa-edit"></i></span></button>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<button type="button" name="select-session" id="'.$data->id.'" class="select btn btn-warning btn-sm"><span><i class="fas fa-fw fa-"></i></span></button>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm"><span><i class="fas fa-fw fa-trash"></i></span></button>';
                        return $button;
                    })
                    ->rawColumns(['action', 'status', 'pstatus'])
                    ->make(true);            
        }
        $session_year = SessionTerm::find(1);
                $start = $session_year->start;
                $end= $session_year->end;
                $session = $start ."/". $end;
                $term = $session_year->term;
        return view('sysAdmin.dashboard', compact('session', 'term'));
    }

    function fetch_data(Request $request)
    {
        if($request->ajax())
        {
            $data = DB::table('session_term')->orderBy('id','desc')->get();
            echo json_encode($data);
        }
    }

    function add_data(Request $request)
    {
        if($request->ajax())
        {
            $data = array(
                'session'    =>  $request->session,
                'term'     =>  $request->term
            );
            $id = DB::table('session_term')->insert($data);
            if($id > 0)
            {
                echo '<div class="alert alert-success">Data Inserted</div>';
            }
        } 
    }

    function update_data(Request $request)
    {
        if($request->ajax())
        {
            $data = array(
                $request->column_name       =>  $request->column_value
            );
            DB::table('session_term')
                ->where('id', $request->id)
                ->update($data);
            echo '<div class="alert alert-success">Data Updated</div>';
        }
    }

    function delete_data(Request $request)
    {
        if($request->ajax())
        {
            DB::table('session_term')
                ->where('id', $request->id)
                ->delete();
            echo '<div class="alert alert-success">Data Deleted</div>';
        }
    }

    public function change(Request $request) 
    {
        $rules = array(
            'start'    =>  'required',
            'end'    =>  'required',
            'term'    =>  'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'start'        =>  $request->start,
            'end'        =>  $request->end,
            'term'        =>  $request->term
        );

        SessionTerm::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'successful.']);
    }

    public function select_session($id)
    {
        if(request()->ajax())
        {
            $data = SessionTerm::findOrFail($id);
            return response()->json(['data' => $data]);
        }
    }
}
?>