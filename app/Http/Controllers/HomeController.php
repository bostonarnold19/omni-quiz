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
        $subjects = $this->question
            ->select('subject', 'course')
            ->distinct()
            ->whereNull('deleted')
            ->get()
            ->map(function ($item) {
                return $item->subject . " | " . $item->course;
            });

        $questionnaire_code = $this->questionnaire_code->where('user_id', $user->id)
        ->where(function($query) {
            $query->where('time_start', '<=',date('Y-m-d H:i:s'))
            ->where('time_end', '>=',date('Y-m-d H:i:s'))
            ->orWhereNull('time_start')
            ->orWhereNull('time_end');
        })->whereNull('result')->first();
        return view('modules.home.dashboard', compact('subjects', 'questionnaire_code'));
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
        $choices = [
            'a' => 4,
            'b' => 5,
            'c' => 6,
            'd' => 7,
        ];
        $cleanedData = [];

        while ($column = fgetcsv($file)) {
            if (!$column[0] || !$column[1]) {
                continue;
            }
            if ($column[0] == "1 + 1 ?") {
                continue;
            }
            if ($data['type'] == 'Questions' && (sizeof($column) == 8 || sizeof($column) == 7)) {
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
                    'subject' => $column[1],
                    'course' => $column[2],
                ];
                if (empty(trim(is_array($check) ? @$check[0] : $check))) {
                    continue;
                }
                try {
                    DB::beginTransaction();
                    $question = $this->question->create($insert);

                    foreach ($column as $key => $value) {
                        if ($key <= 3) {
                            continue;
                        }
                        if (empty($value)) {
                            continue;
                        }

                        if ($value == "") {
                            continue;
                        }
                        $qoption = [];
                        $value = explode('.', $value);
                        
                        $answer_real = explode('/', $column[3]);
                        $g_choices = [];
                        foreach ($answer_real as $let) {
                            $orig_answer = strtolower(trim($let));
                            $answer = @$choices[strtolower(trim($let))];
                            if (is_array($value)) {
                                $value = implode('.', $value);
                            }
                            $g_choices[] = @$column[$answer];
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
                        if ($option) {
                            if (@$choices[strtolower(trim($column[3]))] == $key) {
                                $option->is_correct = 1; 
                                $option->save(); 
                            }
                        }
                    }
                    $counter++;
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
