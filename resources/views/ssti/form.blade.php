@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Demo SSTI Vulnerability</h2>
    <form method="POST" action="/ssti-demo">
        @csrf
        <div class="form-group">
            <label for="template">Template string:</label>
            <textarea name="template" id="template" class="form-control" rows="5">{{ old('template') }}</textarea>
        </div>
        <button type="submit" class="btn btn-danger mt-2">Render</button>
    </form>
</div>
@endsection
