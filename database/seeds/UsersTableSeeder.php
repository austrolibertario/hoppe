<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $password = bcrypt('123456');

        \DB::table('users')->insert(array(
            0 =>
            array(
                'id'          => 1,
                'name'        => 'Ricardo Sierra',
                'password'      => $password,
                'email'        => 'ricardo@sierratecnologia.com.br',
                'github_name' => 'ricardosierra',
                'verified'  => 1
            ),
        ));
        \DB::table('users')->insert(array(
            1 =>
            array(
                'id'          => 2,
                'name'        => 'Felipe Ojeda',
                'password'      => $password,
                'email'        => 'felipecojeda@gmail.com',
                'verified'  => 1
            ),
            2 =>
            array(
                'id'          => 3,
                'name'        => 'Snella',
                'password'      => $password,
                'email'        => 'allens_ra@yahoo.com.br',
                'verified'  => 1
            ),
            3 =>
            array(
                'id'          => 4,
                'name'        => 'Diogo Pasa',
                'password'      => $password,
                'email'        => 'diogo@h3sotospeak.com',
                'verified'  => 1
            ),
            4 =>
            array(
                'id'          => 5,
                'name'        => 'Victor Sal',
                'password'      => $password,
                'email'        => 'victor@h3sotospeak.com',
                'verified'  => 1
            ),
            5 =>
            array(
                'id'          => 6,
                'name'        => 'João',
                'password'      => $password,
                'email'        => 'joao@hoppebrasil.org',
                'verified'  => 1
            ),
            6 =>
            array(
                'id'          => 7,
                'name'        => 'Chris Bastiat',
                'password'      => $password,
                'email'        => 'chrisbaggins633@outlook.com',
                'verified'  => 1
            )
        ));

        //  Convidados
        \DB::table('users')->insert(array(
            2 =>
            array(
                'id'          => 8,
                'name'        => 'Arthur Morisson Guimarães',
                'password'      => $password,
                'email'        => 'arthur@libertario.com',
                'verified'  => 1
            ),
            3 =>
            array(
                'id'          => 9,
                'name'        => 'Vinicius Botti',
                'password'      => $password,
                'email'        => 'vinicius@libertario.com',
                'verified'  => 1
            ),
            4 =>
            array(
                'id'          => 10,
                'name'        => 'Rei dos Piratas',
                'password'      => $password,
                'email'        => 'dom@lancasites.com',
                'verified'  => 1
            ),
        ));


        if (!App::environment('production')) {
            $users = factory(User::class)->times(49)->make()->each(function ($user, $i) use ($password)  {
                $user->password = $password;
                $user->github_id = $i + 1;
            });

            User::insert($users->toArray());

            $hall_of_fame = Role::addRole('HallOfFame', 'Corredor da fama');
            $users = User::all();
            foreach ($users as $key => $user) {
                $user->attachRole($hall_of_fame);
            }
        }

    }
}
