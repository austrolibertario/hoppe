<?php

use App\Models\Tag;

return [
    'title'   => 'Tags',
    'heading' => 'Tags',
    'single'  => 'Tags',
    'model'   => Tag::class,

    'columns' => [
        'id' => [
            'title' => 'ID',
        ],
        'name' => [
            'title'    => 'Nome',
            'sortable' => false,
        ],
        'slug' => [
            'title'    => 'Slug',
            'sortable' => false,
        ],
        'description' => [
            'title'    => 'Descrição',
            'sortable' => false,
        ],
        'depth' => [
            'title'    => 'Hierarquia de etiqueta (0 max)',
            'sortable' => false,
        ],
        'count' => [
            'title'    => 'Número de conteúdo marcado',
            'sortable' => false,
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
        'name' => [
            'title' => 'Nome',
        ],
        'slug' => [
            'title' => 'Slug',
        ],
        'description' => [
            'title' => 'Descrição',
        ],
    ],
    'filters' => [
        'id' => [
            'title' => 'ID da tag',
        ],
        'name' => [
            'title' => 'Nome',
        ],
    ],
    'actions' => [],
    'rules'   => [
        'name' => 'required|min:1|unique:tags'
    ],
    'messages' => [
        'name.unique'   => 'O nome da tag é duplicado no banco de dados. Escolha um nome diferente.',
        'name.required' => 'Por favor, certifique-se de que o nome tenha pelo menos um caractere ou mais',
    ],
];
