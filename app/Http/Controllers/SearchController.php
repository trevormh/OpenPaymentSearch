<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GeneralPaymentData;
use Illuminate\Support\Facades\DB;
use Log;
use Rap2hpoutre\FastExcel\FastExcel;
use Validator;

class SearchController extends Controller
{
    use \App\Traits\DataModiferTrait;

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {        

        if ($request->has('field') && $request->has('q')) {
            $field = $request->get('field');
            $search = $request->get('q');
            $results = GeneralPaymentData::where($field, $search)
                ->orderBy('id','desc')
                ->paginate(20);
        } else {
            $results = [];
        }

        return view('pages.search.index',[
            'results' => $results,
            'request_params' => json_encode($request->all(),true)
        ]);
    }

    /** 
    * Endpoint used by typeahead to return search results
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function typeaheadSearch(Request $request)
    {
        Log::info('searching...');

        $field = $request->get('field');
        $query = $request->get('q');

        $request->merge([
            'field' => $field,
            'query' => $query
        ]);
        $validator = Validator::make($request->all(),[
            'query' => 'required'
        ]);
        if ($validator->fails()) {
            Session::flash('message', $validator->errors()->first()); 
            return redirect('/import');
        }
        $payments = GeneralPaymentData::where('physician_first_name', 'LIKE', $query. '%')
            ->orWhere('physician_last_name', 'LIKE', $query. '%')
            ->orWhere('submitting_applicable_manufacturer_or_applicable_gpo_name', 'LIKE', $query. '%')
            ->orWhere('recipient_state', 'LIKE', $query. '%')
            ->orWhere('recipient_city', 'LIKE', $query. '%')
            ->distinct()
            ->limit(10)
            ->get()
            ->toArray();
                
        $result = $this->mapQueryToField($query, $payments);

        return response()->json($result);
    }


    /**
     * Exports search results to xls file
     * @param  \Illuminate\Http\Request  $request
    */
    public function export(Request $request)
    {
        $request->merge(['request_params' => $request->get('request_params')]);
        $validator = Validator::make($request->all(),[
            'request_params' => 'required'
        ]);
        if ($validator->fails()) {
            Session::flash('message', $validator->errors()->first()); 
            return redirect('/');
        }

        $params = json_decode($request->get('request_params'));
        return (new FastExcel($this->exportGenerator($params)))->download('export.xlsx');
    }

    /**
     * generator to assist with exporting to excel
     */
    private function exportGenerator($params) : \Generator
    {
        $payments = GeneralPaymentData::where($params->field, $params->q)
                ->orderBy('id','desc')
                ->cursor();
        foreach ($payments as $payment) {
            yield $payment;
        }
    }


    /**
     * View a single record
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param integer  $generalPaymentDataId
    */
    public function view(Request $request, $generalPaymentDataId)
    {
        $request->merge(['gpd_id' => $generalPaymentDataId]);
        $validator = Validator::make($request->all(),[
            'gpd_id' => 'required|exists:general_payment_data,id'
        ]);
        if ($validator->fails()) {
            Session::flash('message', $validator->errors()->first()); 
            return redirect('/import');
        }

        $payment = GeneralPaymentData::where('id', $generalPaymentDataId)
            ->first()
            ->toArray();

        return view('pages.search.view',[
            'payment' => $payment
        ]);
    }

}
