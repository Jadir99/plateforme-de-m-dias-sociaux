<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MediaApiConntroller extends Controller
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
        $validator = Validator::make($request->all(), [
            'path_media' => 'required|string',
            'type_media' => 'required|string',
            'id_poste' => 'required|Integer',
        ]);
        // insert the post 
        if ($validator->fails()) {
            return response()->json(['error' =>"error"], 400);
        }
        $media=new media();
        $media->id_poste=$request->input('id_poste');
        $media->type_media=$request->input('type_media');
        $media->path_media=$request->input('path_media');
        $media->save();
        return response()->json(['success' =>"the media created succus"],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $media=media::find($id);
        if($media==NULL)
            return response()->json(['error' =>"not found"], 404);
        return response()->json(['media' =>$media],201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
        $validator = Validator::make($request->all(), [
            'path_media' => 'required|string',
            'type_media' => 'required|string',
        ]);
        // insert the post 
        if ($validator->fails()) {
            return response()->json(['error' =>"error"], 400);
        }
        
        $media=media::find($id);
        if($media==NULL){
            return response()->json(['error' =>"error"],400);
        }
        $media->type_media=$request->input('type_media');
        $media->path_media=$request->input('path_media');
        $media->update();
        return response()->json(['success' =>"the media updated succus"],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $media=media::find($id);
        if($media==NULL){
            return response()->json(['error' =>"error"],400);
        }
        $media->delete();
        return response()->json(['success' =>'media deleted'],200);
    }
}
