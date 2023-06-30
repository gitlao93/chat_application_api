<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    protected $primaryKey = 'group_id';

    public function members(){
        return $this->hasMany(GroupMember::class, 'group_id');
    }
}
