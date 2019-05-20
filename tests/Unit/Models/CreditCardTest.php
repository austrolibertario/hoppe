<?php

namespace Tests\Unit\Models;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Services\Gateway;
use App\Models\CustomerAddresse;
use App\Models\Item;
use App\Models\CreditCard;
use App\Integrations\Gateways\Pagseguro;
use App\Integrations\FraudAnalysis\Sitec;

class CreditCardTest extends TestCase
{

    protected function getCreditCard($params = [])
    {
        if ($model = CreditCard::first()){
            return $model;
        }
        return factory(\App\Models\CreditCard::class)->create($params);
    }

    public function testCreditCardBlockIsInvalid()
    {
        $creditCardFactory = $this->getCreditCard();
        $creditCardFactory->is_block = 1;
        $creditCardFactory->save();
        $this->assertEquals(false, $creditCardFactory->isValid());
        $this->assertEquals(true, $creditCardFactory->isBlock());
        $creditCardFactory->is_block = 0;
        $creditCardFactory->save();
        $this->assertEquals(true, $creditCardFactory->isValid());
        $this->assertEquals(false, $creditCardFactory->isBlock());
    }

    public function testCreditCardWithoutValidationIsInvalid()
    {
        $dateInFuture = Carbon::now()->addMonth();
        $creditCardFactory = $this->getCreditCard();
        $creditCardFactory->exp_month = $dateInFuture->format('m');
        $creditCardFactory->exp_year = $dateInFuture->format('Y');
        $creditCardFactory->save();
        $this->assertEquals(false, $creditCardFactory->isValid());
        $dateInPast = Carbon::now()->subWeek()->subWeek()->subWeek()->subWeek()->subWeek();
        $creditCardFactory->exp_month = $dateInPast->format('m');
        $creditCardFactory->exp_year = $dateInPast->format('Y');
        $creditCardFactory->save();
        $this->assertEquals(true, $creditCardFactory->isValid());
    }

    public function testCreditCardValidParamsUpdatedDataWhenIsVerifyNotIsTrue()
    {
        $creditCardFactory = $this->getCreditCard([
            'is_verify' => 0
        ]);
        $params = $this->getParamsFromModel($creditCardFactory);
        // Os dados REais deve retornar True
        $this->assertEquals(true, $creditCardFactory->validadeParams($params));
        // Se trocar os dados, então deve atualizar, já que não verificamos se os dados são reais ou não
        $params['card_name'] = 'RICARDO SIERRA';
        $this->assertEquals(true, $creditCardFactory->validadeParams($params));
        $creditCard = CreditCard::find($creditCardFactory->id);
        $this->assertEquals('RICARDO SIERRA', $creditCard->card_name);
    }

    public function testCreditCardValidParamsNotUpdatedDataWhenIsVerifyIsTrue()
    {
        $creditCardFactory = $this->getCreditCard([
            'is_verify' => 1
        ]);
        $params = $this->getParamsFromModel($creditCardFactory);
        // Os dados REais deve retornar True
        $this->assertEquals(true, $creditCardFactory->validadeParams($params));
        // Se trocar os dados, então deve atualizar, já que não verificamos se os dados são reais ou não
        $params['card_name'] = 'RICARDO SIERRA';
        $this->assertEquals(false, $creditCardFactory->validadeParams($params));
        $creditCard = CreditCard::find($creditCardFactory->id);
        $this->assertNotEquals('RICARDO SIERRA', $creditCard->card_name);
    }

    protected function getParamsFromModel($creditCardFactory)
    {
        $params = [
            'card_name' => $creditCardFactory->card_name,
            'exp_year' => $creditCardFactory->exp_year,
            'exp_month' => $creditCardFactory->exp_month,
            'cvc' => $creditCardFactory->cvc,
            'cpf' => $creditCardFactory->cpf,
        ];

        return $params;
    }
}