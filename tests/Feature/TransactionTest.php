<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use \App\Value;
use \App\Transaction;
use \Carbon\Carbon;

class TransactionTest extends TestCase
{

    protected $transaction1;
    protected $transaction2;
    protected $transaction3;
    protected $value;

    public function setUp()
    {
        parent::setUp();
        Value::truncate();
        Transaction::truncate();
        Value::set(account()->base_value);

        $this->transaction1 = [
            'date' => Carbon::now(),
            'value' => -50,
            'title' => 'test title1',
            'to' => 'Simply Market',
        ];

        $this->transaction2 = [
            'date' => Carbon::yesterday(),
            'value' => 100,
            'description' => 'test desc2',
            'from' => 'Maman',
        ];

        $this->transaction3 = [
            'date' => Carbon::tomorrow(),
            'value' => 30,
            'from' => 'Papa',
            'credit_card' => 0
        ];
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreation()
    {
        $this->value = Value::getValue();
        $this->assertEquals($this->value, account()->base_value);

        Transaction::add($this->transaction1);
        $trans = Transaction::first();
        $this->assertEquals($trans->date->format('d-m-Y'), Carbon::now()->format('d-m-Y'));
        $this->assertNull($trans->description);

        $value = Value::getValue();
        $this->assertEquals($value, $this->value + $this->transaction1['value']);


        Transaction::add($this->transaction2);
        $trans = Transaction::orderBy('id', 'desc')->first();
        $this->assertEquals($trans->date->format('d-m-Y'), Carbon::yesterday()->format('d-m-Y'));
        $this->assertNull($trans->title);

        $value = Value::getValue();
        $this->assertEquals($value, $this->value + $this->transaction1['value'] + $this->transaction2['value']);

        
        Transaction::add($this->transaction3);
        $trans = Transaction::orderBy('id', 'desc')->first();
        $this->assertEquals($trans->date->format('d-m-Y'), Carbon::tomorrow()->format('d-m-Y'));
        $this->assertEquals($trans->credit_card, 0);

        $value = Value::getValue();
        $this->assertEquals($value, $this->value + $this->transaction1['value'] + $this->transaction2['value'] + $this->transaction3['value']);

        $this->assertEquals($this->transaction3['date'], $trans->date);
        $this->assertEquals($this->transaction3['value'], $trans->value);
        $this->assertNull($trans->description);
        $this->assertNull($trans->title);
        $this->assertNull($trans->to);
        $this->assertEquals($this->transaction3['from'], $trans->from);
        $this->assertEquals($this->transaction3['credit_card'], $trans->credit_card);
    }

    public function testArrayOfTransactions()
    {
        $count = Transaction::count();
        $value = Value::getValue();

        $array = [$this->transaction1, $this->transaction2, $this->transaction3];
        Transaction::add($array);

        $this->assertEquals(Transaction::count(), $count + 3);

        $this->assertEquals(Value::getValue(), $value + $this->transaction1['value'] + $this->transaction2['value'] + $this->transaction3['value']);
    }
}