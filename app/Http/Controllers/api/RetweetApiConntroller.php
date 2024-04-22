<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\retweet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RetweetApiConntroller extends Controller
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
            'response' => 'required|string',
            'id_poste' => 'required|Integer',
            'user_id' => 'required|Integer',
        ]);
        if ($validator->fails()){
            return response()->json(['error' =>"error"], 400);
        }
        // creat new retweet
        $retweet=new retweet();
        $retweet->date_retweet=Carbon::now();
        $retweet->user_id=$request->input('user_id');
        $retweet->id_poste=$request->input('id_poste');
        $retweet->response=$request->input('response');
        $retweet->save();
        return response()->json(['message' => 'response  created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $retweet=retweet::where('id_poste', $id)->get();
        if(!$retweet)
            return  response()->json(['erreur'=>'the response of the poste not found'],404); 
        return response()->json(['retweet_poste'=>$retweet],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'response' => 'required|string',
        ]);
        if ($validator->fails()){
            return response()->json(['error' =>"error"], 400);
        }
        // creat new retweet
        $retweet= retweet::find($id);
        if(!$retweet)
            return response()->json(['error' =>'not found'], 400);
        $retweet->response=$request->input('response');
        $retweet->update();
        return response()->json(['message' => 'response  updated successfully'], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $retweet= retweet::find($id);
        if(!$retweet)
            return response()->json(['error' =>'not found'], 400);
        $retweet->delete();
        return response()->json(['success' =>'the retweet was deleted'], 200);
    }
}
