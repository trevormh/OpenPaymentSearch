<?php 

namespace App\Traits;

use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal;
use App\Transformers\ImportDataTransformer;
use Illuminate\Support\Str;

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

    

    protected function mapQueryToField($query, $payments)
    {
        $indexedFields = [
            'physician_first_name',
            'physician_last_name',
            'submitting_applicable_manufacturer_or_applicable_gpo_name',
            'recipient_state',
            'recipient_city'
        ];


        $fields = [];
        // loop through each row and find which field is the closest match
        foreach ($payments as $payment)
        {
            foreach ($payment as $key => $v) {
                if (!in_array($key, $indexedFields)) {
                    continue;
                }
                if(strpos(strtolower($v), strtolower($query)) !== false){
                    $field = $key;
                    $value = $v;
                    $fields[Str::title($value)] = $key; // set value to the index so we'll only have unique values to choose from
                }
            }
        }

        $map = function($value, $key) {
            return [
                'field' => $key,
                'value' => $value
            ];
        };
        $mappedFields = array_map($map,array_keys($fields),$fields);

        return $mappedFields;
    }

}