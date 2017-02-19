<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Value extends Model {

	protected $table = 'values';
	public $timestamps = true;

	use SoftDeletes;

	protected $dates = ['deleted_at'];
	protected $fillable = array('value');

	public static function set(float $value)
	{
		$instance = self::create(['value' => $value]);
		return $instance;
	}

	public static function getLast()
	{
		return self::orderBy('id', 'desc')->first();
	}

	public static function add(float $value)
	{
		return self::withdraw(-$value);
	}

	public static function withdraw(float $value)
	{
		$balance = self::getValue();
		$newValue = $balance - $value;

		self::set($newValue);

		return $newValue;
	}

	public static function getValue()
	{
		return self::getLast()->value;
	}

	public static function getLastTwo()
	{
		return self::orderBy('id', 'desc')->limit(2)->get();
	}

}