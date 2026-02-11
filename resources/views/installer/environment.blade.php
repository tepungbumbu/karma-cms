@extends('layouts.installer')

@section('content')
    <h2 class="card-title text-center mb-4">Application Settings</h2>

    <form action="{{ route('install.environment.post') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Site Name</label>
            <input type="text" name="app_name" class="form-control" value="Nexus CMS" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Site URL</label>
            <input type="url" name="app_url" class="form-control" value="{{ url('/') }}" required>
        </div>

        <div class="form-footer">
            <div class="row">
                <div class="col"><a href="{{ route('install.database') }}" class="btn btn-link w-100">Back</a></div>
                <div class="col"><button type="submit" class="btn btn-primary w-100">Save & Next</button></div>
            </div>
        </div>
    </form>
@endsection
