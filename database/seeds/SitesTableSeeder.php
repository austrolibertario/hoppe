<?php

use Illuminate\Database\Seeder;
use App\Models\Site;

class SitesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        \DB::table('sites')->insert(array(
            1 =>
            array(
                'id'           => 1,
                'title'        => 'Piratas do Roger',
                'description'  => '',
                'type'         => 'discussão',
                'favicon'      => '/assets/images/parceiros/logo_piratasroger.jpeg',
                'link'         => 'https://piratasdoroger.com'
            ),
            2 =>
            array(
                'id'           => 2,
                'title'        => 'Detox Politico',
                'description'  => '',
                'email'        => 'discussão',
                'favicon'      => '/assets/images/parceiros/logo_detoxpolitico.jpeg',
                'link'         => 'http://detoxpolitico.com/'
            ),
            3 =>
            array(
                'id'           => 3,
                'title'        => 'Ancap.su',
                'description'  => '',
                'type'         => 'canal',
                'favicon'      => 'http://ancap.su/img/logo%20preto.png',
                'link'         => 'https://www.youtube.com/channel/UCSyG9ph5BJSmPRyzc_eGC4g'
            ),
            4 =>
            array(
                'id'           => 4,
                'title'        => 'Canal do Avelino',
                'description'  => '',
                'email'        => 'blockchain',
                'favicon'      => '/assets/images/favicon.png',
                'link'         => 'https://www.youtube.com/channel/UC549xKR8JvVXLNHvzV_AZsw'
            ),
            5 =>
            array(
                'id'           => 5,
                'title'        => 'Foda-se o Estado',
                'description'  => '',
                'email'        => 'portal',
                'favicon'      => '/assets/images/favicon.png',
                'link'         => 'https://www.youtube.com/channel/UC549xKR8JvVXLNHvzV_AZsw'
            ),
        ));


        if (!App::environment('production')) {
            $sites = factory(Site::class)->times(300)->make();
            Site::insert($sites->toArray());
        }
    }
}
