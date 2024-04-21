<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\poste;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class posteApiConntroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $users=poste::all();
        return response()->json(['poste' => $users], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'text_poste' => 'required|string',
            'user_id' => 'required|Integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' =>"kjnkjnjnkjn"], 400);
        }

        $poste = new poste();
        // $poste->id_poste = $request->input('id_poste');
        $poste->text_poste = $request->input('text_poste');
        $poste->user_id = $request->input('user_id');
        $poste->Date_creation = Carbon::now();
        $poste->save();

        return response()->json(['message' => 'poste created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
