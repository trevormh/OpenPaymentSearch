<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ImportHistory;
use App\DataSource;

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
        $dataSources = DataSource::all();
        $imports = ImportHistory::all();

        return view('pages.import.index',[
            'dataSources' => $dataSources,
            'imports' => $imports
        ]);
    }

}
