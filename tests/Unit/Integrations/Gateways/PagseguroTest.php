<?php

namespace Tests\Unit\Integrations\Gateways;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Services\Gateway;
use App\Models\User;
use App\Integrations\Gateways\Pagseguro;

class PagseguroTest extends TestCase
{
    /**
     * Test Year Filter
     *
     * @group fast
     * @return void
     */
    // public function testRegisterCreditCard()
    // {
    //     // Cria Usuário para o teste na Pagseguro
    //     $user = $this->getUser();
    //     $creditCard = factory(\App\Models\CreditCard::class)->create([
    //         'cpf' => '85914454069',
    //         'brand_id' => 1,
    //         'card_number' => '4984538181907024',
    //         'exp_year' => '21',
    //         'exp_month' => '11',
    //         'card_name' => 'RODRIGO G PINHEIRO',
    //         'is_active' => '1',
    //         'cvc' => '776'
    //     ]);
    //     $pagseguro = new Pagseguro($user);
    //     $this->assertTrue($pagseguro->registerCreditCard($creditCard));
    // }

    
    // public function testRegisterCustomer()
    // {
    //     // Cria Usuário para o teste na Pagseguro
    //     $user = $this->getUser();
    //     $customer = factory(\App\Models\Customer::class)->create([

    //     ]);
    //     $pagseguro = new Pagseguro($user);
    //     $this->assertTrue($pagseguro->registerCustomer($customer));
    // }


    public function testRegisterOrder()
    {
        // Cria Usuário para o teste na Pagseguro
        $user = $this->getUser();




        $customerToken = factory(\App\Models\CustomerToken::class)->create();
        $creditCardToken = factory(\App\Models\CreditCardToken::class)->create();
        $creditCardToken = factory(\App\Models\CreditCardToken::class)->create();


        $order = factory(\App\Models\Order::class)->create([
            'user_id' => $user->id,
            'customer_token_id' => $customerToken->id,
            'credit_card_token_id' => $creditCardToken->id,
            'total' => 100,
        ]);
        $pagseguro = new Pagseguro($user);
        $this->assertTrue($pagseguro->registerOrder($order));
    }

    protected function getUser()
    {
        
        return factory(\App\Models\User::class)->create([
            // 'gateway_pagseguro_public' => 'ricardo@sierratecnologia.com.br',
            // 'gateway_pagseguro_secret' => 'E6847D914E9B4AE5BA76C41B518E4D71',
            'gateway_pagseguro_public' => 'pagseguro@passepague.com.br',
            'gateway_pagseguro_secret' => '7899389154E840EF8B442E60409EA927', //Rqu00171
            'gateway_id' => Pagseguro::$ID
        ]);
    }
}
