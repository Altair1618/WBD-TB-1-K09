<?php

$routes = [
    // Web Routes
    '/' => [
        'GET' => ['route' => 'PageController@home', 'middlewares' => [
            'Authentication',
        ]],
    ],

    '/signin' => [
        'GET' => ['route' => 'AuthController@showSignInPage', 'middlewares' => []],
        'POST' => ['route' => 'AuthController@signIn', 'middlewares' => []],
    ],

    '/signup' => [
        'GET' => ['route' => 'AuthController@showSignUpPage', 'middlewares' => []],
        'POST' => ['route' => 'AuthController@signUp', 'middlewares' => []],
    ],

    '/signout' => [
        'POST' => ['route' => 'AuthController@signOut', 'middlewares' => []],
    ],

    '/user/:id' => [
        'GET' => ['route' => 'UserController@showUserPage', 'middlewares' => []],
    ],

    '/courses' => [
        'GET' => ['route' => 'PageController@courses', 'middlewares' => [
            'Authentication',
        ]],
    ],

    '/courses/:id' => [
        'GET' => ['route' => 'PageController@coursesId', 'middlewares' => [
            'Authentication',
        ]],
    ],

    '/catalog' => [
        'GET' => ['route' => 'PageController@catalog', 'middlewares' => [
            'Authentication',
        ]],
    ],

    '/profile' => [
        'GET' => ['route' => 'UserController@showProfilePage', 'middlewares' => [
            'Authentication',
        ]],
    ],

    '/profile/edit' => [
        'GET' => ['route' => 'UserController@showEditProfilePage', 'middlewares' => [
            'Authentication',
        ]],
        'POST' => ['route' => 'UserController@editProfile', 'middlewares' => [
            'Authentication',
        ]],
    ],

    '/admin/users' => [
        'GET' => ['route' => 'AdminUserController@showUsers', 'middlewares' => [
            'AdminAuthentication',
        ]],
    ],

    '/admin/adduser' => [
        'GET' => ['route' => 'AdminUserController@showAddUserPage', 'middlewares' => [
            'AdminAuthentication',
        ]],
        'POST' => ['route' => 'AdminUserController@addUser', 'middlewares' => [
            'AdminAuthentication',
        ]],
    ],

    '/admin/edituser/:id' => [
        'GET' => ['route' => 'AdminUserController@showEditUserPage', 'middlewares' => [
            'AdminAuthentication',
        ]],
        'POST' => ['route' => 'AdminUserController@editUser', 'middlewares' => [
            'AdminAuthentication',
        ]],
    ],

    // API Routes
    '/api/fakultas' => [
        'GET' => ['route' => 'FakultasController@getFakultas', 'middlewares' => []],
    ],

    '/api/prodi' => [
        'GET' => ['route' => 'ProgramStudiController@getProgramStudi', 'middlewares' => []],
    ],

    '/api/courses' => [
        'GET' => ['route' => 'CourseController@getCoursesHTML', 'middlewares' => []],
    ],

    '/api/catalog' => [
        'GET' => ['route' => 'CourseController@getCatalogHTML', 'middlewares' => []],
    ],

    '/api/enroll' => [
        'POST' => ['route' => 'EnrollController@createEnroll', 'middlewares' => []],
    ],

    '/api/admin/users' => [
        'GET' => ['route' => 'AdminUserController@getUsersHTML', 'middlewares' => []],
    ]
];
