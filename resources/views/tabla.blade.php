@extends('layouts.app')

@section('content')
<div class="container">
    <x-table
    :headers="$headers"
    :columns="[]"
    :entity="'a'"
    />

</div>
 
@endsection