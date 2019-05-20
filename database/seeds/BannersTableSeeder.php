<?php

use Illuminate\Database\Seeder;

class BannersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('banners')->delete();
        \DB::table('banners')->insert(array (
            0 =>
            array (
                'id' => 1,
                'position' => 'sidebar-sponsor',
                'order' => 1,
                'image_url' => 'https://h3sotospeak.com/assets/images/parceiros/logo_piratasroger.jpeg',
                'title' => _t('Piratas do Roger'),
                'link' => 'https://piratasdoroger.com',
                'target' => '_blank',
                'description' => _t('Baixe Livros Grátis '),
                'created_at' => '2016-07-12 11:31:36',
                'updated_at' => '2016-07-12 11:31:36',
            ),
            1 =>
            array (
                'id' => 3,
                'position' => 'sidebar-resources',
                'order' => 2,
                'image_url' => 'https://h3sotospeak.com/assets/images/parceiros/logo_detoxpolitico.jpeg',
                'title' => _t('Detox Politico'),
                'link' => 'http://detoxpolitico.com/',
                'target' => '_blank',
                'description' => _t('Detox Politico'),
                'created_at' => '2016-07-12 11:32:25',
                'updated_at' => '2016-07-12 11:32:25',
            )
        ));

        if (!App::environment('production')) {
            \DB::table('banners')->insert(array (
                0 =>
                array (
                    'id' => 10,
                    'position' => 'website_top',
                    'order' => 1,
                    'image_url' => 'https://h3sotospeak.com/uploads/banners/qCpz5a1iBETEfnNEAkGe.png',
                    'title' => _t('Foda-se o Estado'),
                    'link' => 'https://foda-seoestado.com',
                    'target' => '_blank',
                    'description' => _t('Comunidade do Foda-se o Estado'),
                    'created_at' => '2016-07-12 11:31:36',
                    'updated_at' => '2016-07-12 11:31:36',
                ),
                1 =>
                array (
                    'id' => 13,
                    'position' => 'website_top',
                    'order' => 3,
                    'image_url' => 'https://h3sotospeak.com/uploads/banners/YCkIqPrz6v8MV0keu4pW.png',
                    'title' => _t('Referência Rápida do Laravel'),
                    'link' => 'https://cs.h3sotospeak.com/',
                    'target' => '_blank',
                    'description' => _t('Tabela de referência rápida para consulta rápida de funções de quadro, suporte para acesso de telefone celular, suporte para versões em chinês e inglês'),
                    'created_at' => '2016-07-12 11:32:25',
                    'updated_at' => '2016-07-12 11:32:25',
                ),
                2 =>
                array (
                    'id' => 14,
                    'position' => 'website_top',
                    'order' => 2,
                    'image_url' => 'https://h3sotospeak.com/uploads/banners/0wgbAVabZB9GA2yaU8AY.png',
                    'title' => _t('Trabalho legal'),
                    'link' => 'categories/1',
                    'target' => '_self',
                    'description' => _t('Laravel \ PHP relacionado recrutamento, procura de emprego, terceirização, pegar, trabalho remoto ...'),
                    'created_at' => '2016-07-12 11:33:05',
                    'updated_at' => '2016-07-12 15:03:56',
                ),
                3 =>
                array (
                    'id' => 15,
                    'position' => 'website_top',
                    'order' => 4,
                    'image_url' => 'https://h3sotospeak.com/uploads/banners/0pyH7UgXhF7PTBkLZRak.png',
                    'title' => _t('PSR PHP Standard Specification'),
                    'link' => 'https://psr.phphub.org/',
                    'target' => '_blank',
                    'description' => _t('PSR A especificação PHP desenvolvida pelo PHP FIG é o padrão de prática para desenvolvimento em PHP.'),
                    'created_at' => '2016-07-12 11:33:40',
                    'updated_at' => '2016-07-12 11:33:40',
                ),
                4 =>
                array (
                    'id' => 16,
                    'position' => 'website_top',
                    'order' => 6,
                    'image_url' => 'https://h3sotospeak.com/uploads/banners/HCNo4rSRxIpK12yDL13U.png',
                    'title' => _t('Introdução ao PHP'),
                    'link' => 'http://laravel-china.github.io/php-the-right-way/',
                    'target' => '_blank',
                    'description' => _t('O caminho certo para aprender PHP'),
                    'created_at' => '2016-07-12 11:34:07',
                    'updated_at' => '2016-07-12 11:34:07',
                ),
                5 =>
                array (
                    'id' => 17,
                    'position' => 'website_top',
                    'order' => 5,
                    'image_url' => 'https://h3sotospeak.com/uploads/banners/EptWCkT1qDDvtn5nV2id.png',
                    'title' => _t('Documentação da API do Laravel'),
                    'link' => 'http://h3sotospeak.com/api/5.1/',
                    'target' => '_blank',
                    'description' => _t('Documentação da Laravel sobre as versões 5.1, 5.2, 5.3'),
                    'created_at' => '2016-07-12 11:34:36',
                    'updated_at' => '2016-07-12 15:05:09',
                ),
                6 =>
                array (
                    'id' => 18,
                    'position' => 'sidebar-resources',
                    'order' => 5,
                    'image_url' => 'https://h3sotospeak.com/uploads/banners/EptWCkT1qDDvtn5nV2id.png',
                    'title' => _t('Laravel API Documento'),
                    'link' => 'http://h3sotospeak.com/api/5.1/',
                    'target' => '_blank',
                    'description' => _t('Laravel API Documento, coberto 5.1, 5.2, 5.3 Versão'),
                    'created_at' => '2016-07-12 11:34:36',
                    'updated_at' => '2016-07-12 15:05:09',
                ),
                7 =>
                array (
                    'id' => 19,
                    'position' => 'sidebar-resources',
                    'order' => 6,
                    'image_url' => 'https://h3sotospeak.com/uploads/banners/HCNo4rSRxIpK12yDL13U.png',
                    'title' => _t('Começando PHP Way'),
                    'link' => 'http://laravel-china.github.io/php-the-right-way/',
                    'target' => '_blank',
                    'description' => _t('Aprendizagem correta PHP Way'),
                    'created_at' => '2016-07-12 11:34:07',
                    'updated_at' => '2016-07-12 11:34:07',
                ),
            ));

        }

    }
}
