@extends('layouts.default')
@section('content')
    @if ($enableSearch == true)
    <div>
        @include('pages.search.typeahead')
    </div>
    @else
        No data has been loaded
    @endif
@stop