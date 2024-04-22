<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\hashtag_poste;
use Illuminate\Http\Request;

class Hashtag_posteApiConntroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // existe pas
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // using hashtag id to show all postes by hashtag
        $postes_byhashtag=hashtag_poste::where('hashtag_id',$id)->get();
        if($postes_byhashtag==NULL)return response()->json(['errer'=>'erreur'],400);
        return response()->json(['postes'=>$postes_byhashtag],200);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
