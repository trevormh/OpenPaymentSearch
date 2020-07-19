<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\GeneralPaymentData;

class ImportFromFile extends Command
{
    use \App\Traits\RetrieveDataTrait;
    use \App\Traits\SaveImportDataTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:fromfile {--filepath=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * Execute the console command.
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
            $this->startFileImport();
        } else {
            $this->info('Database already contains records. Please truncate general_payment_data and import_history tables to continue');
        }
    }

    private function startFileImport() 
    {           
        if (!empty($this->options()['filepath'])) {
            $filepath = $this->options()['filepath'];
        } else {
            $filepath = base_path() . '/storage/import_data/General_Payment_Data___Detailed_Dataset_2019_Reporting_Year.csv';
        }

        $this->info('Starting import at : ' . Carbon::now());
        
        $i = 0;
        foreach ($this->readCSVGenerator($filepath) as $line) {
            if ($i == 0 ) { // get the field names
                $fieldNames = $line;
                $i++;
                continue;
            } else {
                $data = array_change_key_case(array_combine($fieldNames, $line));
                $data['name_of_third_party_entity_receiving_payment_or_transfer_of_valu'] = $data['name_of_third_party_entity_receiving_payment_or_transfer_of_value'];
                unset($data['name_of_third_party_entity_receiving_payment_or_transfer_of_value']);
                // print_r($data);die();
                // $transformedData = $this->initiateTransform($data);
                DB::table('general_payment_data')->insert($data);
            }
            $this->info("row number " . $i);
            $i++;
        }
        DB::table('import_history')->insert([
            'data_sources_id' => 1,
            'limit' => 0,
            'offset' => $i-1, // the first row was the heading of the csv
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        $this->info('All data imported');
    }

    
    private function readCSVGenerator($file) {
        $handle = fopen($file, "r");
        while (!feof($handle)) {
            yield fgetcsv($handle);
        }
        fclose($handle);
    }
}
