<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Time extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'time';

    protected $fillable = [
        'date', 'start', 'finish','amount'
    ];
    protected function getAll(){
        return Time::all();
    }
}
