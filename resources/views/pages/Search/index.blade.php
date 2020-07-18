@extends('layouts.default')
@section('content')
    @if ($enableSearch == true)
        Search enabled
    @else
        No data has been loaded
    @endif
@stop