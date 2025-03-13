<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DirectionController extends Controller
{


    public function index(){
        return DB::table('directions')->leftJoin('distinations','directions.id','=','distinations.id_direction')->get();
    }

    public function addDirection(Request $request){



        $data = $request->validate([
            'title' => 'required',
            'categorie' => 'required',
            'duration' => 'required',
            'img_src' => 'required',
            'destinations' => 'required'
        ]);
        $getId = DB::table('directions')->insertGetId([
            "title" => $data['title'],
            "categorie" => $data['categorie'],
            "duration" => $data['duration'],
            "img_src" => $data['img_src'],
        ]);

        foreach($data['destinations'] as $destination){

            DB::table('distinations')->insert([
                "title" => $destination['dis_name'],
                "place" => $destination['place'],
                "id_direction" => $getId
            ]);
        }

        return response()->json([
            "message" => "direction has been created successfuly"
        ],201);
    }

    
}
