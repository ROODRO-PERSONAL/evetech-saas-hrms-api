<?php

namespace App\Services;

use App\Models\Employee;

class EmployeeService
{
    public function create(array $data)
    {
        return Employee::create($data);
    }

    public function list()
    {
        return Employee::latest()->get();
    }
}
