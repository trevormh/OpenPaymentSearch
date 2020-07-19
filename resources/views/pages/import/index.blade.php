@extends('layouts.default')

@section('content')

    <!-- data sources table -->
    <div>
        @if (count($dataSources) > 0)
        <div>
            <h2 class="text-center">Data sources</h2>
            <table class="table">
                <thead>
                    <th>Name</th>
                    <th>URL</th>
                    <th></th>
                </thead>
                <tbody>
                @foreach($dataSources as $data)
                <tr>
                    <td>{{$data->name}}</td>
                    <td>{{$data->url}}</td>
                    <td>
                        <form method="POST" action="/import/{{ $data->id }}">
                        @csrf
                        <button>Update</submit>
                        </form>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div>
            No data sources have been loaded
        </div>
        @endif
    </div>

    <br>

    <!-- import history table -->
    <div>
        <h2 class="text-center">Import History</h2>
        @if (count($imports) > 0)
        <div>
            <h2 class="text-center"></h2>
            <table class="table">
                <thead>
                    <th>ID</th>
                    <th>Data Set</th>
                    <th>Offset</th>
                    <th>Limit</th>
                    <th>Import Datetime</th>
                </thead>
                <tbody>
                @foreach($imports as $import)
                <tr>
                    <td>{{$import->id}}</td>
                    <td>{{$import->name}}</td>
                    <td>{{$import->offset}}</td>
                    <td>{{$import->limit}}</td>
                    <td>{{$import->created_at}}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @else
            No data has been imported
        @endif
    </div>
@stop