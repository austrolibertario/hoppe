<?php

namespace Tests\Unit\Controllers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Customer;
use App\Models\CustomerToken;
use App\Models\Role;

class CustomerControllerTest extends TestCase
{

    // use RefreshDatabase;
    use WithFaker;

    public function testCustomerControllerRegisterMissingParams()
    {
        $companyToken = \App\Sitec\General::generateToken();
        $response = $this->json(
            'POST', '/api/users/register',
            [
                'name' => $this->faker->firstName(),
                'token' => $companyToken
            ]
        );
        
        $response
            ->assertStatus(422)
            ->assertJson([
                'success' => false,
            ]);
    }

    public function testCustomerControllerRegisterSuccess()
    {

        $companyToken = \App\Sitec\General::generateToken();

        $response = $this->json(
            'POST', '/api/users/register',
            [
                'name' => $this->faker->firstName().' '.$this->faker->lastName(),
                'cpf' => $this->faker('pt_BR')->cpf,
                'email' => $this->faker->email,
                'role_id' => Role::$CUSTOMER, // 3 => user
                'token' => $companyToken
            ]
        );

        $response
            ->assertStatus(201)
            ->assertJson([
                'success' => true,
            ]);
    }

    public function testCustomerControllerRegisterResponseData()
    {
        $name = $this->faker->firstName().' '.$this->faker->lastName();
        $cpf = $this->faker('pt_BR')->cpf;
        $email = $this->faker->email;
        $role_id = Role::$CUSTOMER; // 3 => user

        $companyToken = \App\Sitec\General::generateToken();

        $response = $this->json(
            'POST', '/api/users/register',
            [
                'name' => $name,
                'cpf' => $cpf,
                'email' => $email,
                'role_id' => $role_id,
                'token' => $companyToken
            ]
        );
        
        $response
        ->assertStatus(201)
        ->assertJson([
            'success' => true,
            'data' => [
                'user_token' => !null
            ]
        ]);
    }

    public function testCustomerControllerRegisterDuplicadedMailAndCompanyToken()
    {
        $customerToken = factory(CustomerToken::class)->create();

        $response = $this->json(
            'POST', '/api/users/register',
            [
                'name' => $this->faker->firstName().' '.$this->faker->lastName(),
                'cpf' => $this->faker('pt_BR')->cpf,
                'email' => $customerToken->customer->email,
                'role_id' => Role::$CUSTOMER, // 3 => user
                'token' => $customerToken->company_token
            ]
        );

        $response
            ->assertStatus(409)
            ->assertJson([
                'success' => false
            ]);

    }

    public function testCustomerControllerRegisterDuplicadedMailDifferentCompanyToken()
    {
        $customer = factory(Customer::class)->create();
        $companyToken = \App\Sitec\General::generateToken();

        $response = $this->json(
            'POST', '/api/users/register',
            [
                'name' => $this->faker->firstName().' '.$this->faker->lastName(),
                'cpf' => $customer->cpf,
                'email' => $customer->email,
                'role_id' => Role::$CUSTOMER, // 3 => user
                'token' => $companyToken
            ]
        );
        $response
            ->assertStatus(201)
            ->assertJson([
                'success' => true
            ]);

    }

    public function testCustomerControllerRegisterDuplicadedCpfAndCompanyToken()
    {
        $customerToken = factory(CustomerToken::class)->create();

        $response = $this->json(
            'POST', '/api/users/register',
            [
                'name' => $this->faker->firstName().' '.$this->faker->lastName(),
                'cpf' => $customerToken->customer->cpf,
                'email' => $this->faker->safeEmail,
                'role_id' => Role::$CUSTOMER,
                'token' => $customerToken->company_token
            ]
        );
        
        $response
            ->assertStatus(409)
            ->assertJson([
                'success' => false
            ]);

    }

    public function testCustomerControllerRegisterDuplicadedCpfValidCompanyToken()
    {
        $customer = factory(\App\Models\Customer::class)->create();
        $companyToken = \App\Sitec\General::generateToken();

        $response = $this->json(
            'POST', '/api/users/register',
            [
                'name' => $this->faker->firstName().' '.$this->faker->lastName(),
                'cpf' => $customer->cpf,
                'email' => $this->faker->safeEmail,
                'role_id' => Role::$CUSTOMER, // 3 => user
                'token' => $companyToken
            ]
        );
        
        $response
            ->assertStatus(201)
            ->assertJson([
                'success' => true
            ]);

    }

    public function testCustomerControllerUserTokenMissingParams()
    {
        $customer = factory(\App\Models\Customer::class)->create();

        $response = $this->json(
            'POST', '/api/users/user-token',
            [
                'cpf' => $customer->cpf
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJson([
                'success' => false
            ]);
    }

    public function testCustomerControllerUserTokenSuccess()
    {
        $customerToken = factory(\App\Models\CustomerToken::class)->create();

        $this->faker('pt_BR')->cpf;

        $response = $this->json(
            'POST', '/api/users/user-token',
            [
                'cpf' => $customerToken->customer->cpf,
                'token' => $customerToken->company_token
            ]
        );

        $response
        ->assertStatus(200)
        ->assertJson([
            'success' => true
        ]);
    }
    
    public function testCustomerControllerUserTokenResponseData()
    {
        $customerToken = factory(\App\Models\CustomerToken::class)->create();
        $companyToken = $customerToken->company_token;


        $response = $this->json(
            'POST', '/api/users/user-token',
            [
                'cpf' => $customerToken->customer->cpf,
                'token' => $companyToken
            ]
        );

        $response
        ->assertJson([
            'success' => true,
            // 'data' => !null
        ]);
    }
}