<?php

use Illuminate\Database\Seeder;

class LinksTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('links')->delete();
        \DB::table('links')->insert(array (
            0 =>
            array (
                'id' => 1,
                'title' => 'Piratas do Roger',
                'link' => 'https://piratasdoroger.com',
                'cover' => '/assets/images/parceiros/logo_piratasroger.jpeg',
                'created_at' => '2014-10-12 08:29:15',
                'updated_at' => '2014-10-31 06:01:20',
            ),
            1 =>
            array (
                'id' => 2,
                'title' => 'Detox Politico',
                'link' => 'http://detoxpolitico.com/',
                'cover' => '/assets/images/parceiros/logo_detoxpolitico.jpeg',
                'created_at' => '2014-10-12 08:29:15',
                'updated_at' => '2014-10-31 06:04:39',
            )
        ));

        // if (!App::environment('production')) {
            \DB::table('links')->insert(array (
                0 =>
                array (
                    'id' => 11,
                    'title' => 'Foda-se o Estado',
                    'link' => 'https://foda-seoestado.com',
                    'cover' => 'http://foda-seoestado.com/wp-content/uploads/2016/03/logo2.png',
                    'created_at' => '2014-10-12 08:29:15',
                    'updated_at' => '2014-10-31 06:01:20',
                ),
                1 =>
                array (
                    'id' => 12,
                    'title' => 'Ancap.su',
                    'link' => 'http://ancap.su/',
                    'cover' => 'http://ancap.su/img/logo%20preto.png',
                    'created_at' => '2014-10-12 08:29:15',
                    'updated_at' => '2014-10-31 06:04:39',
                ),
                2 =>
                array (
                    'id' => 13,
                    'title' => 'Rothbard Brasil',
                    'link' => 'http://rothbardbrasil.com/',
                    'cover' => 'http://rothbardbrasil.com/wp-content/uploads/2018/05/Rothbard-Hoppe-320x202.jpg',
                    'created_at' => '2014-10-12 08:29:15',
                    'updated_at' => '2014-10-31 06:05:03',
                )
            ));
        // }


    }
}
