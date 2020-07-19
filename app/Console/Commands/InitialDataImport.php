<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class InitialDataImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:initialimport';

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
        
    }
}
