<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
// use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    // use HasFactory;
    protected $dates = ['start', 'end'];
    protected $fillable = ['workshop_id', 'title', 'start', 'end'];
}
