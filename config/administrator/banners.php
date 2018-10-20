<?php

use App\Models\Banner;

return [
    'title'   => 'Banner',
    'heading' => 'Banner',
    'single'  => 'Banner',
    'model'   => Banner::class,

    'query_filter' => function ($query) {
        if (!Input::get('sortOptions')) {
            $query->orderBy('order', 'ASC');
        }
    },

    'columns' => [
        'id' => [
            'title' => 'ID',
        ],
        'position' => [
            'title' => 'Localização',
        ],
        'title' => [
            'title'  => 'Título',
            'output' => function ($value, $model) {
                return $model->link ? "<a href='{$model->link}' target='_blank'>{$value}</a>" : $value;
            },
        ],
        'target' => [
            'title'  => 'Modo aberto',
            'output' => function ($value) {
                return $value == '_blank' ? 'Nova janela é aberta' : 'Abra este site';
            },
        ],
        'image_url' => [
            'title'    => 'Imagem',
            'sortable' => false,
            'output'   => function ($value, $model) {
                return $value ? "<img src='$value' width='200' height='100'>" : 'N/A';
            },
        ],
        'description' => [
            'title'    => 'Descrição',
            'sortable' => false,
            'output'   => function ($value, $model) {
                return $value ? "<p style='width:250px'>$value</p>" : 'N/A';
            },
        ],
        'order' => [
            'title'    => 'Classificar (classificado por pequeno a grande)',
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
        'position' => [
            'title' => 'Localização',
            'type'     => 'enum',
            'options'  => [
                'website_top' => 'Topo Superior da Página Inicial',
                'footer-sponsor'  => 'Patrocinador de Rodapé',
                'sidebar-sponsor'  => 'Patrocinador do lado direito',
                'sidebar-resources'  => 'Banner na barra lateral direita',
            ],
        ],
        'title' => [
            'title' => 'Título',
        ],
        'target' => [
            'title'    => 'Modo aberto',
            'type'     => 'enum',
            'options'  => [
                '_blank' => 'Nova janela é aberta',
                '_self'  => 'Abra este site',
            ],
            'value' => '_blank',
        ],
        'link' => [
            'title' => 'Endereço do link',
        ],
        'image_url' => [
            'title'             => 'Upload',
            'type'              => 'image',
            'location'          => public_path() . '/uploads/banners/',
            'naming'            => 'random',
            'length'            => 20,
            'size_limit'        => 2,
            'display_raw_value' => false,
        ],
        'description' => [
            'title' => 'Descrição',
            'type'  => 'textarea',
        ],
        'order' => [
            'title' => 'Classificar (classificado por pequeno a grande)',
            'type'  => 'number',
            'value' => 0,
        ],
    ],
    'filters' => [
        'id' => [
            'title' => 'ID',
        ],
        'position' => [
            'title' => 'Localização',
        ],
        'title' => [
            'title' => 'Título',
        ],
        'order' => [
            'title' => 'Classificar (classificado por pequeno a grande)',
            'type'  => 'number',
        ],
    ],
];
