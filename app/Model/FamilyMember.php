<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class FamilyMember extends Model
{
    protected $fillable = ['firstname','lastname','nickname','phone','social_media','birthday','address'];
    //set birthday as a carbon object
    protected $dates =['birthday'];


    

//    //Set a mutator on birthday so it can be store as Carbon object
//    public function setBirthdayAttribute($date) 
//        {
//            $this->attributes['birthday'] = Carbon::createFromFormat('Y-m-d', $date);
//        }
//    //Set a mutator on social media so there are no escape characters from the urls
//    public function setSocialMediaAttribute($param) 
//     {
//        $this->attributes['social_media'] = str_replace("/", "~", $param);
//    }
//    public function setAddress($param) 
//     {
//        $this->attributes['address'] = serialize($param);
//        
//    }
//    
}


 