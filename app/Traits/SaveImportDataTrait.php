<?php 

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;

use League\Fractal;
use App\Transformers\ImportDataTransformer;
use Carbon\Carbon;

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

        // save the data was just retrieved
        DB::table('general_payment_data')->insert($transformedData['data']);

        $importParams = $this->getImportParams($dataSourceId);

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

        return $fractal->createData($resource)->toArray();
    }

}