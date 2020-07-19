<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GeneralPaymentData;
use Illuminate\Support\Facades\DB;
use Log;

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
                ->paginate(50);
        } else {
            $results = [];
        }

        return view('pages.search.index',[
            'enableSearch' => !empty($paymentCount) ? true : false,
            'results' => $results
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

}
