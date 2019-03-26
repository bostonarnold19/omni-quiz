<?php

namespace App\Http\Controllers;

use App\Questionnaire;
use Illuminate\Http\Request;
use App\Question;
use App\QuestionOption;
use DB;
use Modules\User\Entities\User;
use Modules\User\Entities\Role;


class HomeController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->group_question  = new Questionnaire;
        $this->question        = new Question;
        $this->question_option = new QuestionOption;
        $this->user            = new User;
        $this->role            = new Role;
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        return view('modules.home.dashboard');
    }

    public function import(Request $request) {
        if ($request->method() == "GET") {
            return view('modules.import.index');
        }
        $data = $request->all();

        if (!$request->hasFile('csv_file') || empty($request)) {
            return redirect()->back();
        }
        $datas = $this->csvToArray($request);
        return redirect()->back();
    }

    private function csvToArray($request)
    {
        $data = $request->all();
        $header = [];
        if ($data['type'] == 'Questions') {
            $header = [
                'question',
                'subject',
                'course',
            ];
        }
        $csv = $request->file('csv_file');
        $filePath = $csv->getRealPath();
        $file = fopen($filePath, 'r');
        $header = fgetcsv($file);
        if ($data['type'] == 'Student') {
            $role = $this->role->where('name','student')->first();
        }
        while ($column = fgetcsv($file)) {
            if (!$column[0] || !$column[1]) {
                continue;
            }
            if ($data['type'] == 'Questions' && sizeof($column) == 7) {

                $insert = [
                    'question' => $column[0],
                    'subject' => $column[1],
                    'course' => $column[2],
                ];
                try {
                    DB::beginTransaction();
                    $question = $this->question->create($insert);
                    foreach ($column as $key => $value) {
                        if ($key <= 2) {
                            continue;
                        }
                        $qoption = [
                            'description' => $value,
                            'question_id' => $question->id,
                        ];
                        if ($key == 3) {
                            $qoption['is_correct'] = 1;
                        }
                        $this->question_option->create($qoption);
                    }
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                }
            }
            if ($data['type'] == 'Student' && sizeof($column) == 6) {
                $insert = [
                    'student_id' => $column[0],
                    'first_name' => $column[1],
                    'middle_name' => $column[2],
                    'last_name' => $column[3],
                    'email'=> $column[4],
                    'username' => $column[5],
                    'password' => bcrypt($column[0]),
                ];
                $exist = $this->user->where('student_id', $insert['student_id'])->first();
                if ($exist) {
                    continue;
                }

                try {
                    DB::beginTransaction();
                    $user = $this->user->create($insert);
                    $user->roles()->attach($role->id);
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                }

            }
            $cleanedData[] = $data;
        }

        return $cleanedData;
    }
}
