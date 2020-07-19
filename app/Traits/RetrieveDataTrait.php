<?php 

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

trait RetrieveDataTrait
{
    /*
    * Starting point to import data
    * 
    */
    public function retrieveData($dataSourceId)
    {
        $import_params = $this->getImportParams($dataSourceId);
        $url = $this->getRequestUrl($dataSourceId);
        $app_token = env('datasource_app_token');

        return $this->sendRequest($url,$import_params, $app_token);
    }


    /*
    * Returns import params that will be made on a call
    */
    public function getImportParams($dataSourceId)
    {
        // need to look up the URL to retrieve data from
        $importHistory = DB::table('import_history')
            ->where('data_sources_id',$dataSourceId)
            ->latest()
            ->first();

        if (empty($importHistory)) {
            $offset = 0;
        } else {
            $offset = $importHistory->offset + $importHistory->limit + 1;
        }

        return [
            'offset' => $offset,
            'limit' => env('request_limit')
        ];
    }


    public function getRequestUrl($dataSourceId)
    {
        // need to look up the URL to retrieve data from
        $dataSource = DB::table('data_sources')
            ->where('id',$dataSourceId)
            ->first();
        
        if (empty($dataSource)) {
            throw new Exception('No url found for data_source id ' . $dataSourceId);
        }
        return $dataSource->url;
    }


    /*
    * Sends GET request to retrieve json payload
    * @response array
    */
    private function sendRequest($url, $importParams, $token) 
    {
        $limit = urlencode("$") . "limit=" . strval($importParams['limit']);   
        $offset = urlencode("$") . "offset=" . strval($importParams['offset']);
        $app_token = urlencode("$$") . "app_token=" . $token;

        $url .=  $limit . "&" . $offset . "&" . $app_token;
        
        try {
            $response = Http::get($url);
        } catch(\Exception $e) {
            throw new Exception($e->getMessage());
        }

        return json_decode($response->body(),true);
    }

}