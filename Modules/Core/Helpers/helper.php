<?php

use Modules\Employee\Entities\EmployeeSetting;
use Modules\GlobalSetting\Entities\GlobalSetting;

function getAllBranch()
{
    $data = [];
    $branches = GlobalSetting::where('key', 'branch')->get();
    foreach ($branches as $branch) {
        $data[$branch->id] = json_decode($branch->value)->name;
    }
    return $data;
}

function getAllDepartment()
{
    $data = [];
    $departments = GlobalSetting::where('key', 'department')->get();
    foreach ($departments as $department) {
        $data[$department->id] = json_decode($department->value)->name;
    }
    return $data;
}

function getAllDesignation()
{
    $data = [];
    $designations = GlobalSetting::where('key', 'designation')->get();
    foreach ($designations as $designation) {
        $data[$designation->id] = json_decode($designation->value)->name;
    }
    return $data;
}

function getDesignation($id)
{
    $employee_designation = EmployeeSetting::where('employee_id', $id)
        ->where('key', 'designation')
        ->latest('created_at')
        ->first();
    $designation = GlobalSetting::find(@json_decode($employee_designation->value));
    return @json_decode($designation->value)->name;
}

function getAllSchedule()
{
    $data = [];
    $schedules = GlobalSetting::where('key', 'schedule')->get();
    foreach ($schedules as $schedule) {
        $data[$schedule->id] = @json_decode($schedule->value);
    }
    return $data;
}

function getDepartment($id)
{
    $employee_department = EmployeeSetting::where('employee_id', $id)
        ->where('key', 'department')
        ->latest('created_at')
        ->first();
    $department = GlobalSetting::find(@json_decode($employee_department->value));
    return @json_decode($department->value)->name;
}

function getBranch($id)
{
    $employee_branch = EmployeeSetting::where('employee_id', $id)
        ->where('key', 'branch')
        ->latest('created_at')
        ->first();
    $branch = GlobalSetting::find(@json_decode($employee_branch->value));
    return @json_decode($branch->value)->name;
}

function getSchedule($id)
{
    $employee_schedule = EmployeeSetting::where('employee_id', $id)
        ->where('key', 'schedule')
        ->latest('created_at')
        ->first();
    if (isset($employee_schedule)) {
        if (is_object(@json_decode($employee_schedule->value))) {
            return [
                'key' => 'custom_schedule',
                'value' => @json_decode($employee_schedule->value),
            ];
        } else {
            $schedule = GlobalSetting::find(@json_decode($employee_schedule->value));
            return [
                'key' => @$schedule->id,
                'value' => @json_decode($schedule->value),
            ];
        }
    } else {
        return null;
    }
}

function getSalary($id)
{
    $employee_salary = EmployeeSetting::where('employee_id', $id)
        ->where('key', 'salary')
        ->latest('created_at')
        ->first();
    return @json_decode($employee_salary->value);
}
function getDocuments($id)
{
    $documents = [];
    $employee_documents = EmployeeSetting::where('employee_id', $id)
        ->where('key', 'document')
        ->orderBy('created_at', 'desc')
        ->get();
    foreach ($employee_documents as $key => $value) {
        $document = @json_decode($value->value);
        $documents[] = [
            'id' => $value->id,
            'name' => $document->name,
            'file' => $document->file,
            'date' => $value->created_at->format('Y-m-d'),
        ];
    }
    return $documents;
}
