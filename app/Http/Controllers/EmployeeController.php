<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use DataTables;
use Validator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Employee::all();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                            $btn = '<a href="" class="edit btn btn-primary btn-sm">Edit</a>';
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('home');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'profile_img' => 'required|mimes:jpg,png',
            'first_name' => 'required',
            'last_name' => 'required',
            'gender'=>'required',
            'email'=>'required|email',
            'user_name'=>'required',
            'birth_date'=>'required',
            'password'=>'required|confirmed|min:8',
            'confirm_password'=>'required',
        ]);
       
        if ($validator->passes()) {
     
        $employee = new Employee();
        $employee->first_name = $request->first_name;
        $employee->last_name = $request->last_name;
        $employee->gender = $request->gender;
        $employee->email = $request->email;
        $employee->username = $request->user_name;
        $employee->password = bcrypt($request->password);
        $employee->birth_data = $request->birth_date;

        if($request->file('profile_img'))
            {
                $file=$request->file('profile_img');
                $file_name=$file->getClientOriginalName();
                $file->storeAs('public/images',$file_name);
         }
         $employee->profile_img= @$file_name;
         $employee->save();
         return response()->json(['status'=>"true"]);
        }
        return response()->json(['error'=>$validator->getMessageBag()->toArray()]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
