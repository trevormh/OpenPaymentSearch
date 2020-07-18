<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataSource extends Model
{
    public $table = 'data_sources';

    protected $fillable = ['id', 'name','url', 'created_at', 'updated_at'];

    public $timestamps = true;

}
