<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\commentaire ;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use function PHPSTORM_META\type;

class commentaireApiConntroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        // $auth=User::findOrFail();
        // echo $auth->id;
        // var_dump($auth->all_postes);
        // // $auth->id;
        // foreach ($auth->all_postes as $comment){
        //     echo $comment->text_poste;
        // }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'comment' => 'required|string',
            'id_poste' => 'required|Integer',
            'user_id' => 'required|Integer',
        ]);
        if ($validator->fails()){
            return response()->json(['error' =>"error"], 400);
        }
        // creat new commentaire
        $commentaire=new commentaire();
        $commentaire->date_comment=Carbon::now();
        $commentaire->user_id=$request->input('user_id');
        $commentaire->id_poste=$request->input('id_poste');
        $commentaire->comment=$request->input('comment');
        $commentaire->save();
        return response()->json(['message' => 'comment  created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $comments=commentaire::where('id_poste', $id)->get();
        if(!$comments)
            return  response()->json(['erreur'=>'the comment of the poste not found'],404); 
        return response()->json(['comments_poste'=>$comments],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'comment' => 'required|string',
        ]);
        echo $request->input('comment');
        if ($validator->fails()){
            return response()->json(['error' =>"error"], 400);
        }
        // creat new commentaire
        $commentaire= commentaire::find($id);
        if(!$commentaire)
            return response()->json(['error' =>'not found'], 400);
        $commentaire->comment=$request->input('comment');
        $commentaire->update();
        return response()->json(['message' => 'comment  updated successfully'], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $commentaire= commentaire::find($id);
        if(!$commentaire)
            return response()->json(['error' =>'not found'], 400);
        $commentaire->delet();
        return response()->json(['success' =>'the commentaire was deleted'], 200);
    }
}
