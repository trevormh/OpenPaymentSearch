<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\DataSource;

class ImportDataController extends Controller
{
    use \App\Traits\RetrieveDataTrait;
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
        
        $imports = DB::table('import_history')
            ->select('import_history.created_at','data_sources.name','data_sources.url')
            ->join('data_sources','import_history.data_sources_id','=','data_sources.id')
            ->get();

        return view('pages.import.index',[
            'dataSources' => $dataSources,
            'imports' => $imports
        ]);
    }

    
    /*
    * Endpoint to import data
    */
    public function import(Request $request, $dataSourceId)
    {
        $request->merge(['id' => $dataSourceId]);
        $validator = Validator::make($request->all(),[
            'id' => 'integer|exists:data_sources,id'
        ]);

        $data = $this->retrieveData($dataSourceId);
        
        $this->saveImportedData($data);

        return redirect('/import');
    }

}
