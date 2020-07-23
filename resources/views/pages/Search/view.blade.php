@extends('layouts.default')
@section('content')
    <div>
        @if (count($payment) > 0)
            <h2 class="text-center">Payment</h2>

            </form>
            <div>
                <h2 class="text-center"></h2>
                <table class="table">
                    <thead>
                        <th>Field</th>
                        <th>Value</th>
                    </thead>
                    <tbody>
                    @foreach($payment as $key => $value)
                    <tr>
                        <td>{{  str_replace('_', ' ', $key) }}</td>
                        <td>{{ $value }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @else
            ID not found
        @endif
    </div>
    
@stop