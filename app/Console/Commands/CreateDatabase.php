<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CreateDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'CreateDb:OpenPaymentSearch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates the open_payment_search database';

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
        $dbName = env('DB_DATABASE', 'open_payments_search');

        try {
            $charset = config("database.connections.mysql.charset",'utf8mb4');
            $collation = config("database.connections.mysql.collation",'utf8mb4_unicode_ci');
            config(["database.connections.mysql.database" => null]);
            
            $query = "CREATE DATABASE IF NOT EXISTS $dbName CHARACTER SET $charset COLLATE $collation;";
            DB::statement($query);

            $this->info('Database ' . $dbName . ' created successfully');
        } catch (\Exception $e) {
            $this->info('Failed to create database ' . $dbName);
            $this->info('Exception: ' . $e);
        }
    }
}
