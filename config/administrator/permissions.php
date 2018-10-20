<?php
use App\Models\Permission;

return [
    'title'   => 'Permissões do grupo de usuários',
    'heading' => 'Permissões do grupo de usuários',
    'single'  => 'Permissões do grupo de usuários',
    'model'   => Permission::class,

    'permission' => function () {
        return Auth::user()->may('manage_users');
    },

    'action_permissions' => [
        'create' => function ($model) {
            return true;
        },
        'update' => function ($model) {
            return true;
        },
        'delete' => function ($model) {
            return false;
        },
        'view' => function ($model) {
            return true;
        },
    ],

    'columns' => [
        'id' => [
            'title' => 'ID',
        ],
        'name' => [
            'title'    => 'Nome',
            'sortable' => false,
        ],
        'display_name' => [
            'title'    => 'Nome a Exibir',
            'sortable' => false,
        ],
        'description' => [
            'title'    => 'Descrição',
            'sortable' => false,
            'output'   => function ($value, $model) {
                return empty($value) ? 'N/A' : $value;
            },
        ],
        'roles' => [
            'title'  => 'Grupo de usuários',
            'output' => function ($value, $model) {
                $model->load('roles');
                $result = [];
                foreach ($model->roles as $role) {
                    $result[] = $role->display_name;
                }

                return empty($result) ? 'N/A' : implode($result, ' | ');
            },
            'sortable' => false,
        ],
        'operation' => [
            'title'    => 'ADMIN',
            'sortable' => false,
        ],
    ],

    'edit_fields' => [
        'name' => [
            'title' => 'Marcação (por favor modifique com cuidado)',
        ],
        'display_name' => [
            'title' => 'Nome a Exibir',
        ],
        'description' => [
            'title' => 'Descrição',
        ],
    ],
    'filters' => [
        'name' => [
            'title' => 'Mark',
        ],
        'display_name' => [
            'title' => 'Nome a Exibir',
        ],
        'description' => [
            'title' => 'Descrição',
        ],
    ],

    'actions' => [],
];
