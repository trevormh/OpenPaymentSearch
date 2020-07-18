<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DataSourcesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('data_sources')->insert([
            'name' => '2019 Data',
            'url' => 'https://openpaymentsdata.cms.gov/resource/p2ve-2ws5.json',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
