<?php
return [
    [
        'pattern'    => '/',
        'controller' => 'site',
        'action'     => 'index',
//                'method' => 'post',
    ],
    [
        'pattern'    => '/login',
        'controller' => 'site',
        'action'     => 'login',
//                'method' => 'post',
    ],
    [
        'pattern'    => '/list',
        'controller' => 'list',
        'action'     => 'index',
    ],
    [
        'pattern'    => '/register',
        'controller' => 'site',
        'action'     => 'register',
    ],
];