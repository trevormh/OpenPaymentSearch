<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\DataSource;

class ImportHistory extends Model
{
    public $table = 'import_history';

    protected $fillable = ['id', 'data_sources_id', 'created_at', 'updated_at'];

    public $timestamps = true;

}
