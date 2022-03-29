<?php

namespace App;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model
{
    //
    protected $table = 'Timesheet';

    public function getDateAttribute ($value){ 
        return Carbon::parse($value)->format('m/d/Y');
    }
}
