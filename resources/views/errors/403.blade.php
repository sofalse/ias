@extends('layouts/bare', ['overflow' => 'hidden'])

@section('content')
<div class="h-fill d-flex flex-column align-items-center justify-content-center">
<h1>Error {{ $exception->getStatusCode() }}</h1>
    <h2>{{ $exception->getMessage() }}</h2>
</div>
@endsection