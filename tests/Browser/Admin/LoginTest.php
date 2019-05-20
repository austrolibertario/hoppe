<?php

namespace Tests\Browser\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use App\Models\User;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends DuskTestCase
{
    use WithFaker;

    public function testExistLoginPage()
    {

        // dd(config('app.url'));
        $user = factory(User::class)->create([
            'email' => 'sierraogrande@sierratecnologia.com.br',
        ]);

        $this->browse(function ($browser) use ($user) {
            $browser->visit('/login')
                    ->type('email', $user->email)
                    ->type('password', 'secret')
                    ->press('Entrar')
                    ->assertPathIs('/home');
        });
    

        // With Two Browsers
        // $this->browse(function ($first, $second) {
        //     $first->loginAs(User::find(1))
        //           ->visit('/home')
        //           ->waitForText('Message');
        
        //     $second->loginAs(User::find(2))
        //            ->visit('/home')
        //            ->waitForText('Message')
        //            ->type('message', 'Hey Taylor')
        //            ->press('Send');
        
        //     $first->waitForText('Hey Taylor')
        //           ->assertSee('Jeffrey Way');
        // });

    }

    // public function testBasicExample()
    // {
    //     $this->visit('/')
    //         ->click('About Us')
    //         ->seePageIs('/about-us');
    // }

    // public function testNewUserRegistration()
    // {
    //     $this->visit('/register')
    //         ->type('Taylor', 'name')
    //         ->check('terms')
    //         ->press('Register')
    //         ->seePageIs('/dashboard');
    // }

    // public function testPhotoCanBeUploaded()
    // {
    //     $this->visit('/upload')
    //         ->name('File Name', 'name')
    //         ->attach($absolutePathToFile, 'photo')
    //         ->press('Upload')
    //         ->see('Upload Successful!');
    // }
}