@extends('layouts.default')

@section('content')

    <div>
        <h2 class="text-center">Edit Data Source ID {{ $dataSource->id }}</h2>

        <table class="table">
            <thead>
                <th>Name</th>
                <th>Url</th>
                <th></th>
            </thead>
            <tbody>
                <tr>
                    <form method="POST" action="/import/edit/{{ $dataSource->id }}">
                        @method('PUT')
                        @csrf
                        <td>
                            <input name="name" id="name" type="text" class="@error('name') is-invalid @enderror" value="{{$dataSource->name}}"></input>
                        </td>
                        <td>
                            <input name="url" style="width:500px;" id="url" type="text" class="@error('url') is-invalid @enderror" value="{{$dataSource->url}}"></input>
                        </td>
                        <td>
                            <button>Submit</submit>
                        </td>
                    </form>
                </tr>
            </tbody>
        </table>

    </div>
    
@stop