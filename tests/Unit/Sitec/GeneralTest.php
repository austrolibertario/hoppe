<?php

namespace Tests\Unit\Sitec;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Sitec\General;

class GeneralTest extends TestCase
{

    /**
     * Test Year Filter
     *
     * @group fast
     * @return void
     */
    public function testGenerateToken()
    {
        $this->assertTrue(strlen(General::generateToken())>16);
        $this->assertFalse(strlen(General::generateToken())<16);
        $this->assertFalse(strlen(General::generateToken())>100);
        $this->assertTrue(strlen(General::generateToken())<100);
    }
}
