<?php 

namespace App\Traits;

use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal;
use App\Transformers\ImportDataTransformer;

/**
 * Trait to facilitate misc. data manipulation
 */
trait DataModiferTrait
{

    /**
     * Calls fractal to format data returned by API response
     *
     * @param integer $dataSourceId
     * @return string
    */
    private function initiateTransform(array $data) : array
    {
        $fractal = new Manager();
        $resource = new Fractal\Resource\Collection(collect($data), new ImportDataTransformer);
        return $fractal->createData($resource)->toArray()['data'];
    }

    /**
     * Determines the parameters (offset & limit) to be used for API requests
     *
     * @param integer $dataSourceId
     * @param integer $arrSize
     * @return array
    */
    public function getImportParams($dataSourceId, $arrSize = null) : array
    {
        // need to look up the URL to retrieve data from
        $importHistory = DB::table('import_history')
            ->where('data_sources_id',$dataSourceId)
            ->latest()
            ->first();

        if (empty($importHistory)) {
            $offset = 0;
        // the results returned didn't reach the limit
        } elseif ($arrSize !== null) {
            $offset = $importHistory->offset + $arrSize + 1;
        } else {
            $offset = $importHistory->offset + $importHistory->limit + 1;
        }

        return [
            'offset' => $offset,
            'limit' => env('REQUEST_LIMIT')
        ];
    }

}