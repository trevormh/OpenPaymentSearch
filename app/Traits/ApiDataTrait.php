<?php 

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;


trait ApiDataTrait
{

    /**
     * Staring point for API requests. 
     * Gathers the parameters and resources to make an API request
     * 
     * @param integer $dataSourceId
     * @return void
    */
    public function retrieveData(int $dataSourceId) : array
    {
        $import_params = $this->getImportParams($dataSourceId);

        $url = $this->getRequestUrl($dataSourceId);
        $app_token = env('datasource_app_token');

        return $this->sendRequest($url,$import_params, $app_token);
    }


    /**
     * Queries DB for the correct URL to send API request from a provided dataSourceId
     *
     * @param integer $dataSourceId
     * @return string
    */
    public function getRequestUrl(int $dataSourceId) : string
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

    /**
     * Sends the API request
     *
     * @param integer $dataSourceId
     * @return string
    */
    private function sendRequest($url, $importParams, $token) : array
    {
        $limit = urlencode("$") . "limit=" . strval($importParams['limit']);   
        $offset = urlencode("$") . "offset=" . strval($importParams['offset']);
        $app_token = urlencode("$$") . "app_token=" . $token;
        $order = urlencode("$") . "order=record_id+DESC";

        $url .=  $limit . "&" . $offset . "&" . $app_token . "&" . $order;

        try {
            $response = Http::get($url);
        } catch(\Exception $e) {
            throw new Exception($e->getMessage());
        }

        return json_decode($response->body(),true);
    }
}