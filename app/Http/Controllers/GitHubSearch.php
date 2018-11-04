<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\Terms;

class GitHubSearch extends Controller
{
    /**
     * Method for that receives term name and url of the provider that the term will be searched on
     * @param $termName
     * @param $providerUrl
     * @return array($resPositive, $resNegative)
     * @throws
     */

    public function provider($termName, $providerUrl)
    {
        // Init Guzzle client
        $client = new Client();

        // Api calls on provider url
        $resNegative = json_decode($client->request('GET', "$providerUrl?q='$termName%20sucks'")->getBody()->getContents());
        $resPositive = json_decode($client->request('GET', "$providerUrl?q='$termName%20rocks'")->getBody()->getContents());

        // Return of api calls results
        return array($resPositive, $resNegative);
    }

    /**
     * Method for getting asked term
     * @param $request
     * @return array(['term'=>$databaseTerms->title, 'score'=>$databaseTerms->grade]);
     * @throws
     */

    public function index(Request $request)
    {
        // Query on database who checks if term already exist in database
        $databaseTerms = Terms::where('title', $request->term)->first();

        // Condition which check if Term was found in database or not
        if(!empty($databaseTerms)){
            // If term was found return database info
            return response()->json([
                'term'=>$databaseTerms->title,
                'score'=>$databaseTerms->grade
            ]);
        } else {
            // If term was not found init new Query and fill it with data
            $newTerm =  new Terms();
            $newTerm->title = $request->term;

            // Run method to call api's for data
            $results = $this->provider($request->term, 'https://api.github.com/search/issues');

            // Insert returned data into variables
            $resPositive = $results[0];
            $resNegative = $results[1];

            // Logic for calculating grade
            $calcTotal = $resPositive->total_count + $resNegative->total_count;
            if($calcTotal != 0){
                $grade = $calcTotal / $resPositive->total_count;

                if ($grade > 10){
                    $grade = 10;
                }
            } else {
                $grade = 0;
            }

            // Insert calculated grade into new query and call save query to database
            $newTerm->grade = $grade;
            $newTerm->save();

            // Return term info
            return response()->json([
                'term'=>$newTerm->title,
                'score'=>round($grade,2)
            ]);
        }

    }
}
