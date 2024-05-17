<?php

namespace App\Http\Controllers;

use App\Questionnaire;
use Illuminate\Http\Request;
use App\Question;
use App\QuestionnaireCode;
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
        $this->questionnaire_code  = new QuestionnaireCode;
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
    public function index()
    {
        $user = auth()->user();
        $course = $user->course;
        $subjectsSubtopics = $this->question
            ->select('subject', 'subtopic')
            ->distinct()
            ->whereNull('deleted')
            ->where('course', $course)
            ->get()
            ->map(function ($item) {
                return $item->subject . " | " . $item->subtopic;
            });
        $subjects = $this->question
            ->select('subject')
            ->distinct()
            ->whereNull('deleted')
            ->where('course', $course)
            ->get()
            ->map(function ($item) {
                return $item->subject;
            });

        $questionnaire_code = $this->questionnaire_code->where('user_id', $user->id)
            ->where(function($query) {
                $query->where('time_start', '<=',date('Y-m-d H:i:s'))
                ->where('time_end', '>=',date('Y-m-d H:i:s'))
                ->orWhereNull('time_start')
                ->orWhereNull('time_end');
            })->whereNull('result')->first();

        $qualifying = $this->questionnaire_code
                        ->where('user_id', $user->id)
                        ->where('is_official', 1)
                        ->whereNull('result')->first();

        return view('modules.home.dashboard', compact('subjects', 'questionnaire_code', 'subjectsSubtopics', 'qualifying'));
    }

    public function import(Request $request) {
        if ($request->method() == "GET") {
            return view('modules.import.index');
        }
        $data = $request->all();

        if (!$request->hasFile('csv_file') || empty($request)) {
            $status = 'error';
            $message = 'Unable to import csv file';
            return redirect()->back()->with($status, $message);
        }
        $datas = $this->csvToArray($request);
        $status = 'success';
        $message = 'Import finished!';
        return redirect()->back()->with($status, $message);
    }

    private function csvToArray($request)
    {
        $data = $request->all();
        $header = [];
        if ($data['type'] == 'Questions') {
            $header = [
                'question',
                'image_link',
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
        $counter = 0;
        $cleanedData = [];

        while ($column = fgetcsv($file)) {
            if (!$column[0]) {
                continue;
            }
            // if ($column[0] == "1 + 1 ?") {
            //     continue;
            // }
            // if ($column[0] == "2 + 2 ?") {
            //     continue;
            // }
            if ($data['type'] == 'Questions') {
                // $check = explode('.', $column[0]);
                // if (ctype_digit($check[0])) {
                //     unset($check[0]);
                //     $check = implode('.', $check);
                // }
                $check = $column[0];
                $check = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $check);
                $check = preg_replace('/[\x00-\x1F\x7F-\xA0\xAD]/u', '', $check);
                $check = preg_replace( '/[^[:print:]]/', '',$check);
                $insert = [
                    'question' => trim(is_array($check) ? @$check[0] : $check),
                    'image_link' => $column[1],
                    'subject' => $column[2],
                    'subtopic' => $column[3],
                    'course' => $column[4],
                ];
                if (empty(trim(is_array($check) ? @$check[0] : $check))) {
                    continue;
                }
                try {
                    DB::beginTransaction();
                    $question = $this->question->create($insert);
                    foreach ($column as $key => $value) {
                        if ($key <= 4) {
                            continue;
                        }
                        if (empty($value)) {
                            continue;
                        }

                        if ($value == "") {
                            continue;
                        }
                        $qoption = [];
                        $answer_real = explode('/', $column[5]);
                        $g_choices = [];
                        foreach ($answer_real as $let) {
                            $orig_answer = strtolower(trim($let));
                            $g_choices[] = $orig_answer;
                        }

                        $value = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $value);
                        $value = preg_replace('/[\x00-\x1F\x7F-\xA0\xAD]/u', '', $value);
                        $value = preg_replace( '/[^[:print:]]/', '',$value);
                        if (empty(trim($value))) {
                            DB::rollBack();
                            continue;
                        }
                        $qoption = [
                            'description' => trim($value),
                            'question_id' => $question->id,
                        ];
                        if (in_array($value, $g_choices)) {
                            $qoption['is_correct'] = 1; 
                        }
                        $option = $this->question_option->create($qoption);
                    }
                    $counter++;
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                }
            }

            if ($data['type'] == 'Student' && sizeof($column) == 8) {
                $insert = [
                    'student_id' => $column[0],
                    'first_name' => $column[1],
                    'middle_name' => $column[2],
                    'last_name' => $column[3],
                    'email'=> $column[4],
                    'username' => $column[5],
                    'course' => $column[6],
                    'expiration_date' => $column[7],
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
