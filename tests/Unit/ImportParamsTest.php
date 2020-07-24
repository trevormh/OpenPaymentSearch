<?php

/**
 * To run this test by itself enter: 
 * phpunit vendor\bin\phpunit --filter --filter ImportParamsTest
 */

namespace Tests\Unit;

use Tests\TestCase;
use App\ImportHistory;

class ImportParamsTest extends TestCase
{
    use \App\Traits\SaveImportDataTrait;
    use \App\Traits\DataModiferTrait;

    /**
     * This tests that the importParams method of the DataModiferTrait calculates the correct 
     * offset and Limit for making API requests
     *
     * @return void
     */
    public function testImportParams()
    {   
        $testLimit = rand(1000,10000);
        $testOffset = rand(1000,10000);
        
       // first add some rows to the import_history table
       $id = $this->addRecordToImportHistory($testLimit,$testOffset);

       // now get the import params
       $importParams = $this->getImportParams(env('DEFAULT_DATASOURCE_ID')); // data set id 1

       $expectedOffset = $testLimit + $testOffset + 1;
       $expectedLimit = $testLimit;

       $this->assertEquals($expectedOffset, $importParams['offset']);

       $this->deleteTestRecord($id);
    }


    private function addRecordToImportHistory($limit, $offset)
    {
        $record = ImportHistory::create([
            'data_sources_id' => 1,
            'limit' => $limit,
            'offset' => $offset
        ]);
        return $record->id;
    }

    private function deleteTestRecord($id)
    {
        $import = ImportHistory::find($id);
        $import->delete();
    }
}
