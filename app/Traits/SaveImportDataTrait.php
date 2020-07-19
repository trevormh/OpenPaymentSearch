<?php 

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;

use League\Fractal;
use App\Transformers\ImportDataTransformer;
use Carbon\Carbon;
use Log;

trait SaveImportDataTrait
{
    use RetrieveDataTrait;

    /*
    * Starting point to import data
    * 
    */
    public function saveImportedData($dataSourceId, $data)
    {
        $transformedData = $this->initiateTransform($data);

        $this->saveGeneralPayment($transformedData);

        $importParams = $this->getImportParams($dataSourceId);
        
        // on initial import and additional updates the sum of records may not be the entire limit
        // Ex: limit was 5000 but 2000 results were returned
        // The count of the records should replace the requested limit in order to keep track for the next starting point (offset)
        if (count($transformedData) < $importParams['limit']) {
            $importParams['limit'] = count($transformedData);
        }
        // save record to import_history table
        DB::table('import_history')->insert([
            'data_sources_id' => $dataSourceId,
            'limit' => $importParams['limit'],
            'offset' => $importParams['offset'],
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }

    private function initiateTransform($data)
    {
        $fractal = new Manager();

        $resource = new Fractal\Resource\Collection($data, new ImportDataTransformer);

        return $fractal->createData($resource)->toArray()['data'];
    }



    private function saveGeneralPayment($data)
    {
        $offset = 200; // number of records to save at once
        while (!empty($data)) {
            $splice = array_splice($data,0,$offset);
            if (empty($splice)) {
                break;
            }
            DB::table('general_payment_data')->insert($splice);
        }

    }

}