<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Bio extends Model
{
    protected $fillable = ['username','motto','short_intro','self_description'];
    
  
}
