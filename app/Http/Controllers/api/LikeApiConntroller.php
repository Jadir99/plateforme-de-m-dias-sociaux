<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\like;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LikeApiConntroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_poste' => 'required|Integer',
            'user_id' => 'required|Integer',
        ]);
        if ($validator->fails()){
            return response()->json(['error' =>"error"], 400);
        }
        // creat new like
        $like=new like();
        $like->date_like=Carbon::now();
        $like->user_id=$request->input('user_id');
        $like->id_poste=$request->input('id_poste');
        $like->save();
        return response()->json(['message' => 'like  created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $likes=like::where('id_poste', $id)->get();
        if(!$likes)
            return  response()->json(['erreur'=>'the like of the poste not found'],404); 
        return response()->json(['likes_poste'=>$likes],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $like= like::find($id);
        if(!$like)
            return response()->json(['error' =>'not found'], 400);
        $like->delete();
        return response()->json(['success' =>'the like was deleted'], 200);
    }
}
