<?php 

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Log;
use App\GeneralPaymentData;

trait SaveImportDataTrait
{
    use \App\Traits\DataModiferTrait;

    /**
     * Saves records to the import_history table
     * Receives an array of data which will be broken into smaller chunks for database insertion
     * 
     * @param array $importParams
     * @return void
    */
    private function saveImportHistory(array $importParams): void
    {
        DB::table('import_history')->insert([
            'data_sources_id' => 1,
            'limit' => $importParams['limit'],
            'offset' => $importParams['offset'],
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        return;
    }

        /**
     * This method verifies the general_payment_data records and import_history table are in sync with each other
     * in order to prevent data duplication from API calls with overlapping offsets.
     * If a mismatch is detected an import_history record will be created.
     * 
     * @param integer $file
     * @return void
     */
    private function verifyImportHistory(int $dataSourceId) : void
    {
        $this->info('Verifying import history');
        // find the last record in general_payment_data table
        $paymentCount = GeneralPaymentData::count();
        // find the last record in import_history table
        $importHistory = DB::table('import_history')
            ->latest()
            ->first();

        // if there are payment records found but no import history, create a new import history record
        if ($paymentCount > 0 && empty($importHistory)) {
            $this->info('Import history mistmatch, creating record in import_history table');
            $this->saveImportHistory([
                'limit' => 0,
                'offset' =>  $paymentCount // will be the new starting point
            ]);
            return;
        }  

        // there are payments available, check that the import params match the count in the general_payments table
        if (!empty($importHistory)) {
            $importParams = $this->getImportParams($dataSourceId);

            // If the offset and payment count match, and there's no limit set on the last import_history record the import is verified
            if (($importParams['offset'] - 1) == $paymentCount && $importHistory->limit == 0) {
                $this->info('Import history verified');
                return;
            }

            // If the offset doesn't match the count insert a new record into import_history
            // Offset is the new starting point, subtract 1 to determine last ending record
            if (($importParams['offset'] - 1) !== $paymentCount) {
                $this->info('Import history mistmatch, creating record in import_history table');
                $this->saveImportHistory([
                    'limit' => 0,
                    'offset' => $paymentCount
                ]);
                return;
            }
        }
    }

    /**
     * Updates import_history records
     * 
     * @param integer $id
     * @param array $importParams
     * @return void
    */
    private function updateImportHistory(int $id, array $importParams) : void
    {
        DB::table('import_history')
            ->where('id', $id)
            ->update([
                'limit' => $importParams['limit'],
                'offset' => $importParams['offset'],
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        return;
    }

    /**
     * Saves records to the general_payment_data table
     * Receives an array of data which will be broken into smaller chunks for database insertion
     * 
     * @param array $data
     * @return void
    */
    private function savePaymentData(array $data) : void
    {
        // data chunk is the number of records at once to be saved by MySQL
        $dataChunkSize = env('SQL_CHUNK_SIZE');
        
        while (!empty($data)) {
            $chunk = array_splice($data,0,$dataChunkSize);            
            DB::table('general_payment_data')
                ->insert($chunk);
        }
        return;
    }
}