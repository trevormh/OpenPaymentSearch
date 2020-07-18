<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ImportDataController extends Controller
{
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
        
        $imports = DB::table('import_history')
            ->select('import_history.created_at','data_sources.name','data_sources.url')
            ->join('data_sources','import_history.data_sources_id','=','data_sources.id')
            ->get();

        return view('pages.import.index',[
            'dataSources' => $dataSources,
            'imports' => $imports
        ]);
    }

}
