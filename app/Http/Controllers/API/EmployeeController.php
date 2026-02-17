<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\EmployeeService;

class EmployeeController extends Controller
{
    protected $employeeService;

    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id'      => 'required|string|unique:employees,employee_id',
            'name'             => 'required|string',
            'email'            => 'required|email|unique:employees,email',
            'department'       => 'required|string',
            'date_of_joining'  => 'required|date',
            'status'           => 'required|in:active,inactive',
        ]);

        $employee = $this->employeeService->create($request->all());

        return response()->json([
            'message' => 'Employee created successfully',
            'data'    => $employee
        ], 201);
    }

    public function index()
    {
        $employees = $this->employeeService->list();

        return response()->json($employees);
    }
}
