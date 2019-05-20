<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Services\FraudAnalysi;
use App\Models\User;
use App\Integrations\FraudAnalysis\Sitec;
use App\Integrations\FraudAnalysis\Clearsale;
use App\Integrations\FraudAnalysis\Konduto;

class FraudAnalysiTest extends TestCase
{
    /**
     * Test Year Filter
     *
     * @group fast
     * @return void
     */
    public function testCorrectBusinessFraudAnalysi()
    {
        // Test User with FraudAnalysi Sitec
        $user = new User;
        $user->fraud_analysi_id = Sitec::$ID;
        $fraud_analysi = new FraudAnalysi($user);
        $className = $fraud_analysi->getFraudAnalysi();
        $classInstance = new $className($user);
        $this->assertInstanceOf(Sitec::class, $classInstance);
        
        // Test User with FraudAnalysi Clearsale
        $user = new User;
        $user->fraud_analysi_id = Clearsale::$ID;
        $fraud_analysi = new FraudAnalysi($user);
        $className = $fraud_analysi->getFraudAnalysi();
        $classInstance = new $className($user);
        $this->assertInstanceOf(Clearsale::class, $classInstance);
        
        // Test User with FraudAnalysi Konduto
        $user = new User;
        $user->fraud_analysi_id = Konduto::$ID;
        $fraud_analysi = new FraudAnalysi($user);
        $className = $fraud_analysi->getFraudAnalysi();
        $classInstance = new $className($user);
        $this->assertInstanceOf(Konduto::class, $classInstance);
    }
}
