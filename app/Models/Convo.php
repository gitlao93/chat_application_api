<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Convo extends Model
{
    use HasFactory;
    protected $primaryKey = 'convo_id';


    public function group()
    {
        return $this->belongsTo(Group::class, 'convo_id');
    }
}
