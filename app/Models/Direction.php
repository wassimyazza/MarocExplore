<?php

namespace App\Models;

use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Direction extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'title',
        'categorie',
        'duration',
        'img_src'
    ];


    public function distinations(){
        return $this->hasMany('distination');
    }

}
