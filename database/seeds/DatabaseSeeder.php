<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    protected $productionSeeders = [
        'UsersTableSeeder',
        'BlogTableSeeder',
        'CategoriesTableSeeder',
        'BannersTableSeeder',
        'LinksTableSeeder',
        'SitesTableSeeder',
    ];

    protected $seeders = [
        'TopicsTableSeeder',
        'RepliesTableSeeder',
        'FollowersTableSeeder',
        'ActiveUsersTableSeeder',
        'HotTopicsTableSeeder',
        'OauthClientsTableSeeder',
    ];

    public function run()
    {
        Model::unguard();

        foreach ($this->productionSeeders as $seedClass) {
            $this->call($seedClass);
        }

        if (!App::environment('production')) {
            foreach ($this->seeders as $seedClass) {
                $this->call($seedClass);
            }
        }

        Model::reguard();
    }
}
