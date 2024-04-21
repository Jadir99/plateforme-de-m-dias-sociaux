<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\hashtag;
use App\Models\hashtag_poste;
use App\Models\poste;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isEmpty;

class posteApiConntroller extends Controller
{


    // private function for hashtags 
    function extractHashtags($text)
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
private function removeHashtags($text)
{
    // Regular expression to match hashtags
    $pattern = '/#(\w+)/';

    // Remove hashtags from the text using regular expression
    $textWithoutHashtags = preg_replace($pattern, '', $text);

    return $textWithoutHashtags;
}

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

        $hashtags=$this->extractHashtags($request->input('text_poste'));

        if ($hashtags!=NULL){
            $hashtags_used=[];
            // callfunction of insertion hashtag 
            foreach ($hashtags as $hashtag){
                
                if (!hashtag::where('hashtag', $hashtag)->exists()){
                    $newHashtag=new hashtag();
                    $newHashtag->hashtag = $hashtag;
                    $newHashtag->save();
                    echo $newHashtag->id;
                    array_push($hashtags_used,$newHashtag->id); 

                }else {
                    $hashtag=hashtag::where('hashtag', $hashtag)->firstOrFail();
                    $hashtags_used[]=$hashtag->hashtag_id; 
                    echo $hashtag->hashtag_id;
                }
            }
        }
        // l'ajout en joinre table 
        foreach ($hashtags_used as $hashtag){
            $new_hashtag_poste=new hashtag_poste();
            $new_hashtag_poste->date_ajout= Carbon::now();
            $new_hashtag_poste->id_poste=$request->input('user_id');
            $new_hashtag_poste->hashtag_id= $hashtag;
            $new_hashtag_poste->save();
        }
        if ($validator->fails()) {
            return response()->json(['error' =>"kjnkjnjnkjn"], 400);
        }

        $poste = new poste();
        // $poste->id_poste = $request->input('id_poste');
        $poste->text_poste = ($request->input('text_poste'));
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
