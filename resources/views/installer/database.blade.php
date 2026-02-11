@extends('layouts.installer')

@section('content')
    <h2 class="card-title text-center mb-4">Database Configuration</h2>

    <form action="{{ route('install.database.post') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Database Host</label>
            <input type="text" name="host" class="form-control" value="localhost" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Database Name</label>
            <input type="text" name="database" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Table Prefix (Optional)</label>
            <input type="text" name="prefix" class="form-control" placeholder="nx_">
        </div>

        @if($errors->has('error'))
            <div class="alert alert-danger">{{ $errors->first('error') }}</div>
        @endif

        <div class="form-footer">
            <div class="row">
                <div class="col"><a href="{{ route('install.license') }}" class="btn btn-link w-100">Back</a></div>
                <div class="col"><button type="submit" class="btn btn-primary w-100">Test & Next</button></div>
            </div>
        </div>
    </form>
@endsection
