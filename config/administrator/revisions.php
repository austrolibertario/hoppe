<?php

use App\Models\Revision;

return [
    'title'   => 'Registro de operação',
    'heading' => 'Registro de operação',
    'single'  => 'Registro de operação',
    'model'   => Revision::class,

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
    ],

    'columns' => [
        'id' => [
            'title' => 'ID',
        ],
        'revisionable_type' => [
            'title' => 'Model Gravado'
        ],
        'revisionable_id' => [
            'title'    => 'id Gravado',
            'sortable' => false,
        ],
        'user' => [
            'title'        => 'Usuário operacional',
            'relationship' => 'user',
            'select'       => "(:table).name",
        ],
        'key' => [
            'title' => 'Campo operacional',
        ],
        'logs' => [
            'title'  => 'Log operacional',
            'output' => function ($value, $model) {
                $html = "<div style='text-align:left;'>
                            <div style='text-indent:2em'>'old_value'&nbsp;&nbsp;&nbsp;=> '$model->old_value',</div>
                            <div style='text-indent:2em'>'new_value' => '$model->new_value'</div>
                        </div>";
                return $html;
            }
        ],
        'created_at' => [
            'title' => 'Tempo de operação'
        ]
    ],

    'edit_fields' => [
        'id' => [
            'title' => 'id'
        ]
    ],
    'filters' => [
        'revisionable_type' => [
            'title' => 'Model Gravado'
        ],
        'revisionable_id' => [
            'title' => 'Id Gravado',
        ],
        'user' => [
            'title'  => 'Usuário operacional',
            'type'   => 'relationship',
            'select' => "(:table).name",
        ],
        'key' => [
            'title' => 'Campo operacional',
        ],
        'old_value' => [
            'title' => 'Valor antes da modificação'
        ],
        'new_value' => [
            'title' => 'Valor modificado'
        ],
    ],

    'actions' => [],
];
