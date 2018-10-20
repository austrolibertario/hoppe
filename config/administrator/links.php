<?php

use App\Models\Link;

return [
    'title'   => 'Link amigável',
    'heading' => 'Link amigável',
    'single'  => 'Link amigável',
    'model'   => Link::class,

    'columns' => [
        'id' => [
            'title' => 'ID',
        ],
        'title' => [
            'title'    => 'Nome',
            'sortable' => false,
        ],
        'link' => [
            'title'    => 'Link',
            'sortable' => false,
        ],
        'cover' => [
            'title'    => 'Imagem',
            'sortable' => false,
            'output'   => function ($value, $model) {
                return $value ? "<img src='$value' width='200' height='100'>" : 'N/A';
            },
        ],
        'is_enabled' => [
            'title'    => 'Seja para ativar',
            'output'   => function ($value) {
                return admin_enum_style_output($value);
            },
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
        'title' => [
            'title'    => 'Nome',
        ],
        'link' => [
            'title'    => 'Link',
        ],
        'cover' => [
            'title'             => 'Cover',
            'type'              => 'image',
            'location'          => public_path() . '/uploads/banners/',
            'naming'            => 'random',
            'length'            => 20,
            'size_limit'        => 2,
            'display_raw_value' => false,
        ],
    ],
    'filters' => [
        'id' => [
            'title' => 'Label ID',
        ],
        'title' => [
            'title' => 'Nome',
        ],
    ],
    'actions' => [
        'disable_link' => [
            'title'    => 'Desabilitar',
            'messages' => array(
                'active'  => 'Processando...',
                'success' => 'Processamento bem sucedido',
                'error'   => 'O processamento falhou, por favor tente novamente',
            ),
            'permission' => function ($model) {
                return $model->is_enabled == 'yes';
            },
            'action' => function ($model) {
                $model->update(['is_enabled' => 'no']);
                return true;
            }
        ],
        'enable_link' => [
            'title'    => 'Ativar',
            'messages' => array(
                'active'  => 'Processando...',
                'success' => 'Processamento bem sucedido',
                'error'   => 'O processamento falhou, por favor tente novamente',
            ),
            'permission' => function ($model) {
                return $model->is_enabled == 'no';
            },
            'action' => function ($model) {
                $model->update(['is_enabled' => 'yes']);
                return true;
            }
        ],


    ],
];
