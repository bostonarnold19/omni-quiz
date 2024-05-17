<?php

namespace App\Http\Controllers\Student;

use App\Answer;
use App\User;
use Datatables;
use App\Http\Controllers\Controller;
use App\QuestionnaireCode;
use Modules\User\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;

class ResultController extends Controller
{

    public function __construct(UserRepositoryInterface $user_repository)
    {
        $this->answer = new Answer;
        $this->questionnaire_code = new QuestionnaireCode;
        $this->user_repository = $user_repository->model;
        $this->middleware('permission:manage-result', ['only' => ['index']]);
    }

    private function result()
    {

    }

    public function index()
    {
        $auth = auth()->user();

        if ($auth->hasRole('admin')) {
            return view('modules.result.admin');
        } else {
            $qc = \DB::table('questionnaire_codes')
                ->where('user_id', $auth->id)
                ->where('questionnaire_codes.is_official', 1)
                ->join('users', 'users.id', '=', 'questionnaire_codes.user_id')
                ->join('questionnaires', 'questionnaires.id', '=', 'questionnaire_codes.questionnaire_id')
                ->select('questionnaire_codes.user_id', 'questionnaire_codes.questionnaire_id')
                ->groupBy('users.id', 'questionnaires.id')
                ->get();
        }


        $questionnaire_codes = [];

        foreach ($qc as $key => $value) {

            $questionnaire_codes[$key] = $this->questionnaire_code
                ->where('user_id', $value->user_id)
                ->where('questionnaire_codes.is_official', 1)
                ->where('questionnaire_id', $value->questionnaire_id)
                ->get();
        }

        return view('modules.result.index', compact('questionnaire_codes'));
    }

    public function create()
    {
        $users = $this->user_repository->select(['id', 'student_id', 'first_name', 'last_name', 'email', 'username', 'password_crack', 'profile_picture']);
        return Datatables::of($users)
            ->filterColumn('name', function($query, $keyword) {
                $sql = "CONCAT(users.first_name,'-',users.last_name)  like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->editColumn('profile_picture', function ($user) {
                return view('user::includes._profile_picture', compact('user'))->render();
            })
            ->addColumn('name', function ($user) {
                return $user->first_name . ' ' . $user->last_name;
            })
            ->addColumn('role', function ($user) {
                $roles = $user->roles;
                return view('user::includes._role', compact('roles'))->render();
            })
            ->addColumn('action', function ($user) {
                return view('modules.result.includes._index_action', compact('user'))->render();
            })
            ->rawColumns(['profile_picture', 'role', 'action'])
            ->toJson();
    }

    public function store(Request $request)
    {
        $data = $request->all();

        dd($data);
    }

    public function show($id)
    {
        $qc = \DB::table('questionnaire_codes')
            ->where('user_id', $id)
            ->where('questionnaire_codes.is_official', 1)
            ->join('users', 'users.id', '=', 'questionnaire_codes.user_id')
            ->join('questionnaires', 'questionnaires.id', '=', 'questionnaire_codes.questionnaire_id')
            ->select('questionnaire_codes.user_id', 'questionnaire_codes.questionnaire_id')
            ->groupBy('users.id', 'questionnaires.id')
            ->get();


        $questionnaire_codes = [];

        foreach ($qc as $key => $value) {

            $questionnaire_codes[$key] = $this->questionnaire_code
                ->where('user_id', $value->user_id)
                ->where('questionnaire_codes.is_official', 1)
                ->where('questionnaire_id', $value->questionnaire_id)
                ->get();
        }

        return view('modules.result.index', compact('questionnaire_codes'));
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
