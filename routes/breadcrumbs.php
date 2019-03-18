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
