<?php

use App\Models\Role;

return [
    'title'   => 'Grupo de usuários',
    'heading' => 'Grupo de usuários',
    'single'  => 'Grupo de usuários',
    'model'   => Role::class,

    'permission'=> function()
    {
        return Auth::user()->may('manage_users');
    },

    'columns' => [
        'id' => [
            'title' => 'ID',
        ],
        'display_name' => [
            'title' => 'Nome de exibição',
            'sortable' => false
        ],
        'name' => [
            'title' => 'Identificação'
        ],
        'operation' => [
            'title'  => 'ADMIN',
            'output' => function ($value, $model) {
                return $value;
            },
            'sortable' => false,
        ],
    ],

    'edit_fields' => [
        'display_name' => [
            'title' => 'Nome de exibição',
        ],
        'name' => [
            'title' => 'Identificação',
        ],
        'description' => [
            'type' => 'textarea',
            'title' => 'Descrição',
        ],
        'perms' => array(
            'type' => 'relationship',
            'title' => 'Permissão',
            'name_field' => 'display_name',
        ),
    ],

    'filters' => [
        'id' => [
            'title' => 'ID',
        ],
        'display_name' => [
            'title' => 'Nome de exibição'
        ],
        'name' => [
            'title' => 'Identificação',
        ]
    ],

    'rules' => [
        'name' => 'required|max:15|unique:roles,name',
        'display_name' => 'required|unique:roles,display_name'
    ],

    'messages' => [
        'name.required' => 'ID não pode estar vazio',
        'name.unique' => 'Identificação já existe',
        'display_name.required' => 'O nome de exibição não pode estar vazio',
        'display_name.unique' => 'O nome de exibição já existe'
    ]
];
