<?php

return [
    'roles' => [
        'super_user' => [
            'name'      => 'admin.roles.super_user',
            'sub_roles' => ['admin', 'employee'],
        ],
        'admin'      => [
            'name'      => 'admin.roles.admin',
            'sub_roles' => ['employee'],
        ],
        'employee'   => [
            'name'      => 'admin.roles.employee',
            'sub_roles' => [],
        ]
    ],
];
