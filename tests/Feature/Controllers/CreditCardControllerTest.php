<?php

namespace Tests\Unit\Controllers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class CreditCardControllerTest extends TestCase
{
    use WithFaker;

    private function getModels()
    {
        $companyToken = \App\Sitec\General::generateToken();
        $customerToken = factory(\App\Models\CustomerToken::class)->create();
        $creditCard = factory(\App\Models\CreditCard::class)->create([
            'cpf' => $customerToken->customer->cpf,
            'card_name' => $customerToken->customer->name,
        ]);
        $creditCardToken = factory(\App\Models\CreditCardToken::class)->create([
            'credit_card_id' => $creditCard->id,
            'customer_token_id' => $customerToken->id,
            'company_token' => $companyToken,
        ]);
        return [$customerToken, $creditCard, $creditCardToken];
    }

    public function testCreditCardControllerRegisterMissingParams()
    {
        $companyToken = \App\Sitec\General::generateToken();
        
        $response = $this->json(
            'POST', '/api/cards/register',
            [
                'cpf' => $this->faker('pt_BR')->cpf,
                'token' => $companyToken
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJson([
                'success' => false,
            ]);
    }

    public function testCreditCardControllerRegisterSuccessAndResponseData()
    {
        list($customerToken, $creditCard, $creditCardToken) = $this->getModels();

        $response = $this->json(
            'POST', '/api/cards/register',
            [
                'cpf' => $customerToken->customer->cpf,
                'user_token' => $customerToken->token,
                'token' => $customerToken->company_token,
                'brand_id' => (string) $this->faker->randomDigitNotNull,
                'card_number' => $this->faker->creditCardNumber,
                'exp_year' => (string) $this->faker->year,
                'exp_month' => (string) $this->faker->month,
                'card_name' => $customerToken->customer->name,
                'is_active' => '1',
                'cvc' => $this->faker->randomDigitNotNull.''.$this->faker->randomDigitNotNull.''.$this->faker->randomDigitNotNull,
                'token' => $creditCardToken->company_token
            ]
        );

        $response
        ->assertStatus(201)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'card_id',
            ]
        ])
        ->assertJson([
            'success' => true,
            'message' => 'Cartao registrado com sucesso.',
        ]);

    }

    public function testCreditCardControllerRegisterDatabaseValidation() 
    {
        list($customerToken, $dbCreditCard, $creditCardToken) = $this->getModels();

        $response = $this->json(
            'POST', '/api/cards/valid',
            [
                'user_token' => $customerToken->token,
                'token' => $creditCardToken->company_token
            ]
        );
        
        $response
        ->assertJson([
            // 'success' => true, // @todo não passamos a flag success nessa API
            'data' => [[
                'id' => $dbCreditCard->id,
                'brand_id' => (string) $dbCreditCard->brand_id,
                'card_number' => $dbCreditCard->card_number,
                'exp_year' => (string) $dbCreditCard->exp_year,
                'exp_month' => (string) $dbCreditCard->exp_month,
                'card_name' => $dbCreditCard->card_name,
                'is_active' => $dbCreditCard->is_active,
                'created_at' => (string) $dbCreditCard->created_at,
                'updated_at' => (string) $dbCreditCard->updated_at,
            ]]
        ]);
    }

    /* /api/cards/edit */

    public function testCreditCardControllerEditMissingParams()
    {
        list($customerToken, $creditCard, $creditCardToken) = $this->getModels();

        $response = $this->json(
            'POST', '/api/cards/edit',
            [
                'cpf' => $creditCard->cpf,
                'token' => $creditCardToken->company_token
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJson([
                'success' => false
            ]);
    }

    public function testCreditCardControllerEditSuccess()
    {
        list($customerToken, $creditCard, $creditCardToken) = $this->getModels();

        $response = $this->json(
            'POST', '/api/cards/edit',
            [
                'user_token' => $customerToken->token,
                'token' => $creditCardToken->company_token,
                'card_id' => $creditCard->id,
                'cpf' => $creditCard->cpf,

                // new values
                'brand_id' => (string) $this->faker->randomDigitNotNull,
                'card_number' => $this->faker->creditCardNumber,
                'exp_year' => (string) $this->faker->year,
                'exp_month' => (string) $this->faker->month,
                'card_name' => $creditCard->card_name,
                'is_active' => '1',
                'cvc' => $this->faker->randomDigitNotNull.''.$this->faker->randomDigitNotNull.''.$this->faker->randomDigitNotNull,
            ]
        );
        
        $response
        ->assertStatus(200)
        ->assertJson([
            'success' => true,
            'data' => [
                'id' => $creditCard->id,
                'brand_id' => !null,
                'card_number' => !null,
                'exp_year' => !null,
                'exp_month' => !null,
                'card_name' => !null,
                'is_active' => '1',
                'created_at' => (string) $creditCard->created_at,
                'updated_at' => !null
            ]
        ]);
    }

    /* api/cards/delete */

    public function testCreditCardControllerDeleteMissingParams()
    {
        list($customerToken, $creditCard, $creditCardToken) = $this->getModels();

        $response = $this->json(
            'POST', '/api/cards/delete',
            [
                'user_token' => $customerToken->token,
                'token' => $creditCardToken->company_token
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJson([
                'success' => false
            ]);
    }
    
    public function testCreditCardControllerDeleteSuccess()
    {
        list($customerToken, $creditCard, $creditCardToken) = $this->getModels();

        $response = $this->json(
            'POST', '/api/cards/delete',
            [
                'user_token' => $customerToken->token,
                'token' => $creditCardToken->company_token,
                'card_id' => $creditCard->id
            ]
        );
        
        $response
        ->assertStatus(200)
        ->assertJson([
            'success' => true
        ]);
    }

    public function testCreditCardControllerDeleteResponseData()
    {
        list($customerToken, $creditCard, $creditCardToken) = $this->getModels();

        $response = $this->json(
            'POST', '/api/cards/delete',
            [
                'user_token' => $customerToken->token,
                'token' => $creditCardToken->company_token,
                'card_id' => $creditCard->id
            ]
        );
        
        $response->assertJson([
            'success' => true,
            'message' => 'Cartão deletado com sucesso.'
        ]);
    }

    /* api/cards/user */
    /** o endpoint não funciona, não sei que retorna, não dá pra fazer TDD */
    public function testCreditCardControllerUserMissingParams()
    {
        $this->markTestSkipped('Pending');

        list($customerToken, $creditCard, $creditCardToken) = $this->getModels();

        $response = $this->json(
            'POST', '/api/cards/user',
            [
                'user_token' => $creditCard->user_token,
                'token' => $creditCardToken->company_token
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJson([
                'success' => false
            ]);
    }

    /** 
     * o endpoint não existe, não sei o que ele retorna, portanto não dá pra fazer TDD
    */
    public function testCreditCardControllerUserSuccess()
    {
        $this->markTestSkipped('Pending');

        list($customerToken, $creditCard, $creditCardToken) = $this->getModels();

        $response = $this->json(
            'POST', '/api/cards/user',
            [
                'user_token' => $creditCard->user_token,
                'token' => $creditCard->token
            ]
        );
        
        $response->assertStatus(200)->assertJson([
            'success' => true,
            'data' => [
                'user_token' => $creditCard->user_token,
                'token' => $creditCard->token
            ]
        ]);
    }

    /* api/cards/validation */
    public function testCreditCardControllerValidationMissingParams()
    {
        list($customerToken, $creditCard, $creditCardToken) = $this->getModels();

        $response = $this->json(
            'POST', '/api/cards/validation',
            [
                'user_token' => $customerToken->token,
                'token' => $creditCardToken->company_token
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJson([
                'success' => false
            ]);
    }

    public function testCreditCardControllerValidationSuccess()
    {
        $this->markTestSkipped('Pending');

        list($customerToken, $creditCard, $creditCardToken) = $this->getModels();

        $response = $this->json(
            'POST', '/api/cards/validation',
            [
                'user_token' => $customerToken->token,
                'token' => $creditCard->token,
                'brand_id' => (string) $creditCard->brand_id,
                'card_number' => (string) $creditCard->card_number,
                'exp_year' => (string) $creditCard->exp_year,
                'exp_month' => (string) $creditCard->exp_month,
                'card_name' => (string) $creditCard->card_name,
                'cvc' => (string) $creditCard->cvc,
                'rede_token' => $creditCard->rede_token,
                'is_active' => $creditCard->is_active
            ]
        );

        $response
        ->assertStatus(200)
        ->assertJson([
            'success' => true
        ]);
    }

    /* api/cards/validate-token */

    public function testCreditCardControllerValidateTokenMissingParams()
    {
        $this->markTestSkipped('Pending');

        list($customerToken, $creditCard, $creditCardToken) = $this->getModels();

        $response = $this->json(
            'POST', '/api/cards/validate-token',
            [
                'user_token' => $customerToken->token,
                'token' => $creditCardToken->company_token
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJson([
                'success' => false
            ]);
    }

    public function testCreditCardControllerValidateTokenSuccess()
    {

        list($customerToken, $creditCard, $creditCardToken) = $this->getModels();

        $response = $this->json(
            'POST', '/api/cards/validate-token',
            [
                'user_token' => $customerToken->token,
                'token' => $creditCardToken->company_token,
                'card_id' => $creditCard->card_id,
                'validate_token' => $creditCard->validate_token,
                'token' => $creditCardToken->company_token
            ]
        );

        $response
        ->assertStatus(200)
        ->assertJson([
            'success' => true
        ]);
    }

     /** Ricardo tá falhando por que falta o rede_token, 
      * acho que deveria ser um campo do credit card
     */
    public function testCreditCardControllerValidateTokenResponseData()
    {
        $this->markTestSkipped('Pending');

        list($customerToken, $creditCard, $creditCardToken) = $this->getModels();

        $response = $this->json(
            'POST', '/api/cards/validate-token',
            [
                'user_token' => $creditCard->user_token,
                'card_id' => $creditCard->id,
                'validate_token' => 'validate_token', // missing info
                // 'rede_token' => $creditCard->rede_token,,
                'token' => $creditCardToken->company_token
            ]
        );
        
        $response->assertJson([
            'user_token' => $creditCard->user_token,
            'token' => $creditCardToken->company_token,
            'card_id' => $creditCard->id,
            'validate_token' => 'validate_token', // missing info
        ]);
    }

    /* api/cards/valid */
    public function testCreditCardControllerValidMissingParams()
    {
        list($customerToken, $creditCard, $creditCardToken) = $this->getModels();

        $response = $this->json(
            'POST', '/api/cards/valid',
            [
                'user_token' => $customerToken->token,
                'token' => $creditCardToken->company_token
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJson([
                'success' => false
            ]);
    }

    public function testCreditCardControllerValidSuccessAndResponseData()
    {

        list($customerToken, $creditCard, $creditCardToken) = $this->getModels();

        $response = $this->json(
            'POST', '/api/cards/valid',
            [
                'user_token' => $customerToken->token,
                'token' => $creditCardToken->company_token
            ]
        );

        $response
        ->assertJson([
            // 'success' => true, // @todo não passamos a flag success nessa API
            'data' => [[
                'id' => $creditCard->id,
                'brand_id' => (string) $creditCard->brand_id,
                'card_number' => (string) $creditCard->card_number,
                'exp_year' => (string) $creditCard->exp_year,
                'exp_month' => (string) $creditCard->exp_month,
                'card_name' => (string) $creditCard->card_name,
                'is_active' => (string) $creditCard->is_active,
                'created_at' => (string) $creditCard->created_at,
                'updated_at' => (string) $creditCard->updated_at,
            ]]
        ]);
    }
}