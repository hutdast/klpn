<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    protected $fillable = ['username','title','start_date','end_date','school','location'];
    protected $dates = ['start_date','end_date'];
}

    