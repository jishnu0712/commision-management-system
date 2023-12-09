<?php
$permissionsList = [
    'dashboard' => [
        'view'
    ],
    'users' => [
        'view',
        'add',
        'edit',
        'delete'
    ],
    'department' => [
        'view',
        'add',
        'edit',
        'delete'
    ],
    'doctor' => [
        'view',
        'add',
        'edit',
        'delete'
    ],
    'tranaction' => [
        'view',
        'add',
        'edit',
        'delete'
    ]
];



return [
    'permissionsList' => $permissionsList,
];
