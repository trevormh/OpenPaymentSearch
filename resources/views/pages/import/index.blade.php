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
                    <th>Status</th>
                </thead>
                <tbody>
                @foreach($dataSources as $data)
                <tr>
                    <td>{{$data->name}}</td>
                    <td>{{$data->url}}</td>
                    <td>Status</td>
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
        <h2 class="text-center">Imported Data</h2>
        @if (count($imports) > 0)
        <div>
            <h2 class="text-center"></h2>
            <table class="table">
                <thead>
                    <th>Data Set Name</th>
                    <th>Import Datetime</th>
                </thead>
                <tbody>
                @foreach($imports as $import)
                <tr>
                    <td>{{$import->name}}</td>
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