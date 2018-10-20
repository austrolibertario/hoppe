<?php

use App\Models\Reply;

return [
    'title'   => 'Respostas',
    'heading' => 'Respostas',
    'single'  => 'Respostas',
    'model'   => Reply::class,

    'columns' => [

        'id' => [
            'title' => 'ID',
        ],
        'user' => [
            'title'    => 'Usuário',
            'sortable' => false,
            'output'   => function ($value, $model) {
                return admin_link(
                    $model->user->name,
                    'users',
                    $model->user_id
                );
            },
        ],
        'topic' => [
            'title'    => 'Tópico',
            'sortable' => false,
            'output'   => function ($value, $model) {
                return model_link(
                    $model->topic->title,
                    'topics',
                    $model->topic_id
                );
            },
        ],
        'is_blocked' => [
            'title'    => 'Está bloqueado?',
        ],
        'vote_count' => [
            'title'    => 'Número de votos',
        ],
        'operation' => [
            'title'  => 'ADMIN',
            'output' => function ($value, $model) {

            },
            'sortable' => false,
        ],
    ],
    'edit_fields' => [
        'user' => [
            'title'              => 'Usuário',
            'type'               => 'relationship',
            'name_field'         => 'name',
            'autocomplete'       => true,
            'search_fields'      => array("CONCAT(id, ' ', name)"),
            'options_sort_field' => 'id',
        ],
        'topic' => [
            'title'              => 'Tópico',
            'type'               => 'relationship',
            'name_field'         => 'title',
            'autocomplete'       => true,
            'search_fields'      => array("CONCAT(id, ' ', title)"),
            'options_sort_field' => 'id',
        ],
        'body_original' => [
            'title'    => 'Markdown Conteúdo original',
            'hint'     => 'Por favor preencha o formato Markdown',
            'type'     => 'textarea',
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
        'vote_count' => [
            'title'    => 'Número de votos',
        ],
    ],
    'filters' => [
        'user' => [
            'title'              => 'Usuário',
            'type'               => 'relationship',
            'name_field'         => 'name',
            'autocomplete'       => true,
            'search_fields'      => array("CONCAT(id, ' ', name)"),
            'options_sort_field' => 'id',
        ],
        'topic' => [
            'title'              => 'Tópico',
            'type'               => 'relationship',
            'name_field'         => 'title',
            'autocomplete'       => true,
            'search_fields'      => array("CONCAT(id, ' ', title)"),
            'options_sort_field' => 'id',
        ],
        'is_blocked' => [
            'title'    => 'Está bloqueado?',
            'type'     => 'enum',
            'options'  => [
                'yes' => 'Sim',
                'no'  => 'Não',
            ],
        ],
        'body_original' => [
            'title'    => 'Responder conteúdo',
        ],
        'vote_count' => [
            'type'                => 'number',
            'title'               => 'Views',
            'thousands_separator' => ',', //optional, defaults to ','
            'decimal_separator'   => '.',   //optional, defaults to '.'
        ],
    ],
    'rules'   => [
        'body_original' => 'required'
    ],
    'messages' => [
        'body_original.required' => 'Por favor preencha a resposta',
    ],
];
