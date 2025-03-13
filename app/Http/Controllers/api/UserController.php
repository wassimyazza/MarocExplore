<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     */


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return User::where('id',$id)->get();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // return $request;
        $data = $request->validate([
            "name" => "required",
            "email" => "required",
            "password" => "required"
        ]);

        $user = User::find($id);

        $user->update([
            "name" => $data['name'],
            "email" => $data['email'],
            "password" => bcrypt($data['password']),
        ]);

        return response()->json([
            "message" => "user updated successfully!"
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::destroy($id);
        return response()->json([
            "message" => "user removed successfully!"
        ], 200);
    }
}
