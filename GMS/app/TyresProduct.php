<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;


class TyresProduct extends Model
{

    // use SoftDeletes;
    protected $table = 'tyres_product';
    // Disable automatic timestamps
    public $timestamps = false;

    // Specify custom timestamp columns
    const CREATED_AT = 'date_added';
    const UPDATED_AT = 'date_modified';
    protected $primaryKey = 'product_id'; // If 'product_id' is the primary key

    // Fillable fields for mass assignment
    protected $fillable = [
        'product_id',
        'sku',
        'manufacturer_id',
        'price',
        'model',
        'tyre_width',
        'tyre_profile',
        'tyre_diameter',
        'description',
        'ean',
        'quantity',
        'image',
        'price_fullyfitted'
        // Add other fields as needed
    ];
}
