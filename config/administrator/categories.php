<?php

use App\Models\Category;

return [
    'title'   => 'Categorias de Artigos',
    'heading' => 'Categorias de Artigos',
    'single'  => 'Categorias de Artigos',
    'model'   => Category::class,

    'columns' => [
        'id' => [
            'title' => 'ID',
        ],
        'name' => [
            'title'    => 'Nome',
            'sortable' => false,
        ],
        'slug' => [
            'title'    => 'Link',
            'sortable' => false,
        ],
        'description' => [
            'title'    => 'Descrição',
            'sortable' => false,
        ],
        'depth' => [
            'title'    => 'Hierarquia (0 max)',
            'sortable' => false,
        ],
        'operation' => [
            'title'  => 'Admin',
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
            'title' => 'Link Personalizado',
        ],
        'description' => [
            'title' => 'Descrição',
        ],
    ],
    'filters' => [
        'id' => [
            'title' => 'ID',
        ],
        'name' => [
            'title' => 'Nome',
        ],
        'slug' => [
            'title' => 'Link Personalizado',
        ],
        'description' => [
            'title' => 'Descrição',
        ],
    ],
    'rules'   => [
        'name' => 'required|min:1|unique:categories'
    ],
    'messages' => [
        'name.unique'   => 'O nome da categoria é duplicado no banco de dados. Escolha um nome diferente.',
        'name.required' => 'Por favor, certifique-se de que o nome tenha pelo menos um caractere ou mais',
    ],
];
