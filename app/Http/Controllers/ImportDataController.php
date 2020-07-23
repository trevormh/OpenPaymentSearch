<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\DataSource;


class ImportDataController extends Controller
{
    use \App\Traits\ApiDataTrait;
    use \App\Traits\SaveImportDataTrait;

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $dataSources = DB::table('data_sources')
            ->get();
        
        // history of imported data
        $imports = DB::table('import_history')
            ->select('import_history.id','import_history.limit','import_history.offset','import_history.created_at','data_sources.name','data_sources.url')
            ->join('data_sources','import_history.data_sources_id','=','data_sources.id')
            ->orderByDesc('import_history.id')
            ->paginate(25);

        return view('pages.import.index',[
            'dataSources' => $dataSources,
            'imports' => $imports
        ]);
    }
}
