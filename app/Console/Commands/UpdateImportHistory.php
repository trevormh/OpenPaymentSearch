<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\DataSource;

class UpdateImportHistory extends Command
{
    use \App\Traits\SaveImportDataTrait;
    // use \App\Traits\DataModiferTrait;

    private $dataSourceId = null;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'UpdateDb:UpdateImportHistory {--dataSourceId=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adds a record to the import history ';

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

        $this->info('Updating Import History');

        
        if (!empty($this->options()['dataSourceId'])) {
            $dataSourceId = $this->options()['dataSourceId'];
        } else {
            $dataSourceId = env('DEFAULT_DATASOURCE_ID');
        }

        $dataSource = DataSource::where('id',$dataSourceId)
            ->first();
        if (empty($dataSource)) {
            $this->info('Invalid dataSourceId provided');
            return;
        }

        // verify partial imports and set a new import_history record if necessary
        $this->verifyImportHistory($dataSourceId);
        
        $this->info('Import history updated');

        return;
    }
}
