<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Follow extends Model
{
    use HasFactory;


    public function followingUsers () {
      return $this -> belongsTo(User::class,'followedUser'); 
    }

    public function followersUsers () {
        return $this -> belongsTo(User::class,'user_id'); 
     }
}
