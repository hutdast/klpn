<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
     protected $fillable = ['username','url','for_section','birthday'];
}

