<?php

Breadcrumbs::for ('dashboard', function ($trail) {
    $trail->push('Dashboard', route('dashboard'));
});

//------------ User ------------//
Breadcrumbs::for ('user.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('User', route('user.index'));
});

//------------ Role ------------//
Breadcrumbs::for ('role.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Role', route('role.index'));
});

//------------ Permission ------------//
Breadcrumbs::for ('permission.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Permission', route('permission.index'));
});

//------------ Group Question ------------//
Breadcrumbs::for ('group-question.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Questionnaire', route('group-question.index'));
});

//------------ Question ------------//
Breadcrumbs::for ('question.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Question', route('question.index'));
});

//------------ Result ------------//
Breadcrumbs::for ('result.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Result', route('result.index'));
});

//------------ Result ------------//
Breadcrumbs::for ('codes', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Codes', route('codes'));
});

//------------ Result ------------//
Breadcrumbs::for ('omni-questionnaire.create', function ($trail, $group_question) {
    $trail->parent('dashboard');
    $trail->push($group_question->title, route('omni-questionnaire.create'));
});
