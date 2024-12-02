<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Customer extends Model
{
	use SoftDeletes;
	protected $fillable = [
		'customer_name',
		'customer_contact_number',
		'customer_alt_number',
		'customer_email',
		'customer_address',
	];

	protected $guarded = ['_token', 'id', 'created_at', 'updated_at', 'deleted_at'];
	protected $dates = ['deleted_at'];
}
