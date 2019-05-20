<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Services\Gateway;
use App\Models\CustomerAddresse;
use App\Models\Addresse;
use App\Models\Item;
use App\Models\Order;
use App\Models\Customer;
use App\Integrations\Gateways\Pagseguro;
use App\Integrations\FraudAnalysis\Sitec;

class OrderTest extends TestCase
{

    protected $streetInfo = 'Trecho SIA Trecho 3';
    protected $skuInfo = '1CwdcDZ21237AD13WBwxBAZ#ybb65xYw76c92dZ5ZYywz306d6bw34';

    public function testGetDataToCustomerInfocustomerinfo()
    {
        $orderFactory = $this->getOrder();
        // $orderFind = Order::find($orderFactory->id);

        $addresse = Addresse::where([
            'street'               => $this->streetInfo
        ])->first();

        $this->assertTrue(!!$addresse);
    }

    public function testGetDataToCustomerFraudAnalysisInformation()
    {
        $orderFactory = $this->getOrder();
        // $orderFind = Order::find($orderFactory->id);

        $item = Item::where([
            'sku'               => $this->skuInfo
        ])->first();

        $this->assertTrue(!!$item);
    }

    protected function getOrder()
    {
        return factory(\App\Models\Order::class)->create([
            'fraud_analysi_id' => Sitec::$ID,
            'customer_info' => '{"cpf": "59763347092", "name": "AJUDA PASSEPAGUE", "email": "ajuda@passepague.com.br", "address": {"city": "Brasília", "state": "DF", "number": "1", "street": "'.$this->streetInfo.'", "country": "BRA", "zipcode": "71200037", "complement": "até 623 - lado ímpar"}}',
            'fraud_analysis' => '{"cart": {"items": [{"sku": "'.$this->skuInfo.'", "name": "Evento One - Unissex", "risk": "High", "type": "Default", "quantity": "1", "host_hedge": "Normal", "time_hedge": "High", "unit_price": "5", "phone_hedge": "High", "gift_category": "Off", "velocity_hedge": "High", "obscenities_hedge": "Normal", "non_sensical_hedge": "High"}], "is_gift": "1", "returns_accepted": "0"}, "shipping": {"method": "TwoDay"}}'
        ]);
    }
}