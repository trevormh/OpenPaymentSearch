<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\DataSource;
use Session;

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


    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function fetchUpdates(Request $request, $dataSourceId)
    {
        $request->merge(['id' => $dataSourceId]);
        $validator = Validator::make($request->all(),[
            'id' => 'required|exists:data_sources,id'
        ]);
        if ($validator->fails()) {
            Session::flash('message', $validator->errors()->first()); 
            return redirect('/import');
        }

        Session::flash('message', "Because API requests and processing may take a while, in a production environment this button would trigger a scheduled worker such as RabbitMQ to process the updates in the background. To fetch updates please use the 'php artisan Import:FromApi' command from your terminal. This comand would be called by the background worker."); 
        return redirect('/import');
    }


    /**
     * Edit a single data source record
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param integer  $generalPaymentDataId
    */
    public function edit(Request $request, $dataSourceId)
    {
        $request->merge(['id' => $dataSourceId]);
        $validator = Validator::make($request->all(),[
            'id' => 'required|exists:data_sources,id'
        ]);
        if ($validator->fails()) {
            Session::flash('message', $validator->errors()->first()); 
            return redirect('/import');
        }

        $dataSource = DataSource::where('id', $dataSourceId)
            ->first();

        return view('pages.import.edit',[
            'dataSource' => $dataSource
        ]);
    }

    /**
     * Submit an edited record
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param integer  $generalPaymentDataId
    */
    public function submitEdit(Request $request, $dataSourceId)
    {
        $request->merge(['id' => $dataSourceId]);
        $validator = Validator::make($request->all(),[
            'id' => 'required|exists:data_sources,id',
            'name' => 'required:min',
            'url' => 'required'
        ]);
        if ($validator->fails()) {
            Session::flash('message', $validator->errors()->first()); 
            return redirect('/import');
        }

        $dataSource = DataSource::where('id', $dataSourceId)
            ->first()
            ->update($request->all());

        Session::flash('message', "Data Source Id {$dataSourceId} updated successfully"); 
        return redirect('/import');
    }

}
