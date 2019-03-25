<?php

namespace App\Http\Controllers;

use App\Questionnaire;

class HomeController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->group_question = new Questionnaire;
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        $group_questions = $this->group_question->where('is_published', 1)->get();
        return view('modules.home.dashboard', compact('group_questions'));
    }
}
