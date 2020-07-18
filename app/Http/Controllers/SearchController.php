<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GeneralPaymentData;

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
        $paymentCount = \DB::table('general_payment_data')
            ->count();

        return view('pages.search.index',[
            'enableSearch' => $paymentCount > 0 ? true : false
        ]);
    }
}
