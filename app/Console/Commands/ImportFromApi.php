<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ImportFromApi extends Command
{
    use \App\Traits\RetrieveDataTrait;
    use \App\Traits\SaveImportDataTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:fromapi {dataSourceId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Performs initial loading of the DB';

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
     */
    public function handle()
    {
        // first check if there's any data in the general_payment_data table before proceeding
        // determine if search should be displayed
        $paymentCount = DB::table('general_payment_data')
            ->count();
        
        if ($paymentCount == 0) {
            $this->startApiImport();
        } else {
            $this->info('Database already contains records. Please truncate general_payment_data and import_history tables to continue');
        }
    }


    private function startApiImport() 
    {
        $dataSourceId = $this->argument('dataSourceId');
        $this->info('Initial import of data_sources.id ' . $dataSourceId  . ' starting at: ' . Carbon::now());
        
        // for ($i=0; $i < 3; $i++) {
        $i=0;
        while (true) {

            $importParams = $this->getImportParams($dataSourceId);
            $this->info($i . ' retrieving offset ' . $importParams['offset'] . ' with limit of ' . $importParams['limit']);

            $data = $this->retrieveData($dataSourceId);
            if (!empty($data)) {
                $this->saveImportedData($dataSourceId,$data);
            } else {
                $this->info('All records have been retrieved');
                break;
            }
            // sleep(5);
            $i++;
        }

        $this->info('Finished import at ' . Carbon::now());
    }
}
