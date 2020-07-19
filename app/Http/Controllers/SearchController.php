<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GeneralPaymentData;
use Illuminate\Support\Facades\DB;
use Log;
use Rap2hpoutre\FastExcel\FastExcel;

class SearchController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // determine if search should be displayed
        $paymentCount = DB::table('general_payment_data')
            ->first();
        
        if ($request->has('field') && $request->has('q')) {
            $field = $request->get('field');
            $search = $request->get('q');
            $results = GeneralPaymentData::where($field, 'LIKE', '%'. $search. '%')
                ->paginate(20);
        } else {
            $results = [];
        }

        return view('pages.search.index',[
            'enableSearch' => !empty($paymentCount) ? true : false,
            'results' => $results,
            'request_params' => json_encode($request->all(),true)
        ]);
    }


    public function search(Request $request)
    {
        Log::info('searching...');
        $field = $request->get('field');
        $search = $request->get('q');
        $result = GeneralPaymentData::select($field)
            ->where($field, 'LIKE', '%'. $search. '%')
            ->limit(25)
            ->get();

            return response()->json($result);
    }

    private function exportGenerator($params) {
        $payments = GeneralPaymentData::where($params->field, 'LIKE', '%'. $params->q. '%')->cursor();
        foreach ($payments as $payment) {
            yield $payment;
        }
    }


    public function export(Request $request)
    {
        if ($request->has('request_params')) {
            $params = json_decode($request->get('request_params'));
            return (new FastExcel($this->exportGenerator($params)))->download('export.xlsx');
        } else {
            return back();
        }
    } 

}
