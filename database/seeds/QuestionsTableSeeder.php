<?php

use Illuminate\Database\Seeder;

use App\GroupQuestion;
use App\Question;
use App\QuestionOption;
use App\UserQuestion;


class QuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'title'=> 'Example Group Question 1',
            'type'=> 'filipino',
            'description'=> 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'is_published'=> '1',
        ];
        $group_question = new GroupQuestion;
        $gq = $group_question->create($data);

        $data = [
            'question'=> 'Sinung pumatay kay Lapu Lapu?',
            'type'=> 'multiple choice',
            'time'=> '5:00',
        ];
        $question = new Question;
        $q = $question->create($data);
        $gq->questions()->attach($q);

        $data = [
            'description'=> 'Magellan',
            'is_correct'=> '1',
            'question_id'=> $q->id,
        ];
        $questionOption = new QuestionOption;
        $qO = $questionOption->create($data);

        $data = [
            'description'=> 'Rajah Sikatuna',
            'is_correct'=> null,
            'question_id'=> $q->id,
        ];
        $questionOption = new QuestionOption;
        $qO = $questionOption->create($data);

        $data = [
            'description'=> 'Rajah Di Mabuntis',
            'is_correct'=> null,
            'question_id'=> $q->id,
        ];
        $questionOption = new QuestionOption;
        $qO = $questionOption->create($data);

        $data = [
            'description'=> 'Datu Puti Soy sauce',
            'is_correct'=> null,
            'question_id'=> $q->id,
        ];
        $questionOption = new QuestionOption;
        $qO = $questionOption->create($data);


    }
}
