<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class WorkHistory extends Model
{
    protected $fillable = ['username','company','start_date','end_date','position','job_description'];
    protected $dates =['start_date','end_date'];
}

