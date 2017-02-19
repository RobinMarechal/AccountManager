<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Transaction extends Model {

	protected $table = 'transactions';
	public $timestamps = true;

	use SoftDeletes;

	protected $dates = ['deleted_at', 'date'];
	protected $fillable = array('date', 'value', 'description', 'title', 'to', 'from', 'credit_card');

	public static function add(array $array)
	{
		if(isset($array[0]) && is_array($array[0]))
		{
			foreach($array as $a)
				self::add($a);
		}
		else
		{
			$trans = self::create($array);
			Value::add($array['value']);
		}
	}

	public static function getLast()
	{
		return self::orderBy('id', 'desc')->first();
	}

	public static function createFromTransfert(Transfert $transfert)
	{
		if(isset($transfert[0]))
		{
			foreach($transfert as $t)
				self::createFromTransfert($t);
		}
		else
		{
			$array = $transfert->toArray();
			$array['transfert_id'] = $transfert->id;
			self::add($array);
		}
	}

}