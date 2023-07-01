<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Convo extends Model
{
    use HasFactory;
    protected $primaryKey = 'convo_id';
    protected $fillable = [
        'convo_name'
    ];


    public function group()
    {
        return $this->hasOne(Group::class);
    }
    
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
