<?php

namespace Tests\Unit\Controllers;

use App\Models\CustomerToken;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Order;
use App\Models\Customer;
use App\Models\CreditCard;

class OrderControllerTest extends TestCase
{
    use WithFaker;

    public function testOrderControllerRegisterMissingParams()
    {
        $companyToken = \App\Sitec\General::generateToken();
        $response = $this->json(
            'POST', '/api/orders/register',
            [
                'origin' => 'app',
                'token' => $companyToken
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJson([
                'success' => false
            ]);
    }

    public function testOrderControllerRegisterSuccess()
    {
        $this->markTestSkipped('Pending');

        $customerToken = factory(CustomerToken::class)->create();
        $companyToken = $customerToken->company_token;
        $customer = $customerToken->customer;

        // creating credit card for that customer
        $creditCard = factory(\App\Models\CreditCard::class)->create([
            'cpf' => $customer->cpf,
            'customer_id' => $customer->id,
            'card_name' => $customer->name,
        ]);
        $creditCardToken = factory(\App\Models\CreditCardToken::class)->create([
            'credit_card_id' => $creditCard->id,
            'company_token' => $companyToken,
        ]);

        $response = $this->json(
            'POST', '/api/orders/register',
            [
                'origin' => 'app',
                'user_token' => $customerToken->token,
                'token' => $companyToken,
                'cardDescription' => 'tickets', // descrição da fatura  
                'rede_token' => 'rede_token', // precisamos setar o rede_token
                'reference' => 'reference', // missing information
                'description' => 'description', // missing information
                'payment_type_id' => '2', // 2 => credit card
                'installments' => 'installments', // missing info
                'is_active' => '1',
                'customer' => [
                    'name' => $customer->name,
                    'email' => $customer->email,
                    'address' => [
                        'street' => $this->faker->streetName,
                        'number' => $this->faker->buildingNumber,
                        'complement' => $this->faker->secondaryAddress,
                        'zipcode' => $this->faker->postcode,
                        'city' => $this->faker->city,
                        'state' => $this->faker->stateAbbr,
                        'country' => 'BRA'
                    ]
                ],
                'device_token' => 'device_token', // missing info
                'device' => 'device', // missing info
                'credit_card_id' => $creditCard->id,
                'card_number' => $creditCard->card_number,
                'exp_year' => $creditCard->exp_year,
                'exp_month' => $creditCard->exp_month,
                'brand_id' => $creditCard->brand_id,
                'card_name' => $creditCard->card_name,
                'cvc' => $creditCard->cvc,
                'bank_slip_id' => 1, // missing info gotta be integer
                'fraud_analysis' => [
                    'cart' => [
                        'is_gift' => 'is_gift', // missing info
                        'returns_accepted' => 'returns_accepted', // missing info
                        'items' => [
                            'gift_category' => 'gift_category', // missing info
                            'host_hedge' => 'host_hedge', // missing info
                            'non_sensical_hedge' => 'non_sensical_hedge', // missing info
                            'obscenities_hedge' => 'obscenities_hedge', // missing info
                            'phone_hedge'=> 'phone_hedge', // missing info
                            'name' => 'name', // missing info
                            'quantity' => 'quantity', // missing info
                            'sku' => 'sku', // missing info
                            'unit_price' => 'unit_price', // missing info
                            'risk' => 'risk', // missing info
                            'time_hedge' => 'time_hedge', // missing info
                            'type' => 'type', // missing info
                            'velocity_hedge' => 'velocity_hedge' // missing info
                        ]
                    ],
                    'shipping' => [
                        'method' => 'method', // missing info
                    ]
                ],
                'konduto' => true,
                'tax_id' => preg_replace('/[^0-9]/', '', $customer->cpf),
                'billing_name' => $this->faker->firstName().' '.$this->faker->lastName(),
                'billing_address' => $this->faker->streetName,
                'billing_complement' => $this->faker->secondaryAddress,
                'billing_city' => $this->faker->city,
                'billing_state' => $this->faker->stateAbbr,
                'billing_zip' => $this->faker->postcode,
                'billing_country' => 'BRA',
                'total' => $this->faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 500),
            ]
        );
        // dd($response);
        $response
        ->assertStatus(201)
        ->assertJson([
            'success' => true
        ]);
    }

    public function testOrderControllerRegisterResponseData()
    {
        $this->markTestSkipped('Pending');

        $customerToken = factory(CustomerToken::class)->create();
        $companyToken = $customerToken->company_token;
        $customer = $customerToken->customer;

        // creating credit card for that customer
        $creditCard = factory(\App\Models\CreditCard::class)->create([
            'cpf' => $customer->cpf,
            'customer_id' => $customer->id,
            'card_name' => $customer->name,
        ]);
        $creditCardToken = factory(\App\Models\CreditCardToken::class)->create([
            'credit_card_id' => $creditCard->id,
            'company_token' => $companyToken,
        ]);

        $response = $this->json(
            'POST', '/api/orders/register',
            [
                'origin' => 'app',
                'user_token' => $customerToken->token,
                'token' => $companyToken,
                'cardDescription' => 'tickets', // descrição da fatura  
                'rede_token' => 'rede_token', // precisamos setar o rede_token
                'reference' => 'reference', // missing information
                'description' => 'description', // missing information
                'payment_type_id' => '2', // 2 => credit card
                'installments' => 'installments', // missing info
                'is_active' => '1',
                'customer' => [
                    'name' => $customer->name,
                    'email' => $customer->email,
                    'address' => [
                        'street' => $this->faker->streetName,
                        'number' => $this->faker->buildingNumber,
                        'complement' => $this->faker->secondaryAddress,
                        'zipcode' => $this->faker->postcode,
                        'city' => $this->faker->city,
                        'state' => $this->faker->stateAbbr,
                        'country' => 'BRA'
                    ]
                ],
                'device_token' => 'device_token', // missing info
                'device' => 'device', // missing info
                'credit_card_id' => $creditCard->id,
                'card_number' => $creditCard->card_number,
                'exp_year' => $creditCard->exp_year,
                'exp_month' => $creditCard->exp_month,
                'brand_id' => $creditCard->brand_id,
                'card_name' => $creditCard->card_name,
                'cvc' => $creditCard->cvc,
                'bank_slip_id' => 1, // missing info gotta be integer
                'fraud_analysis' => [
                    'cart' => [
                        'is_gift' => 'is_gift', // missing info
                        'returns_accepted' => 'returns_accepted', // missing info
                        'items' => [
                            'gift_category' => 'gift_category', // missing info
                            'host_hedge' => 'host_hedge', // missing info
                            'non_sensical_hedge' => 'non_sensical_hedge', // missing info
                            'obscenities_hedge' => 'obscenities_hedge', // missing info
                            'phone_hedge'=> 'phone_hedge', // missing info
                            'name' => 'name', // missing info
                            'quantity' => 'quantity', // missing info
                            'sku' => 'sku', // missing info
                            'unit_price' => 'unit_price', // missing info
                            'risk' => 'risk', // missing info
                            'time_hedge' => 'time_hedge', // missing info
                            'type' => 'type', // missing info
                            'velocity_hedge' => 'velocity_hedge' // missing info
                        ]
                    ],
                    'shipping' => [
                        'method' => 'method', // missing info
                    ]
                ],
                'konduto' => true,
                'tax_id' => preg_replace('/[^0-9]/', '', $customer->cpf),
                'billing_name' => $this->faker->firstName().' '.$this->faker->lastName(),
                'billing_address' => $this->faker->streetName,
                'billing_complement' => $this->faker->secondaryAddress,
                'billing_city' => $this->faker->city,
                'billing_state' => $this->faker->stateAbbr,
                'billing_zip' => $this->faker->postcode,
                'billing_country' => 'BRA',
                'total' => $this->faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 500),
            ]
        );

        $response
        ->assertJsonStructure([
            'success',
            'data' => [
                'nsu',
                'tid',
                'status'
            ]
        ])
        ->assertJson([
            'success' => true,
            'data' => [
                'status' => '1' // 1 => aprovado 
            ]
        ]);
    }

