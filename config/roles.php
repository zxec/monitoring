<?php

return [
    'permissions' => [
        'articles' => [
            'read', 'create', 'edit', 'delete'
        ],
        'users' => [
            'read', 'create', 'edit', 'delete'
        ],
        'departments' => [
            'read', 'create', 'edit', 'delete'
        ],
        'positions' => [
            'read', 'create', 'edit', 'delete'
        ],
        'roles' => [
            'read', 'create', 'edit', 'delete'
        ],
        'statistics' => [
            'read', 'create', 'edit', 'delete'
        ],
    ],
    'roles' => [
        'admin' => 'Администратор',
        'manager' => 'Менеджер',
        'employee' => 'Пользователь',
    ],
    'role_permission' => [
        'admin' => [
            'read articles', 'create articles', 'edit articles', 'delete articles',
            'read users', 'create users', 'edit users', 'delete users',
            'read departments', 'create departments', 'edit departments', 'delete departments',
            'read positions', 'create positions', 'edit positions', 'delete positions',
            'read roles', 'create roles', 'edit roles', 'delete roles',
            'read statistics', 'create statistics', 'edit statistics', 'delete statistics',
        ],
        'manager' => [
            'read articles', 'edit articles',
            'read users', 'edit users',
            'read departments', 'edit departments',
            'read positions', 'edit positions',
            'read roles', 'edit roles',
        ],
        'employee' => [
            'read articles',
            'read users',
            'read departments',
            'read positions',
            'read roles',
        ],
    ]
];
