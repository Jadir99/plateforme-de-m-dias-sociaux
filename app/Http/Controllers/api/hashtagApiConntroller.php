<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\hashtag;
use App\Models\hashtag_poste;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class hashtagApiConntroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hashtags=hashtag::all();
        return response()->json(['hashtags'=>$hashtags],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'hashtag_text' => 'required|string',
        ]);
        if ($validator->fails()){
            return response()->json(['error' =>"error"], 400);
        }
        // creat new hashtag
        $hashtag=new hashtag();
        $hashtag->hashtag=$request->input('hashtag_text');
        $hashtag->save();
        return response()->json(['message' => 'hshtag created successfully'], 201);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $hashtag=hashtag::find($id);
        if (!$hashtag)
            return response()->json(['erreur'=>'the hashtag not found'],404);
        
        return response()->json(['hashtag'=>$hashtag],200);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'hashtag_text' => 'required|string',
        ]);
        echo $request->input('hashtag_text');
        if ($validator->fails()){
            return response()->json(['error' =>"error"], 400);
        }
        // creat new hashtag
        $hashtag= hashtag::find($id);
        if(!$hashtag)
            return response()->json(['error' =>'not found'], 404);
        $hashtag->hashtag=$request->input('hashtag_text');
        $hashtag->update();
        return response()->json(['message' => 'hshtag updated successfully'], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $hashtag=hashtag::find($id);
        if(!$hashtag)
            return response()->json(['error' =>"error"], 400);
        $hashtag->delete();
        return response()->json(['message' => 'hashtag deleted successfully'], 200);
    }
}
