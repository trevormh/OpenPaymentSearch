@extends('layouts.default')
@section('content')
    @if ($enableSearch == true)
    <div>
        @include('pages.search.typeahead')

        <div>
            @if (count($results) > 0)
                <h2 class="text-center">Search Results</h2>
                <div>
                    <h2 class="text-center"></h2>
                    <table class="table">
                        <thead>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Amount</th>
                            <th>Date</th>
                        </thead>
                        <tbody>
                        @foreach($results as $result)
                        <tr>
                            <td>{{$result->id}}</td>
                            <td>{{$result->physician_first_name}}</td>
                            <td>{{$result->physician_last_name}}</td>
                            <td>{{$result->total_amount_of_payment_usdollars}}</td>
                            <td>{{$result->date_of_payment}}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $results->appends($_GET)->links() }}
                </div>
            @else
                No results found
            @endif
        </div>


    </div>
    @else
        No data has been loaded
    @endif
@stop