    public function testOrderControllerFindMissingParams()
    {
        factory(Order::class)->create();
        $companyToken = \App\Sitec\General::generateToken();

        $response = $this->json(
            'POST', '/api/orders/find',
            [
                'token' => $companyToken
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJson([
                'success' => false
            ]);
    }

    public function testOrderControllerFindInvalid()
    {
        $companyToken = \App\Sitec\General::generateToken();

        $response = $this->json(
            'POST', '/api/orders/find',
            [
                'token' => $companyToken,
                'tid' => 'oioioi'
            ]
        );

        $response
        ->assertStatus(400)
        ->assertJson([
            'success' => false
        ]);

    }

    public function testOrderControllerFindSuccess()
    {
        $order = factory(Order::class)->create();

        $response = $this->json(
            'POST', '/api/orders/find',
            [
                'token' => $order->company_token,
                'tid' => $order->tid
            ]
        );

        $response
        ->assertStatus(200)
        ->assertJson([
            'success' => true
        ]);
    }

    public function testOrderControllerFindResponseData()
    {
        $order = factory(Order::class)->create();

        $response = $this->json(
            'POST', '/api/orders/find',
            [
                'tid' => $order->tid,
                'token' => $order->gateway
            ]
        );
        
        $response
            ->assertJson([
                'success' => true,
                'data' => [
                    'status' => 'paid',
                    'created_at' => (string) $order->created_at,
                    'updated_at' => (string) $order->updated_at
                ]
            ]);
    }
    
    
}