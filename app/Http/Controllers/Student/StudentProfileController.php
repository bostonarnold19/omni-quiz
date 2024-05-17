<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\User\Entities\User;

class StudentProfileController extends Controller
{

    public function __construct()
    {
        $this->user = new User;
    }

    public function index(Request $request)
    {
        $user = auth()->user();
        return view('modules.student_profile.index', compact('user'));
    }

    public function create(Request $request)
    {

    }

    public function store(Request $request)
    {
        $data = $request->all();
        $questionQuery = $this->question->with('options');

        $course = auth()->user()->course;

        if (@$data['question_ids']) {
            $questionQuery->whereNotIn('id', @$data['question_ids']);
        }

        if (@$data['subject']) {
            $questionQuery->where('subject', @$data['subject']);
        }

        if (@$data['subtopic']) {
            $questionQuery->where('course', @$data['subtopic']);
        }

        $question = $questionQuery
                        ->where('course', $course)
                        ->inRandomOrder()->first();
        return response()->json(['question' => $question]);
    }

    public function show($id)
    {

    }

    public function edit($id) {
        //
    }

    public function update(Request $request, $id) {
        //
    }

    public function destroy($id) {
        //
    }
}
