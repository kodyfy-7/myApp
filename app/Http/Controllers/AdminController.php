<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SessionTerm;
use App\Classroom;
use DB;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    
    function index()
    {
        $session_year = SessionTerm::find(1);
        $start = $session_year->start;
        $end= $session_year->end;
        $session = $start ."/". $end;
        $term = $session_year->term;
        $classrooms = Classroom::all();
        return view('sysAdmin.dashboard', compact('session', 'term', 'classrooms'));
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
                'start'    =>  $request->start,
                'end' =>$request->end,
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
}
?>