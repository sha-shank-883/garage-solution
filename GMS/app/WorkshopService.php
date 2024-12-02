<?php

namespace App;
use App\tblitems;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class WorkshopService extends Model
{
	// use SoftDeletes;
	// protected $table = 'patient_details';
	protected $guarded = ['_token', 'id', 'created_at', 'updated_at', 'deleted_at'];
	protected $fillable = [
		'first_name',
		'last_name',
		'email',
		'phone_number',
		'reg_number',
		'postcode',
		'address',
		'city',
		'country',
		'payment_method',
		'calendar_details',
	];
	// protected $guarded = ['id', 'created_at', 'updated_at','deleted_at'];
	protected $dates = ['deleted_at'];
	public function items()
	{
		return $this->hasMany(tblitems::class);
	}
}
