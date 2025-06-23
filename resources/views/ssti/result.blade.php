@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Kết quả render template</h2>
    <div class="mb-3">
        <strong>Input template:</strong>
        <pre>{{ $template }}</pre>
    </div>
    <div class="alert alert-warning">
        <strong>Output:</strong><br>
        {{ $output }}
       
    </div>
    <a href="/ssti-demo" class="btn btn-secondary">Quay lại</a>
</div>
@endsection
