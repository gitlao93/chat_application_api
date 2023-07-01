<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    protected $primaryKey = 'group_id';
    protected $fillable = [
        'group_name',
        'convo_id'
    ];

    public function convo()
    {
        return $this->belongsTo(Convo::class);
    }
    
    public function members()
    {
        return $this->hasMany(GroupMember::class, 'group_id');
    }
    
    public function users()
    {
        return $this->belongsToMany(User::class, 'group_members', 'group_id', 'user_id');
    }
}
