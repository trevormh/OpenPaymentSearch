<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\GeneralPaymentData;

class ImportFromFile extends Command
{
    // use \App\Traits\ApiDataTrait;
    use \App\Traits\SaveImportDataTrait;

    private $fieldNames;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Import:FromFile {--filepath=}';

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
     *
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

    /**
     * Called by class handler to initiate the file import
     */
    private function startFileImport() : void
    {           
        if (!empty($this->options()['filepath'])) {
            $filepath = $this->options()['filepath'];
        } else {
            $filepath = base_path() . '/storage/import_data/General_Payment_Data___Detailed_Dataset_2019_Reporting_Year.csv';
        }

        $this->info('Starting import at : ' . Carbon::now());
        
        $i = 0;
        // using a generator read the file and save it to the DB
        foreach ($this->readCSVGenerator($filepath) as $batch) {
            if (empty($batch)) {
                $this->info('Batch was empty at batch number ' . $i);
            }
            $this->savePaymentData($batch); // located in SaveImportDataTrait
            $this->info("Imported batch number " . $i);
            $i++;
        } 

        // get the last entry in the table and save that id as the limit
        // this will be the starting place for the next update in the API calls
        $payments = DB::table('general_payment_data')
            ->latest()
            ->first();

        $count = GeneralPaymentData::count();
        $this->saveImportHistory([
            'limit' => $count - 1, // records start at 0, subtract one
            'offset' => 0
        ]);
        $this->info('All data imported');
    }

    /**
     * This method servies as a generator to read a csv line by line
     * Lines from the csv are batched together to be saved to keep database IO low
     * 
     * @param string $file
     * @return \Generator
     */
    private function readCSVGenerator(string $file) : \Generator
    {
        $handle = fopen($file, "r");
        
        $firstLine = true;
        $linesBatched = 0; // counter for grouping files 
        $batchSize = env('CSV_IMPORT_BATCH_SIZE'); // the number of lines from the CSV that will be grouped together
        $batchedFiles = []; // 
        $finalBatch = [];

        while (!feof($handle)) {
            $line = fgetcsv($handle);

            if (empty($line)) {
                $this->info('Empty line detected, ending import');
                yield [];
                break;
            }

            // first iteration, get CSV field names
            if ($firstLine == true ) { 
                $index = array_search("Name_of_Third_Party_Entity_Receiving_Payment_or_Transfer_of_Value",$line);
                // the field contains 65 characters, shorten to 64 to be stored by MySQL
                $line[$index] = "name_of_third_party_entity_receiving_payment_or_transfer_of_valu"; 
                $this->fieldNames = $line;
                $firstLine = false;
                continue;
            }

            // if the count 
            if (count ($finalBatch) > 0) {
                $finalBatch = [];
            }
            // change all keys to lowercase
            $data = array_change_key_case(array_combine($this->fieldNames, $line));

            // still lines to be added to the batch array...
            if ($linesBatched < $batchSize) {
                $batchedFiles[] = $data;
                $linesBatched++;
            // batch size has been filled, reset the tracking values, clear the batchedFiles array and yield the batch
            } else {
                $linesBatched = 0;
                $finalBatch = $batchedFiles;
                $batchedFiles = [];
                yield $finalBatch; 
            }
        }

        fclose($handle);
        $this->info('End of file reached');
        
        // the file will likely not end on the batch size, return the remaining results
        if ($linesBatched < $batchSize) {
            $this->info('remaining batched files: ' );
            $this->info(print_r($batchedFiles,true));
            yield $batchedFiles; 
        } 
        
    }
}
