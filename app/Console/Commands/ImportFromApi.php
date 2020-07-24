<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\GeneralPaymentData;

/**
 * This class is used to import data from the Open Payments data API.
 */
class ImportFromApi extends Command
{
    use \App\Traits\ApiDataTrait;
    use \App\Traits\SaveImportDataTrait;

    private $dataSourceId = null;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Import:FromApi {--dataSourceId=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetches data from the API';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Creates a MySQL database named open_payments_search
     *
     * @return int
     * @return void
     */
    public function handle(): void
    {
        $this->info('ImportFromApi handle');

        // the datasourceID corresponds to a General Payment dataset
        // the dataSourceId is db record containing the URL to be called in data_sources table
        if (!empty($this->options()['dataSourceId'])) {
            $dataSourceId = $this->options()['dataSourceId'];
        } else {
            $dataSourceId = env('DEFAULT_DATASOURCE_ID');
        }

        $this->verifyImportHistory($dataSourceId); // verify partial imports and set a new import_history record if necessary
        $this->startApiImport($dataSourceId);
        return;
    }


    /**
     * After all setup work is complete this method will continually make API calls until an empty data set is returned
     * 
     * @param integer $file
     * @return void
     */
    private function startApiImport(int $dataSourceId) : void
    {
        $this->info('Starting import of data_sources.id ' . $dataSourceId  . ' starting at: ' . Carbon::now());
        
        $i=1; // counter for tracking # of API calls and iterations performed
        while (true) { // fetch until there is no more data returned by the api

            $data = $this->retrieveData($dataSourceId); // method in ApiDataTrait
            $importParams = $this->getImportParams($dataSourceId);
            // still more data to save...
            if (!empty($data)) {
                if (!isset($data['error'])) {
                    $transformedData = $this->initiateTransform($data);
                    $this->savePaymentData($transformedData);
                    $this->saveImportHistory($importParams);
                } else {
                    $this->info('Error importing from API ' . print_r($data,true));
                    break;
                }
            } elseif (empty($data)) {
                $this->info('No new records found to be imported');
                return;
            } else {
                // the last iteration likely doesn't have a full set up to the limit
                // fetch the import params again with the size of the data array to get the correct offset
                if (count($data) !== $importParams['limit']) {
                    $importParams = $this->getImportParams($dataSourceId, count($data));
                }
                $this->saveImportHistory($importParams);
                $this->info('All records have been retrieved');
                break;
            }
            $this->info($i . ' retrieved offset ' . $importParams['offset'] . ' with limit of ' . $importParams['limit']);
            $i++;
        }
        $this->info('Finished import at ' . Carbon::now());
        return;
    }

}
