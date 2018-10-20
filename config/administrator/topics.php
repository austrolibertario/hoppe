<?php

use App\Models\Topic;

return [
    'title'   => 'Tópico',
    'heading' => 'Tópico',
    'single'  => 'Tópico',
    'model'   => Topic::class,

    'columns' => [

        'id' => [
            'title' => 'ID',
        ],
        'title' => [
            'title'    => 'Tópico',
            'sortable' => false,
            'output'   => function ($value, $model) {
                return '<div style="max-width:260px">' .model_link($value, 'topics', $model->id). '</div>';
            },
        ],
        'user' => [
            'title'    => 'Usuário',
            'sortable' => false,
            'output'   => function ($value, $model) {

                $avatar = $model->user->present()->gravatar();
                $value = empty($avatar) ? 'N/A' : '<img src="'.$avatar.'" style="height:44px;width:44px"> ' . $model->user->name;

                return model_link($value, 'users', $model->id);
            },
        ],
        'excerpt' => [
            'title'    => 'Resumo',
            'sortable' => false,
            'output'   => function ($value, $model) {
                return '<div style="max-width:320px">' .model_link($value, 'topics', $model->id). '</div>';
            },
        ],
        'order' => [
            'title'    => 'Ordenar',
        ],
        'category' => [
            'title'    => 'Ordenar',
            'sortable' => false,
            'output'   => function ($value, $model) {
                return admin_link(
                    $model->category->name,
                    'categories',
                    $model->category_id
                );
            },
        ],
        'is_excellent' => [
            'title'    => 'Recomendado？',
        ],
        'is_blocked' => [
            'title'    => 'Bloqueado？',
        ],
        'reply_count' => [
            'title'    => 'Comentário',
        ],
        'view_count' => [
            'title'    => 'Visualizar',
        ],
        'vote_count' => [
            'title'    => 'Votar',
        ],

        'operation' => [
            'title'  => 'ADMIN',
            'output' => function ($value, $model) {

            },
            'sortable' => false,
        ],
    ],
    'edit_fields' => [
        'title' => [
            'title'    => 'Título',
            'sortable' => false,
        ],
        'user' => [
            'title'              => 'Usuário',
            'type'               => 'relationship',
            'name_field'         => 'name',
            'autocomplete'       => true,
            'search_fields'      => array("CONCAT(id, ' ', name)"),
            'options_sort_field' => 'id',
        ],
        'category' => [
            'title'              => 'Classificação',
            'type'               => 'relationship',
            'name_field'         => 'name',
            'search_fields'      => array("CONCAT(id, ' ', name)"),
            'options_sort_field' => 'id',
        ],
        'body_original' => [
            'title'    => 'Markdown Conteúdo original',
            'hint'     => 'Por favor, use o formato Markdown para preencher',
            'type'     => 'textarea',
        ],
        'order' => [
            'title'    => 'Ordenar',
        ],
        'is_excellent' => [
            'title'    => 'É recomendado?',
            'type'     => 'enum',
            'options'  => [
                'yes' => 'Sim',
                'no'  => 'Não',
            ],
            'value' => 'no',
        ],
        'is_blocked' => [
            'title'    => 'Está bloqueado?',
            'type'     => 'enum',
            'options'  => [
                'yes' => 'Sim',
                'no'  => 'Não',
            ],
            'value' => 'no',
        ],
        'reply_count' => [
            'title'    => 'Comentário',
        ],
        'view_count' => [
            'title'    => 'Visualizar',
        ],
        'vote_count' => [
            'title'    => 'Votar',
        ],
    ],
    'filters' => [
        'id' => [
            'title' => 'ID do conteúdo',
        ],
        'user' => [
            'title'              => 'Usuário',
            'type'               => 'relationship',
            'name_field'         => 'name',
            'autocomplete'       => true,
            'search_fields'      => array("CONCAT(id, ' ', name)"),
            'options_sort_field' => 'id',
        ],
        'category' => [
            'title'              => 'Classificação',
            'type'               => 'relationship',
            'name_field'         => 'name',
            'search_fields'      => array("CONCAT(id, ' ', screen_name)"),
            'options_sort_field' => 'id',
        ],
        'body_original' => [
            'title'    => 'Markdown Conteúdo original',
        ],
        'order' => [
            'title'    => 'Ordenar',
        ],
        'is_excellent' => [
            'title'    => 'É recomendado?',
            'type'     => 'enum',
            'options'  => [
                'yes' => 'Sim',
                'no'  => 'Não',
            ],
        ],
        'is_blocked' => [
            'title'    => 'Está bloqueado?',
            'type'     => 'enum',
            'options'  => [
                'yes' => 'Sim',
                'no'  => 'Não',
            ],
        ],
        'view_count' => [
            'type'                => 'number',
            'title'               => 'Views',
            'thousands_separator' => ',', //optional, defaults to ','
            'decimal_separator'   => '.',   //optional, defaults to '.'
        ],
    ],
    'rules'   => [
        'title' => 'required'
    ],
    'messages' => [
        'title.required' => 'Por favor, preencha o título',
    ],
];
