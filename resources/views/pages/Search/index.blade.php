@extends('layouts.default')
@section('content')
    <div>
        @include('pages.search.typeahead')

        <div>
            @if (count($results) > 0)
                <h2 class="text-center">Search Results</h2>
                <form method="POST" type="submit" action="/search/export" download="export.xls">
                    @csrf
                    <input type="hidden" name="request_params" value="{{ $request_params}}"></input>
                    <button>Export XLS</button>
                </form>
                <div>
                    <h2 class="text-center"></h2>
                    <table class="table">
                        <thead>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Amount</th>
                        </thead>
                        <tbody>
                        @foreach($results as $result)
                        <tr>
                            <td><a href="search/view/{{ $result->id }}">{{ $result->id }}</a></td>
                            <td>{{$result->physician_first_name}}</td>
                            <td>{{$result->physician_last_name}}</td>
                            <td>{{$result->total_amount_of_payment_usdollars}}</td>
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
    
@stop