<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Value;

class ValueTest extends TestCase
{

    public function setUp()
    {
        parent::setUp();
        Value::truncate();
        Value::set(account()->base_value);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertEquals(Value::count(), 1);

        Value::add(50);
        $this->assertEquals(Value::getValue(), account()->base_value + 50);

        Value::add(-100);
        $this->assertEquals(Value::getValue(), account()->base_value - 50);

        Value::set(500);
        Value::set(501);
        Value::set(502);
        Value::set(499);
        $this->assertEquals(Value::getValue(), 499);

        $twoLasts = [];
        $twoLasts = Value::getTwoLasts();
        
        $this->assertEquals(count($twoLasts), 2);
        $this->assertEquals($twoLasts[0]->value, 499);
        $this->assertEquals($twoLasts[1]->value, 502);

        $this->actualValue = Value::getValue();
    }
}
