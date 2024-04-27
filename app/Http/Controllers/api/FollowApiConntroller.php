<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\follow;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FollowApiConntroller extends Controller
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
        // creat new follow
        $follow=new follow();
        $follow->date_follow=Carbon::now();
        $follow->user_id=$request->input('user_id');
        $follow->id_poste=$request->input('id_poste');
        $follow->save();
        return response()->json(['message' => 'follow  created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $follows=follow::where('id_poste', $id)->get();
        if(!$follows)
            return  response()->json(['erreur'=>'the follow of the poste not found'],404); 
        return response()->json(['follows_poste'=>$follows],200);
    }

    public function update(Request $request, string $id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $follow= follow::find($id);
        if(!$follow)
            return response()->json(['error' =>'not found'], 400);
        $follow->delete();
        return response()->json(['success' =>'the follow was deleted'], 200);
    }
}
