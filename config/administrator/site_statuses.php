<?php
use App\Models\SiteStatus;

return [
    'title'   => 'Estatísticas de dados',
    'heading' => 'Estatísticas de dados',
    'single'  => 'Estatísticas de dados',
    'model'   => SiteStatus::class,

    'permission' => function () {
        // return Auth::user()->hasRole('Developer');
        return true;
    },

    'action_permissions' => [
        'create' => function ($model) {
            return false;
        },
        'update' => function ($model) {
            return false;
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
        'day' => [
            'title'    => 'Data',
            'sortable' => false,
        ],
        'register_count' => [
            'title'    => 'Número de usuários registrados',
        ],
        'github_regitster_count' => [
            'title'    => 'Número de registro do Github',
        ],
        'wechat_registered_count' => [
            'title'    => 'Número de registro do WeChat',
        ],
        'topic_count' => [
            'title'    => 'Número de tópicos',
        ],
        'reply_count' => [
            'title'    => 'Número de respostas',
        ],
        'image_count' => [
            'title'    => 'Número de fotos',
        ],
        'operation' => [
            'title'    => 'ADMIN',
            'sortable' => false,
        ],
    ],

    'edit_fields' => [
        'day' => [
            'title' => 'Data',
        ],
    ],
    'filters' => [
        'day' => [
            'title' => 'Data',
        ],
    ],
];
