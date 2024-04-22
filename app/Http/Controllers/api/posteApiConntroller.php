<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\hashtag;
use App\Models\hashtag_poste;
use App\Models\poste;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isEmpty;

class posteApiConntroller extends Controller
{


    // private function for hashtags 
    function extracthashtags($text)
{
    // Regular expression to match hashtags
    $pattern = '/#(\w+)/';

    // Array to store extracted hashtags
    $hashtags = [];

    // Extract hashtags from the text using regular expression
    preg_match_all($pattern, $text, $matches);

    // Store the extracted hashtags in the array
    if (!empty($matches[1])) {
        $hashtags = $matches[1];
    }

    return $hashtags;
}
// function to remaove hashtags from poste text :
private function removehashtags($text)
{
    // Regular expression to match hashtags
    $pattern = '/#(\w+)/';

    // Remove hashtags from the text using regular expression
    $textWithouthashtags = preg_replace($pattern, '', $text);

    return $textWithouthashtags;
}

    public function index()
    {
        
        $users=poste::all();
        return response()->json(['poste' => $users], 201);
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

        $hashtags=$this->extracthashtags($request->input('text_poste'));

        if ($hashtags!=NULL){
            $hashtags_used=[];
            // callfunction of insertion hashtag 
            foreach ($hashtags as $hashtag){
                
                if (!hashtag::where('hashtag', $hashtag)->exists()){
                    $newhashtag=new hashtag();
                    $newhashtag->hashtag = $hashtag;
                    $newhashtag->save();
                    // echo $newhashtag->id;
                    array_push($hashtags_used,$newhashtag->id); 

                }else {
                    $hashtag=hashtag::where('hashtag', $hashtag)->firstOrFail();
                    $hashtags_used[]=$hashtag->hashtag_id; 
                    // echo $hashtag->hashtag_id;:
                }
            }
        }
        // insert the post 
        if ($validator->fails()) {
            return response()->json(['error' =>"error"], 400);
        }
        $poste = new poste();
        // $poste->id_poste = $request->input('id_poste');
        $poste->text_poste = ($request->input('text_poste'));
        $poste->user_id = $request->input('user_id');
        $poste->Date_creation = Carbon::now();
        $poste->save();
        // l'ajout en joinre table 
        foreach ($hashtags_used as $hashtag){
            if (!hashtag_poste::where('hashtag_id', $hashtag)->exists() || !hashtag_poste::where('id_poste', $poste->id_poste)->exists()){
                
                $new_hashtag_poste=new hashtag_poste();
                $new_hashtag_poste->date_ajout= Carbon::now();
                $new_hashtag_poste->id_poste= $poste->id_poste;
                $new_hashtag_poste->hashtag_id= $hashtag;
                $new_hashtag_poste->save();
            }
        }
        return response()->json(['message' => 'poste created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    // all postes of user 
    public function show(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'poste not found'], 404);
        }

        // Retrieve reclamations of the poste
        $postes = $user->all_postes;

        return response()->json(['poste' => $postes], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    // update an poste d'une 
    public function update(Request $request, string $id)
{
    // Validate the request data
    $validator = Validator::make($request->all(), [
        'text_poste' => 'required|string',
    ]);

    // If validation fails, return error response
    if ($validator->fails()) {
        return response()->json(['error' => 'Validation failed'], 400);
    }

    // Extract hashtags from the text
    $hashtags = $this->extracthashtags($request->input('text_poste'));

    // Initialize array to store hashtag IDs
    $hashtags_used = [];

    // Iterate over extracted hashtags
    foreach ($hashtags as $hashtag) {
        // Check if the hashtag already exists
        $existinghashtag = hashtag::where('hashtag', $hashtag)->first();

        if (!$existinghashtag) {
            // If the hashtag doesn't exist, create a new one
            $newhashtag = new hashtag();
            $newhashtag->hashtag = $hashtag;
            $newhashtag->save();
            $hashtags_used[] = $newhashtag->id;
        } else {
            // If the hashtag exists, use its ID
            $hashtags_used[] = $existinghashtag->id;
        }
    }

    // Find the poste by ID
    $poste = poste::where('id_poste', $id)->first();

    // If the poste doesn't exist, return error response
    if (!$poste) {
        return response()->json(['error' => 'poste not found'], 404);
    }

    // Update the text_poste attribute of the poste
    $poste->text_poste = $request->input('text_poste');
    $poste->update();

    // Add hashtags to the pivot table
    foreach ($hashtags_used as $hashtagId) {
        // Check if the association doesn't exist yet
        if (!hashtag_poste::where('hashtag_id', $hashtagId)->where('id_poste', $poste->id_poste)->exists()) {
            // Create a new association
            $newhashtag_poste = new hashtag_poste();
            $newhashtag_poste->date_ajout = Carbon::now();
            $newhashtag_poste->id_poste = $poste->id_poste;
            $newhashtag_poste->hashtag_id = $hashtagId;
            $newhashtag_poste->update();
        }
    }

    // Return success response
    return response()->json(['message' => 'poste updated successfully'], 200);
}


    public function destroy(string $id)
    {
        // delete the poste 
        $poste = poste::find($id);
        if ($poste==NULL){
            return response()->json(['error 404' => 'poste not found'], 404);
        }
        $poste->delete();
        return response()->json(['message' => 'poste deleted successfully'], 200);
    }
}
