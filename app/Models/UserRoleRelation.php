<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRoleRelation extends Model
{
   protected $table = "api_user_role_relation";
   protected $fillable = [
     'id',
     'user_id',
     'role_id',
   ];
}
