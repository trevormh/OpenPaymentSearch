<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AddDbIndexes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'UpdateDb:AddIndexes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adds indexes to the database';

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
        $this->info('Adding DB indexes');

        $dbName = env('DB_DATABASE', 'open_payments_search');

        try {
            $charset = config("database.connections.mysql.charset",'utf8mb4');
            $collation = config("database.connections.mysql.collation",'utf8mb4_unicode_ci');
            // config(["database.connections.mysql.database" => 'open_payment_data']);
            config(["database.connections.mysql.database" => $dbName]);
            
            $query = "ALTER TABLE general_payment_data
            ADD INDEX(physician_first_name),
            ADD INDEX(physician_last_name),
            ADD INDEX(submitting_applicable_manufacturer_or_applicable_gpo_name),
            ADD INDEX(date_of_payment),
            ADD INDEX(recipient_state),
            ADD INDEX(recipient_city),
            ADD INDEX(total_amount_of_payment_usdollars),
            ADD INDEX(payment_publication_date);";

            DB::statement($query);
            config(["database.connections.mysql.database" => $dbName]);

            $this->info('Database indexes added successfully');
        } catch (\Exception $e) {
            $this->info('Failed to create database ' . $dbName);
            $this->info('Exception: ' . $e);
        }
    }
}
