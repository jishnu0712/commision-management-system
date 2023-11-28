<?php
$permissionsList = [
    'dashboard' => [
        'view'
    ],
    'users' => [
        'view',
        'add',
        'edit'
    ],
    'department' => [
        'view',
        'add',
        'edit'
    ],
    'doctor' => [
        'view',
        'add',
        'edit'
    ],
    'tranaction' => [
        'view',
        'add'
    ]
];



return [
    'permissionsList' => $permissionsList,
];
