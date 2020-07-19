<?php 

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;

use League\Fractal;
use App\Transformers\ImportDataTransformer;


trait SaveImportDataTrait
{
    /*
    * Starting point to import data
    * 
    */
    public function saveImportedData($data)
    {
        $transformedData = $this->initiateTransform($data);
        print_r($transformedData);die();

        DB::table('general_payment_data')->insert(
            $transformedData[0]
        );
    }


    private function initiateTransform($data)
    {
        $fractal = new Manager();
        // $resource = new ImportDataTransformer($data);

        $resource = new Fractal\Resource\Collection($data, new ImportDataTransformer);

        return $fractal->createData($resource)->toArray();
    }

}