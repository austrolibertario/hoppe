<?php

use App\Models\Site;

return [
    'title'   => 'Sites',
    'heading' => 'Sites',
    'single'  => 'Sites',
    'model'   => Site::class,

    'columns' => [
        'id' => [
            'title' => 'ID',
        ],
        'favicon' => [
            'title'    => 'Imagem',
            'output'   => function ($value, $model) {
                $value = $model->present()->icon();
                return empty($value) ? 'N/A' : <<<EOD
    <img src="$value" width="16">
EOD;
            },
            'sortable' => false,
        ],
        'title' => [
            'title'    => 'Nome',
            'sortable' => false,
        ],
        'description' => [
            'title'    => 'Descrição',
            'sortable' => false,
            'output'   => function ($value) {
                return '<p style="width:200px">'.$value.'</p>';
            },
        ],
        'link' => [
            'title'    => 'Link',
            'sortable' => false,
            'output'   => function ($value) {
                return '<p style="width:280px">'.$value.'</p>';
            },
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
        'title' => [
            'title'    => 'Nome',
        ],
        'description' => [
            'title'    => 'Descrição',
            'type'     => 'textarea',
        ],
        'link' => [
            'title'    => 'Link',
        ],
        'favicon' => [
            'title'    => 'Imagem',
            'type' => 'file',
            'location' => public_path() . '/uploads/sites/',
            'mimes' => 'jpeg,bmp,png,gif,ico',
        ],
        'order' => [
            'title'    => 'Ordenar',
            'hint'    => 'Quanto maior o valor, mais a frente, o padrão é 0.',
            'value'    => 0,
        ],
        'type' => [
            'title'    => 'Tipo',
            'type'     => 'enum',
            'options'  => [
                'portal' => 'Portal',
                'discussão' => 'Discussão',
                'canal' => 'Canal',
                'blockchain'  => 'Blockchain e Criptomoedas',
                'site_foreign'  => 'Site estrangeiro de Libertarianismo',
                'other'  => 'Outro',
            ],
            'value' => 'site',
        ],
    ],
    'filters' => [
        'id' => [
            'title' => 'ID',
        ],
        'title' => [
            'title' => 'Nome',
        ],
        'link' => [
            'title' => 'Link',
        ],
        'type' => [
            'title'    => 'Tipo',
            'type'     => 'enum',
            'options'  => [
                'portal' => 'Portal',
                'discussão' => 'Discussão',
                'canal' => 'Canal',
                'blockchain'  => 'Blockchain e Criptomoedas',
                'site_foreign'  => 'Site estrangeiro de Libertarianismo',
                'other'  => 'Outro',
            ],
        ],
    ],
];
