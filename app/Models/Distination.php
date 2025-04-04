<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distination extends Model
{
    use HasFactory;


    protected $fillable = [
        'title',
        'place',
        'id_direction'
    ];

    public function direction(){
        return $this->belongsTo('direction');
    }
}
