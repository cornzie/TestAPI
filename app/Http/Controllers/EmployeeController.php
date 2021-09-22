<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::paginate(100);

        return response()->json([
            'status' => 'success',
            'data' => $employees
        ]);

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        return response()->json([
            'status' => 'success',
            'employee' => $employee
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {

        $request->validate([
            'employer_id' => 'nullable|integer',
            'nok_surname' => 'nullable|string', 
            'nok_firstname' => 'nullable|string', 
            'nok_mobile' => 'nullable|string', 
            'nok_email' => 'nullable|string', 
        ]);
        
        if($request->has('employer_id'))
        {
            $employee->user_id = $request->employer_id;

            $employee->save();
        }

        if( $request->has('nok_surname') || $request->has('nok_firstname') || $request->has('nok_mobile') || $request->has('nok_email') )
        {
            $employeeInfo = EmployeeInfo::find(Auth::id());
            $employeeInfo->nok_surname = $request->nok_surname;
            $employeeInfo->nok_firstname = $request->nok_firstname;
            $employeeInfo->nok_mobile = $request->nok_mobile;
            $employeeInfo->nok_email = $request->nok_email;

            $employeeInfo->save();

        }
        
        return response()->json([
                'status' => 'success',
                'employee' => $employee->with('employeeInfo')
            ], 201);
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        //
    }
}
