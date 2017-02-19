<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use \App\Transaction;
use \App\Transfert;
use \App\Value;

class ModelsTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
		resetDatabase();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testModels()
    {
        // Create Transferts;
        $transferts = factory(Transfert::class, 5)->create();
        $transfertNumber = 0;


        // ----------------------------------------------
        for($day = 1; $day < 29; $day++)
        {
            if($day == $transferts[$transfertNumber]->day)
            {
				Transaction::createFromTransfert($transferts[$transfertNumber]);
                $transaction = Transaction::getLast();
				$transaction->date = \Carbon\Carbon::create($transaction->date->format('Y'), $transaction->date->format('m'), $day);
				$transaction->save();

                $this->assertEquals($transaction->title, $transferts[$transfertNumber]->title);
                $this->assertEquals($transaction->value, $transferts[$transfertNumber]->value);
                $this->assertTrue($this->isValueUpToDate($transaction->value));
                $this->assertTrue($this->isValueUpToDate($transferts[$transfertNumber]->value));

				$transfertNumber++;
            }

            $pay = rand(0, 2);
            if($pay == 1)
            {
                $nb = rand(0, 3);
                $payments = factory(Transaction::class, $nb)->make();

                foreach($payments as $p)
                {
                    Transaction::add($p->toArray());
                    $this->assertTrue($this->isValueUpToDate($p->value));
                }
            }
        }
    }

    /**
     * Test is the field 'value' of the table 'value' is up to date
     * @return true if up to date, else otherwise
     */
    protected function isValueUpToDate()
    {
        $value = Value::getLast()->value;
        $sum = Transaction::sum('value') + account()->base_value;

        return abs($value - $sum) <= 1 ;
    }
}
