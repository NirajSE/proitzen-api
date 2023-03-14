<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Titles;
use App\Models\Salaries;
use DB;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Employee::all();
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
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'birth_date' => 'required|date',
            'hire_date' => 'required|date',
            'gender' => 'required',
        ]);

        DB::beginTransaction();

        try {

            $employee = Employee::create($request->all());
            $emp_no = $employee->emp_no;

            foreach($request->input('designations') as $designation) {
        
            $titles = Titles::create([
                    'emp_no' => $emp_no,
                    'title' => $designation['title'],
                    'from_date' => $designation['from_date'],
                    'to_date' => $designation['to_date']
                ]);
            }

            foreach($request->input('salaries') as $salary) {

                $salaries = Salaries::create([
                    'emp_no' => $emp_no,
                    'salary' => $salary['salary'],
                    'from_date' => $salary['from_date'],
                    'to_date' => $salary['to_date']
                ]);
            }

            DB::commit();

        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            if ($e->errorInfo[1] == 1062) {
                return response()->json(['messagetype'=> 'failure','message' => 'Duplicate Values']);
            } else {
                return response()->json(['messagetype'=> 'failure','message' => 'Please fill the default values']);
            }
        }

        return response()->json(['messagetype'=> 'success','message' => 'Employee created successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Employee::with('titles','salaries')->findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            // Find the employee record to be updated
            $employee = Employee::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            // Handle the case where the employee record is not found
            return response()->json(['messagetype'=> 'failure','message' => 'Employee Not Found']);
        }

        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'birth_date' => 'required|date',
            'hire_date' => 'required|date',
            'gender' => 'required',
        ]);

        $employee->update($request->all());

        return response()->json(['messagetype'=> 'success','message' => 'Employee Updated Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteSalary($emp_no,$from_date)
    {
        try {
            Salaries::where('emp_no', $emp_no)->where('from_date', $from_date)->delete();
            return response()->json(['messagetype'=> 'success','message' => 'Salary Data Deleted Successfully']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['messagetype'=> 'failure','message' => 'Salary Data Not Found']);
        }
    }

    public function deleteTitles($emp_no,$from_date,$title)
    {
        try {
            Titles::where('emp_no', $emp_no)->where('from_date', $from_date)->where('title', $title)->delete();
            return response()->json(['messagetype'=> 'success','message' => 'Designation Data Deleted Successfully']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['messagetype'=> 'failure','message' => 'Designation Data Not Found']);
        }
    }
}
