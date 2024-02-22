@extends('layouts.app')

@section('content')
<div class="container">
    <x-table
    :headers="$headers"
    :columns="$columns"
    :entity="$entity"
    :order="$order"
    />

</div>
 
@endsection