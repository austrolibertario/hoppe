<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Services\Gateway;
use App\Models\User;
use App\Integrations\Gateways\Erede;
use App\Integrations\Gateways\Mundipagg;
use App\Integrations\Gateways\Pagseguro;

class GatewayTest extends TestCase
{
    /**
     * Test Year Filter
     *
     * @group fast
     * @return void
     */
    public function testCorrectBusinessGateway()
    {
        // Test User with Gateway Erede
        $user = new User;
        $user->gateway_id = Erede::$ID;
        $gateway = new Gateway($user);
        $className = $gateway->getGateway();
        $classInstance = new $className($user);
        $this->assertInstanceOf(Erede::class, $classInstance);
        
        // Test User with Gateway Erede
        $user = new User;
        $user->gateway_id = Mundipagg::$ID;
        $gateway = new Gateway($user);
        $className = $gateway->getGateway();
        $classInstance = new $className($user);
        $this->assertInstanceOf(Mundipagg::class, $classInstance);
        
        // Test User with Gateway Erede
        $user = new User;
        $user->gateway_id = Pagseguro::$ID;
        $gateway = new Gateway($user);
        $className = $gateway->getGateway();
        $classInstance = new $className($user);
        $this->assertInstanceOf(Pagseguro::class, $classInstance);
    }
}
