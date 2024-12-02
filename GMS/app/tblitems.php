<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tblitems extends Model
{
    protected $fillable = [
        'workshop_id',
        'product_id',
        'description',
        'item_ean',
        'item_sku',
        'quantity',
        'price',
    ];

    public function workshop()
    {
        return $this->belongsTo(Workshop::class);
    }
}
