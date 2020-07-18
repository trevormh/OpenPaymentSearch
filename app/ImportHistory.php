<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImportHistory extends Model
{
    public $table = 'import_history';

    public $timestamps = true;

    /**
     * Get the data source (url) associated with the import
     * Foreign key is import_history.data_source_id
     */
    public function DataSource()
    {
        return $this->hasOne('App\DataSource');
    }
}
